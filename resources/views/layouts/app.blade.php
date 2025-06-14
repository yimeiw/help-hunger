<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="font-[poppins] antialiased bg-all min-h-screen">

    <!-- Navigation -->
    @livewire('navigation-menu')

    <!-- Flash Messages with SweetAlert2 -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer-app />

    <!-- Modals & Scripts -->
    @stack('modals')
    @livewireScripts
    @stack('scripts')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const originalSwalFire = Swal.fire;

        Swal.fire = function(options) {
            const defaultConfig = {
                confirmButtonColor: '#ef4444', // Tailwind's red-500 (matching redb)
                cancelButtonColor: '#d1d5db',  // Tailwind's gray-300
                background: '#fff7ed', // Tailwind's orange-50 (matching creamcard)
                color: '#991b1b', // Tailwind's red-800 (matching redb)
                iconColor: '#ef4444', // Red icon
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-xl shadow-lg',
                    title: 'text-xl font-bold text-redb',
                    htmlContainer: 'text-sm text-gray-700',
                    confirmButton: 'text-creamcard px-4 py-2 rounded hover:bg-red-700 transition',
                    cancelButton: 'text-gray-800 px-4 py-2 rounded hover:bg-greenbg-400 transition',
                    icon: 'border-2 border-redb rounded-full'
                }
            };

            const finalOptions = Object.assign({}, defaultConfig, options || {});
            return originalSwalFire(finalOptions);
        };
    </script>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])
</body>
</html>
