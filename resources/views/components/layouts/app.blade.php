<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Bank Sampah' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-poppins h-screen flex flex-col">
        <x-header></x-header>
        <main class="flex-1">
        {{ $slot }}
        </main>
    <x-toaster-hub/>
    @stack('scripts')
    @livewireScripts
    </body>
</html>
