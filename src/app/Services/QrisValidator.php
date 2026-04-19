<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Zxing\QrReader;

class QrisValidator
{
    public const RESULT_OK = 'ok';

    public const RESULT_NO_QR = 'no_qr';

    public const RESULT_NOT_QRIS = 'not_qris';

    public function validate(UploadedFile $image): array
    {

        try {
            $reader = new QrReader($image->getRealPath());
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

        if (! str_starts_with($payload, '000201')) {
            return $this->fail(
                self::RESULT_NOT_QRIS,
                'QR code terdeteksi, tapi bukan QRIS. Pastikan gambar adalah QRIS resmi dari bank atau e-wallet kamu.'
            );
        }

        if (! str_contains($payload, 'ID.CO.QRIS')) {
            return $this->fail(
                self::RESULT_NOT_QRIS,
                'QR terdeteksi sebagai EMV QR, tapi bukan QRIS Indonesia. Pastikan QR dari bank/e-wallet Indonesia (BCA, BRI, Mandiri, GoPay, DANA, dsb).'
            );
        }

        $parsed = $this->parseEmvPayload($payload);

        return [
            'status' => self::RESULT_OK,
            'payload' => $payload,
            'merchant_name' => $parsed['merchant_name'],
            'nmid' => $parsed['nmid'],
            'message' => 'QRIS valid. Terdaftar atas nama: '.($parsed['merchant_name'] ?? 'tidak diketahui'),
        ];
    }

    private function parseEmvPayload(string $payload): array
    {
        $result = ['merchant_name' => null, 'nmid' => null];
        $pos = 0;
        $length = strlen($payload);

        while ($pos < $length - 4) {
            if ($pos + 4 > $length) {
                break;
            }

            $tag = substr($payload, $pos, 2);
            $len = (int) substr($payload, $pos + 2, 2);
            $value = substr($payload, $pos + 4, $len);

            if ($tag === '59') {
                $result['merchant_name'] = trim($value);
            }

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

    private function extractNmid(string $block): ?string
    {
        $pos = 0;
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
            'status' => $status,
            'payload' => null,
            'merchant_name' => null,
            'nmid' => null,
            'message' => $message,
        ];
    }
}
