<?php

namespace App\Support;

class WaHelper
{
    public static function normalize(?string $raw): ?string
    {
        if (! $raw) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $raw);

        if (strlen($digits) < 8) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        if (! str_starts_with($digits, '62')) {
            $digits = '62'.$digits;
        }

        return $digits;
    }

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
