<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'MyLinx') }}</title>
    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="{{ asset('apple-touch-icon.png') }}"
    />
    <link
        rel="icon"
        type="image/png"
        sizes="32x32"
        href="{{ asset('favicon-32x32.png') }}"
    />
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{ asset('favicon-16x16.png') }}"
    />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
        href="https://fonts.bunny.net/css?family=instrument-serif:400,400i|inter:400,500,600,700"
        rel="stylesheet"
    />
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-serif {
            font-family: "Instrument Serif", serif;
        }
        .font-sans {
            font-family: "Inter", sans-serif;
        }
    </style>
</head>
<body
    class="font-sans text-[#1A1C19] antialiased bg-[#FBFBF9] selection:bg-[#2E5136] selection:text-white"
>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-6"
    >
        {{ $slot }}
    </div>
</body>
</html>
