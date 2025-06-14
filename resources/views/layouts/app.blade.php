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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Styles -->
        @livewireStyles
    </head>

    <style>
        .amount-button.selected {
            /* Example: Make the selected button stand out */
            background-color: #FFF0B7; /* A darker red, for instance */
        }

        /* Optional: You might want to remove the default onClick styling if it conflicts */
        .amount-button:active {
            /* Keep a subtle effect for actual press */
            transform: translateY(1px);
            box-shadow: 3px 4px 0px rgba(144,43,41,0.8);
        }

        .payment-method-button.selected {
            /* Example: Make the selected button stand out */
            background-color: #FFF0B7; /* A darker red, for instance */
        }

        /* Optional: You might want to remove the default onClick styling if it conflicts */
        .payment-method-button:active {
            /* Keep a subtle effect for actual press */
            transform: translateY(1px);
            box-shadow: 3px 4px 0px rgba(144,43,41,0.8);
        }
    </style>

    <body class="antialiased">

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                });
            </script>
        @endif

        <div class="min-h-screen font-[poppins] bg-all">
            @livewire('navigation-menu')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <x-footer-app />

        </div>

        @stack('modals')

        @livewireScripts

        @stack('scripts')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>
