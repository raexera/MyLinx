<?php

namespace App\Support;

class WaHelper
{
    /**
     * Normalize Indonesian phone input into WhatsApp-compatible E.164 without "+".
     *
     *   "0812-3456-7890" → "6281234567890"
     *   "+62 812 3456 7890" → "6281234567890"
     *   "62 812 3456 7890" → "6281234567890"
     *   "8123456789" → "628123456789"
     *
     * Returns null if input is clearly not a phone number.
     */
    public static function normalize(?string $raw): ?string
    {
        if (! $raw) {
            return null;
        }

        // Strip everything that isn't a digit
        $digits = preg_replace('/\D+/', '', $raw);

        if (strlen($digits) < 8) {
            return null;
        }

        // Leading "0" → "62"
        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        // Missing country code — assume ID
        if (! str_starts_with($digits, '62')) {
            $digits = '62'.$digits;
        }

        return $digits;
    }

    /**
     * Build a wa.me deep link with pre-filled message.
     * Returns null if phone can't be normalized.
     */
    public static function link(?string $rawPhone, string $message = ''): ?string
    {
        $phone = self::normalize($rawPhone);

        if (! $phone) {
            return null;
        }

        $qs = $message ? '?text='.rawurlencode($message) : '';

        return "https://wa.me/{$phone}{$qs}";
    }
}
