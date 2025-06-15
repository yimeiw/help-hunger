<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
    

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Livewire Styles -->
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        /* kalender di report */

        .flatpickr-calendar {
            /* Change background of the entire calendar */
            background-color: #FFF7D9; /* Main calendar background, including padding areas */
            box-shadow: 4px 5px 0px rgb(144,43,41,1); /* Your existing shadow */
            border-radius: 10px; /* Softer corners */
            border: none;
            overflow: hidden; 
        }

        .flatpickr-months {
            background-color: #FFF7D9 !important;
            padding: 10px 0px; /* Changed from 10px 0px */
            display: flex;
            justify-content: space-between; /* Changed from just align-items: center */
            box-sizing: border-box; /* Ensure padding is included in the element's total width */
        }

        /* Specific styling for the current month/year display */
        .flatpickr-current-month {
            background-color: #FFF7D9 !important;
            color: #3F8044;
            font-size: 14px;
            text-align: center;
            display: flex; /* Make this a flex container to align month and year */
            justify-content: center; /* Center month and year within it */
            align-items: center;
            gap: 5px; /* Add a gap between month and year */
        }

        /* --- Styling for the Month Display Element (the part that LOOKS like a dropdown) --- */
        /* Ini adalah elemen yang kemungkinan besar memiliki background biru saat ini */
        .flatpickr-current-month .flatpickr-month {
            background-color: #FFF7D9 !important; /* <--- INI SANGAT PENTING */
            border-radius: 4px; /* Border radius */
            cursor: pointer; /* Menandakan ini interaktif */
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar elemen secara tak terduga */
        }

        /* Styling for the actual month TEXT (e.g., "Januari") */
        .flatpickr-current-month .flatpickr-month .cur-month {
            background-color: #FFF7D9 !important; /* <--- INI SANGAT PENTING */
            color: #3F8044 !important; /* Warna teks bulan yang terlihat */
            font-size: 16px !important; /* Ukuran font teks bulan yang terlihat */
            font-weight: bold;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background-color: #FFF7D9 !important; /* Warna background creamcard Anda */
        }

        //* --- Styling for the Month Dropdown (the <select> element) --- */
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background-color: #FFF7D9 !important; /* Warna background creamcard Anda */
            color: #3F8044 !important; /* Warna teks (misalnya hijau dari header) */
            font-size: 1px !important; /* Sesuaikan ukuran font */
            border-radius: 4px; /* Sudut sedikit melengkung */
            padding: 4px 8px; /* Padding di dalam dropdown */
            cursor: pointer;

            /* Perbaikan: Atur border secara eksplisit */
            outline: none !important; /* HILANGKAN OUTLINE BIRU DEFAULT BROWSER */

            /* Untuk menghilangkan panah default browser pada dropdown (penting untuk konsistensi) */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 12px;
           
        }

        /* Style untuk opsi-opsi dalam dropdown bulan (saat dibuka) */
        .flatpickr-current-month .flatpickr-monthDropdown-months option {
            background-color: #FFF7D9 !important; /* Background opsi */
            color: #3F8044; /* Warna teks opsi */
        }

        /* Style saat dropdown bulan di-hover atau di-focus */
        .flatpickr-current-month .flatpickr-monthDropdown-months:hover,
        .flatpickr-current-month .flatpickr-monthDropdown-months:focus {
            background-color: #FFF7D9 !important; /* <--- INI SANGAT PENTING */
            outline: none !important; /* Tetap hilangkan outline */
        }


        /* --- Styling for the Year Input (the <input> element) --- */
        .flatpickr-current-month input.cur-year {
            background-color: #FFF7D9 !important; /* Background input tahun */
            color: #3F8044 !important; /* Warna teks tahun */
            font-size: 14px !important; /* Ukuran font tahun */
            border-radius: 4px;
            padding: 4px 8px; /* Padding di dalam input tahun */
            text-align: center; /* Agar angka tahun di tengah */
            -webkit-appearance: textfield; /* Ensure input number looks like a text input */
            -moz-appearance: textfield;
            appearance: textfield;
            box-sizing: border-box; /* Include padding in width */

            /* IMPORTANT: Berikan padding-right tambahan agar panah tidak menimpa teks tahun */
            /* Sesuaikan nilai 25px ini berdasarkan ukuran panah Anda */
            padding-right: 0px;
        }

        .flatpickr-current-month .numInputWrapper span.arrowUp,
        .flatpickr-current-month .numInputWrapper span.arrowDown {
            padding: 5px;
        }
        .flatpickr-current-month .numInputWrapper span.arrowUp:after {
            border-color: #3F8044 transparent transparent !important; /* Warna panah atas */
        }
        .flatpickr-current-month .numInputWrapper span.arrowDown:after {
            border-color: transparent transparent #3F8044 !important; /* Warna panah bawah */
        }


        /* Style for the individual month header within the calendar (if using multiple months view) */
        .flatpickr-months .flatpickr-month {
            background-color: #FFF7D9 !important;
            color: #3F8044; /* Your 'greenbg' color */
        }


        /* Hide default Flatpickr SVGs */
        .flatpickr-calendar .flatpickr-prev-month svg,
        .flatpickr-calendar .flatpickr-next-month svg {
            display: none; /* Hide the original SVGs */
        }

        /* Style the arrow container and apply your custom SVG */
        .flatpickr-calendar .flatpickr-prev-month,
        .flatpickr-calendar .flatpickr-next-month {
            margin: 0 10px;
            width: 24px;   /* Set desired width of your arrow icon */
            height: 24px;  /* Set desired height of your arrow icon */
            position: relative; /* Needed for absolute positioning if using :after */
            cursor: pointer;
            display: flex; /* Use flexbox to center background image */
            align-items: center;
            justify-content: center;
        }

        /* Apply custom left arrow SVG */
        .flatpickr-calendar .flatpickr-prev-month {
            background-image: url("data:image/svg+xml,%3Csvg width='70' height='70' viewBox='0 0 70 70' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='9' y='9' width='52' height='52' rx='26' stroke='%233F8044' stroke-width='2'/%3E%3Crect x='11' y='11' width='48' height='48' rx='24' fill='%231E1E1E'/%3E%3Crect x='11' y='11' width='48' height='48' rx='24' stroke='%23D9D9D9' stroke-width='2'/%3E%3Cpath d='M39 22.5L27 35L39 47.5' stroke='white' stroke-width='5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain; /* Ensures the SVG fits within the element */

            /* Set dimensions for your custom arrow icon */
            width: 35px; /* Adjust as needed, usually smaller than 70px */
            height: 35px; /* Adjust as needed */
            cursor: pointer; /* Ensure it's clickable */
            display: flex; /* Use flexbox to center the icon */
            align-items: center;
            justify-content: center;
        }
        /* Apply custom right arrow SVG */
        .flatpickr-calendar .flatpickr-next-month {
            background-image: url("data:image/svg+xml,%3Csvg width='70' height='70' viewBox='0 0 70 70' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='9' y='9' width='52' height='52' rx='26' stroke='%233F8044' stroke-width='2'/%3E%3Crect x='11' y='11' width='48' height='48' rx='24' fill='%231E1E1E'/%3E%3Crect x='11' y='11' width='48' height='48' rx='24' stroke='%23D9D9D9' stroke-width='2'/%3E%3Cpath d='M39 22.5L27 35L39 47.5' stroke='white' stroke-width='5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain; /* Ensures the SVG fits within the element */

            transform: rotate(180deg); /* Rotate the right arrow to point right */
            width: 35px; /* Adjust as needed, usually smaller than 70px */
            height: 35px; /* Adjust as needed */
            cursor: pointer; /* Ensure it's clickable */
            display: flex; /* Use flexbox to center the icon */
            align-items: center;
            justify-content: center;
        }

        .flatpickr-weekdays {
            background-color: #FFF7D9 !important;
            height: auto; 
            padding: 8px 0; 
        }

        /* Ensure the individual weekday text is styled as well */
        .flatpickr-weekday {
            background-color: #FFF7D9 !important; 
            color: #A4A4A4 !important;
            font-size: 12px !important;
            font-weight: 500 !important; 

        }

        .flatpickr-weekdaycontainer {
            background-color: #FFF7D9 !important; 
        }

        /* --- Apply margin to ALL Flatpickr days --- */
        .flatpickr-days {
            background-color: #FFF7D9 !important; /* Set background untuk seluruh area hari */
        }

        /* Pastikan juga setiap hari individual memiliki background yang sama */
        .flatpickr-day {
            background-color: #FFF0B7 !important; /* Agar setiap 'span' hari juga memiliki background ini */
            margin: 4px 4px; 
            color: #902B29;
            border-radius: 8px; /* Rounded corners for each day */
        }

        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            background-color: rgb(63, 128, 68, 0.41) !important;
            color: #902B29; /* Your 'greyAuth' for inactive days */
            opacity: 0.8; /* Slightly dim them */
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background-color: #902B29 !important; /* Your 'redb' */
            border-color: #902B29 !important;
            color: #FFF7D9 !important; /* Your 'creamcard' */
            border-radius: 8px;
        }

        .flatpickr-day.today {
            border-color: #902B29; /* Highlight today with your 'redb' color */
            color: #902B29;
            font-weight: bold;
        }

        .flatpickr-day:hover {
            background-color: #F5C1C0 !important;
            border-color: #902B29;
            color: #902B29; /* Text color on hover, optional */
            border-radius: 8px;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen font-[poppins] antialiased bg-all">
    @livewire('navigation-menu')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                });
            });
        </script>
    @endif

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-footer-app /> {{-- Sticky footer --}}

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
