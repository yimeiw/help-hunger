<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Landing</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Basic styling for the loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.7s ease-out;
        }

        .loading-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Container for egg frames to ensure proper stacking and centering */
        #eggAnimation {
            position: relative;
            width: 160px;
            height: 210px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        /* Hide all SVG frames by default */
        .egg-frame {
            position: absolute;
            opacity: 0;
            transition: opacity 0.2s ease-in-out, transform 0.4s ease-in-out;
            will-change: opacity, transform, z-index;
            backface-visibility: hidden;
            perspective: 1000px;
        }

        /* Styling for the active egg frame */
        .egg-frame.active {
            opacity: 1;
            transform: scale(1);
            z-index: 1;
        }
        
        /* Ensure non-active frames are truly hidden and don't interfere */
        .egg-frame:not(.active) {
            z-index: 0;
        }

        /* Specific transform variations for each frame to simulate movement */
        #eggFrame1.active {
            transform: scale(1);
        }
        #eggFrame2.active {
            transform: scale(1.01) translateY(-1px);
        }
        #eggFrame3.active {
            transform: scale(1.03) translateY(-2px);
        }
        #eggFrame4.active {
            transform: scale(0.9) translateY(3px);
        }

        /* Basic styling for messages to be visible above the overlay */
        .alert-container {
            width: 80%;
            max-width: 400px;
            text-align: center;
            z-index: 10000;
            position: relative;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            color: #FFF7D9;
        }

        /* Style for the actual main content, initially hidden */
        /* #actualMainContent tidak lagi digunakan karena kita akan redirect */
        /* Anda bisa menghapus blok ini jika tidak ada konten yang ditampilkan sebelum redirect */
        #actualMainContent {
            opacity: 0;
            transition: opacity 0.7s ease-in;
        }
        #actualMainContent.visible {
            opacity: 1;
        }

    </style>
</head>
<body>

    <main>
        {{-- Loading Overlay --}}
        <div id="loadingOverlay" class="loading-overlay bg-greenbg text-creamcard font-bold">
           {{-- Display success/info/error messages --}}
            <div id="alertContainer" class="alert-container">
                @if (session('success'))
                    <div class="alert alert-success rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger bg-redb text-red-700 relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            {{-- SVG Egg Animation Frames --}}
            <div id="eggAnimation">
                <svg id="eggFrame1" class="egg-frame" width="144" height="150" viewBox="0 0 144 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="72.0193" cy="60.5355" r="58.3963" fill="#FFF7D9" stroke="#161A3A" stroke-width="4"/>
                    <ellipse cx="53.1249" cy="51.9732" rx="3.82359" ry="3.88673" fill="#161A3A"/>
                    <ellipse cx="90.596" cy="51.9732" rx="3.82359" ry="3.88673" fill="#161A3A"/>
                    <path d="M63.7036 55.8599C66.5925 59.1852 72.6253 64.022 79.7627 55.8599" stroke="#161A3A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <ellipse cx="72" cy="140.088" rx="72" ry="9" fill="#902B29"/>
                </svg>

                <svg id="eggFrame2" class="egg-frame" width="144" height="205" viewBox="0 0 144 205" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="71.9764" cy="60.3961" r="58.3963" fill="#FFF7D9" stroke="#161A3A" stroke-width="4"/>
                    <ellipse cx="48.885" cy="50.2662" rx="4.69067" ry="4.76813" fill="#161A3A"/>
                    <ellipse cx="94.8538" cy="50.2662" rx="4.69067" ry="4.76813" fill="#161A3A"/>
                    <path d="M61.8633 55.0342C65.4073 59.1136 72.8082 65.0473 81.5641 55.0342" stroke="#161A3A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <ellipse cx="72" cy="195.088" rx="72" ry="9" fill="#902B29"/>
                </svg>

                <svg id="eggFrame3" class="egg-frame" width="159" height="205" viewBox="0 0 159 205" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="79.5" cy="195.088" rx="79.5" ry="9" fill="#902B29"/>
                    <path d="M82.8916 1.99951C117.131 1.99951 145.516 35.8751 145.516 78.5151C145.515 121.155 117.131 155.03 82.8916 155.03C48.6521 155.03 20.2678 121.155 20.2676 78.5151C20.2676 35.8751 48.6519 1.99954 82.8916 1.99951Z" fill="#FFF7D9" stroke="#161A3A" stroke-width="4"/>
                    <ellipse cx="60.177" cy="55.0881" rx="4.69067" ry="5.00359" fill="#161A3A"/>
                    <ellipse cx="106.146" cy="55.0881" rx="4.69067" ry="5.00359" fill="#161A3A"/>
                    <path d="M73.1553 60.0933C76.6993 64.3741 84.1002 70.6008 92.8561 60.0933" stroke="#161A3A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <svg id="eggFrame4" class="egg-frame" width="147" height="107" viewBox="0 0 147 107" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="73.5" cy="97.0879" rx="73.5" ry="9" fill="#902B29"/>
                    <path d="M73.8105 2.33203C106.538 2.33211 132.207 23.105 132.207 47.7861C132.207 72.4673 106.538 93.2402 73.8105 93.2402C41.083 93.2402 15.4141 72.4674 15.4141 47.7861C15.4142 23.105 41.083 2.33203 73.8105 2.33203Z" fill="#FFF7D9" stroke="#161A3A" stroke-width="4"/>
                    <path d="M60.8668 47.3808C60.8668 48.3542 59.386 47.7875 57.5594 47.7875C55.7327 47.7875 54.252 48.3542 54.252 47.3808C54.252 46.4073 55.7327 45.6182 57.5594 45.6182C59.386 45.6182 60.8668 46.4073 60.8668 47.3808Z" fill="#161A3A"/>
                    <path d="M93.6544 47.3808C93.6544 48.3542 92.1736 47.9231 90.347 47.9231C88.5203 47.9231 87.0396 48.3542 87.0396 47.3808C87.0396 46.4073 88.5203 45.6182 90.347 45.6182C92.1736 45.6182 93.6544 46.4073 93.6544 47.3808Z" fill="#161A3A"/>
                    <path d="M66.7705 53.0596C69.302 56.2431 74.5883 60.8738 80.8425 53.0596" stroke="#161A3A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        {{-- Main content of the page, INI TIDAK AKAN TERLIHAT JIKA ADA REDIRECT --}}
        {{-- Anda bisa menghapus div ini jika halaman hanya berfungsi sebagai loading screen --}}
        <div id="actualMainContent" class="p-4 text-creamcard font-bold hidden">
            <h1>Selamat Datang di Halaman Utama!</h1>
            <p>Ini adalah konten utama halaman setelah loading selesai.</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                Lanjutkan
            </button>
        </div>
    </main>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.getElementById('loadingOverlay');
        const alertContainer = document.getElementById('alertContainer');
        const actualMainContent = document.getElementById('actualMainContent'); // Ini mungkin tidak lagi diperlukan jika langsung redirect
        const eggFrames = [
            document.getElementById('eggFrame1'),
            document.getElementById('eggFrame2'),
            document.getElementById('eggFrame3'),
            document.getElementById('eggFrame4')
        ];
        let currentFrameIndex = 0;
        let animationInterval;

        const showLoading = {{ session('show_loading', 'false') ? 'true' : 'false' }};

        // === PENTING: Tentukan URL redirect di sini ===
        // Gunakan fungsi route() Laravel untuk mendapatkan URL yang benar
        const redirectUrl = "{{ route('volunteer.details.show') }}";

        // Logic for showing/hiding the initial overlay and main content
        if (showLoading) {
            // Karena akan redirect, actualMainContent tidak perlu ditampilkan sama sekali
            // actualMainContent.classList.add('hidden'); // Bisa dihapus
            loadingOverlay.classList.remove('hidden');
        } else {
            // Jika tidak show loading, langsung redirect atau tampilkan konten (jika tidak ada redirect)
            // Dalam kasus ini, kita akan langsung redirect jika showLoading false
            window.location.href = redirectUrl;
            return; // Penting untuk menghentikan eksekusi script selanjutnya
        }

        if (showLoading) {
            function showCurrentEggFrame() {
                eggFrames.forEach(frame => {
                    frame.classList.remove('active');
                });
                eggFrames[currentFrameIndex].classList.add('active');
            }

            function nextFrame() {
                currentFrameIndex = (currentFrameIndex + 1) % eggFrames.length;
                showCurrentEggFrame();
            }

            showCurrentEggFrame();
            animationInterval = setInterval(nextFrame, 350); // Frame changes every 0.35 seconds

            setTimeout(() => {
                clearInterval(animationInterval);
                
                loadingOverlay.classList.add('hidden');
                
                loadingOverlay.addEventListener('transitionend', function handler() {
                    // === LOGIC REDIRECT DI SINI ===
                    window.location.href = redirectUrl; // Lakukan redirect
                    loadingOverlay.removeEventListener('transitionend', handler);
                }, { once: true });
            }, 3000); // Total display loading duration (3 seconds)
        }
    });
</script>
</html>