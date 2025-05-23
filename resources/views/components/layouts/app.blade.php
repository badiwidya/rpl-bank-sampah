<!doctype html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Bank Sampah' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-poppins h-screen flex flex-col">
        <x-header></x-header>
        <main class="flex-1">
        {{ $slot }}
        </main>
    @stack('scripts')
    @livewireScripts
    </body>
</html>
