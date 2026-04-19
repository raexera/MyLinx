<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Zxing\QrReader;

/**
 * Validates uploaded images as legitimate QRIS (Quick Response Code Indonesian Standard) payloads.
 *
 * QRIS follows the EMV QR Code Specification format:
 *   - TLV (Tag-Length-Value) encoding
 *   - Starts with "000201" (Payload Format Indicator = 01)
 *   - Contains a merchant account info block with "ID.CO.QRIS" reverse-domain identifier
 *   - Ends with a 4-char CRC16 checksum (tag "63")
 *
 * We validate loosely — enough to reject non-QRIS images, not so strict that
 * we reject legitimate bank-issued QRIS codes with minor format quirks.
 */
class QrisValidator
{
    public const RESULT_OK       = 'ok';
    public const RESULT_NO_QR    = 'no_qr';       // Image doesn't contain a decodable QR code
    public const RESULT_NOT_QRIS = 'not_qris';    // QR decoded but isn't a QRIS payload

    /**
     * Attempt to decode and validate the uploaded image as QRIS.
     *
     * @return array{status: string, payload: ?string, merchant_name: ?string, nmid: ?string, message: string}
     */
    public function validate(UploadedFile $image): array
    {
        // Step 1: Decode QR from image
        try {
            $reader  = new QrReader($image->getRealPath());
            $payload = $reader->text();
        } catch (\Throwable $e) {
            return $this->fail(self::RESULT_NO_QR, 'Gambar tidak dapat dibaca sebagai QR code.');
        }

        if (empty($payload)) {
            return $this->fail(
                self::RESULT_NO_QR,
                'Tidak ada QR code yang terdeteksi di gambar. Pastikan gambar QRIS jelas dan tidak blur.'
            );
        }

        // Step 2: Basic EMV payload format check
        // Every EMV QR starts with "000201" (Payload Format Indicator = 01, 2 chars long)
        if (! str_starts_with($payload, '000201')) {
            return $this->fail(
                self::RESULT_NOT_QRIS,
                'QR code terdeteksi, tapi bukan QRIS. Pastikan gambar adalah QRIS resmi dari bank atau e-wallet kamu.'
            );
        }

        // Step 3: QRIS-specific marker — must contain Indonesian merchant identifier
        // Real QRIS payloads include "ID.CO.QRIS" as the reverse-domain identifier
        if (! str_contains($payload, 'ID.CO.QRIS')) {
            return $this->fail(
                self::RESULT_NOT_QRIS,
                'QR terdeteksi sebagai EMV QR, tapi bukan QRIS Indonesia. Pastikan QR dari bank/e-wallet Indonesia (BCA, BRI, Mandiri, GoPay, DANA, dsb).'
            );
        }

        // Step 4: Parse TLV blocks to extract merchant name and NMID
        $parsed = $this->parseEmvPayload($payload);

        return [
            'status'        => self::RESULT_OK,
            'payload'       => $payload,
            'merchant_name' => $parsed['merchant_name'],
            'nmid'          => $parsed['nmid'],
            'message'       => 'QRIS valid. Terdaftar atas nama: ' . ($parsed['merchant_name'] ?? 'tidak diketahui'),
        ];
    }

    /**
     * Parse EMV TLV (Tag-Length-Value) payload to extract merchant info.
     *
     * Relevant tags:
     *   - 59       : Merchant Name
     *   - 26–51    : Merchant Account Information (nested TLV with "ID.CO.QRIS" and NMID at sub-tag 02)
     */
    private function parseEmvPayload(string $payload): array
    {
        $result = ['merchant_name' => null, 'nmid' => null];
        $pos    = 0;
        $length = strlen($payload);

        while ($pos < $length - 4) { // -4 to skip trailing CRC
            if ($pos + 4 > $length) {
                break;
            }

            $tag    = substr($payload, $pos, 2);
            $len    = (int) substr($payload, $pos + 2, 2);
            $value  = substr($payload, $pos + 4, $len);

            if ($tag === '59') {
                $result['merchant_name'] = trim($value);
            }

            // Tags 26–51 are merchant-account blocks; the QRIS one contains "ID.CO.QRIS" and NMID
            if ($this->isMerchantAccountTag($tag) && str_contains($value, 'ID.CO.QRIS')) {
                $result['nmid'] = $this->extractNmid($value);
            }

            $pos += 4 + $len;
        }

        return $result;
    }

    private function isMerchantAccountTag(string $tag): bool
    {
        $num = (int) $tag;

        return $num >= 26 && $num <= 51;
    }

    /**
     * Extract NMID (National Merchant ID) from a merchant-account sub-TLV block.
     * Inside the block, NMID is at sub-tag "02".
     */
    private function extractNmid(string $block): ?string
    {
        $pos    = 0;
        $length = strlen($block);

        while ($pos < $length) {
            if ($pos + 4 > $length) {
                break;
            }

            $subTag = substr($block, $pos, 2);
            $subLen = (int) substr($block, $pos + 2, 2);
            $subVal = substr($block, $pos + 4, $subLen);

            if ($subTag === '02') {
                return trim($subVal);
            }

            $pos += 4 + $subLen;
        }

        return null;
    }

    private function fail(string $status, string $message): array
    {
        return [
            'status'        => $status,
            'payload'       => null,
            'merchant_name' => null,
            'nmid'          => null,
            'message'       => $message,
        ];
    }
}
