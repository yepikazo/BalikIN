<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Balik.in - Temukan Barang Hilang' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script> </head>
<body class="bg-gray-100 font-sans">

    <x-navbar />

    <main class="container mx-auto px-4 py-8">
        <x-alert />

        {{ $slot }}
    </main>

    <footer class="text-center py-6 text-gray-500">
        &copy; {{ date('Y') }} Balik.in - Universitas Siliwangi
    </footer>
</body>
</html>