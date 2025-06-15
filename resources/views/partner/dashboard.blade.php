<x-app-layout>
    @section('title', 'Dashboard Donatur')
    <div class="flex items-center lg:justify-center justify-center min-h-screen flex-col scroll-smooth">
        <div class="w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 mt-6">
            <main class="flex flex-col w-auto">
                <div class="flex flex-row w-auto m-7 rounded-lg overflow-hidden">           
                    <div class="flex flex-col">
                        <div class="bg-greenbg">
                            <div class="flex bg-all rounded-br-lg justify-center items-center w-full h-32">
                                <p class=" font-bold text-redb text-3xl m-10 lg:text-3xl lg:m-10 xl:text-4xl xl:m-16">A WAY TO HELP OTHERS AND REDUCE HUNGER</p>
                            </div>
                        </div>

                        <div class="flex flex-row rounded-tl-lg rounded-bl-lg p-8 lg:p-11 gap-8 bg-greenbg">
                            <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-32 h-24 lg:w-32 lg:h-24 xl:w-40 xl:h-32">
                                <img src="{{ asset('/assets/default-icon-donations.svg') }}" alt="" class="w-10 h-10">
                                <p class=" font-bold text-lg text-redb">25.000+</p>
                                <p class=" font-bold text-xs text-redb">Donations</p>
                            </div>

                            <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-32 h-24 lg:w-32 lg:h-24 xl:w-40 xl:h-32">
                                <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="" class="w-10 h-10">
                                <p class=" font-bold text-lg text-redb">1.200+</p>
                                <p class=" font-bold text-xs text-redb">Communities</p>
                            </div>

                            <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-32 h-24 lg:w-32 lg:h-24 xl:w-40 xl:h-32">
                                <img src="{{ asset('/assets/default-icon-volunteer.svg') }}" alt="" class="w-10 h-10">
                                <p class=" font-bold text-lg text-redb">5.000+</p>
                                <p class=" font-bold text-xs text-redb">Volunteers</p>
                            </div>
                            
                        </div>
                    </div>

                    <div class="flex flex-row justify-center items-center rounded-tl-lg rounded-tr-lg rounded-br-lg gap-4 md:gap-4 lg:gap-4 xl:gap-8 bg-greenbg w-full">
                        <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-48 h-52 lg:w-48 lg:h-48 xl:w-52 xl:h-52 p-6">
                            <p class=" font-light text-redb text-xs">“Being a volunteer at HelpHunger isn’t just about sharing food — it’s about sharing hope. One smile from them makes all the effort worth it.”</p>
                            <p class=" font-semibold text-redb text-xs mt-6"> — Andi, HelpHunger Volunteer</p>
                        </div>

                        <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-48 h-52 lg:w-48 lg:h-48 xl:w-52 xl:h-52 p-5">
                            <p class=" font-light text-redb text-xs">“I never imagined a simple donation could have such a big impact. HelpHunger showed me that even the smallest act of kindness can save someone’s day.”</p>
                            <p class=" font-semibold text-redb text-xs mt-6"> — Sinta, Regular Donor</p>
                        </div>

                        <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-48 h-52 lg:w-48 lg:h-48 xl:w-52 xl:h-52 p-6">
                            <p class=" font-light text-redb text-xs">“Partnering with HelpHunger has strengthened our aid distribution. We no longer feel like we’re fighting hunger alone.”</p>
                            <p class=" font-semibold text-redb text-xs mt-6"> — Artha Graha Peduli Foundation, NGO Partner</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-center items-center lg:w-auto">
                    <a href="{{ route('partner.program.show') }}" class="flex justify-center items-center font-bold text-redb text-lg bg-creamcard border-redb border-2 rounded-xl w-56 h-auto p-2 hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                        Make Events
                    </a>
                </div>

                <div class="flex flex-col lg:flex-row gap-8 m-7 rounded-lg overflow-hidden">
                    <!-- Slider -->
                    <div id="default-carousel" class="relative bg-greenbg rounded-lg w-[884px] min-h-[500px] " data-carousel="slide">
                        <!-- Carousel wrapper -->
                        <div class="relative w-full overflow-hidden rounded-lg min-h-[450px] flex justify-center items-center">
                            <!-- Item 1 -->
                            <div class="logout-slide cursor-pointer -ml-pxabsolute inset-0 hidden duration-700 ease-in-out flex flex-col justify-center items-center p-4 text-center" data-carousel-item>
                                <p class="text-creamhh font-bold text-lg mb-4">One day of your time = dozens of full stomachs!</p>
                                <img src="{{ asset('/assets/slider-image-1.svg') }}" class="w-full max-w-xl h-auto object-contain" alt="...">
                            </div>

                            <!-- Item 2 -->
                            <div class="logout-slide cursor-pointer absolute inset-0 hidden duration-700 ease-in-out flex flex-col justify-center items-center p-4 text-center" data-carousel-item>
                                <p class="text-creamhh font-bold text-lg px-6 pt-14">#1 Food Donation Connecting Platform in Indonesia</p>
                                <img src="{{ asset('/assets/slider-image-2.svg') }}" class="w-full max-w-xl h-auto object-contain" alt="...">
                            </div>

                            <!-- Item 3 -->
                            <a href="{{ route('partner.program.show') }}" class="absolute inset-0 hidden duration-700 ease-in-out flex flex-col justify-center items-center p-4 text-center" data-carousel-item>
                                <p class="text-creamhh font-bold text-lg px-6 pt-14">With HelpHunger, your social efforts reach even more people in need!</p>
                                <img src="{{ asset('/assets/slider-image-3.svg') }}" class="w-full max-w-xl h-auto object-contain" alt="...">
                            </a>

                        </div>
                        <!-- Slider indicators -->
                        <div class="absolute bottom-4 flex space-x-3 rtl:space-x-reverse left-1/2 -translate-x-1/2">
                            <button type="button" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0" class="w-6 h-6 flex items-center justify-center">
                                <img src="{{ asset('/assets/indicator-unactive.svg') }}" alt="Indicator 1">
                            </button>
                            <button type="button" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1" class="w-6 h-6 flex items-center justify-center">
                                <img src="{{ asset('/assets/indicator-unactive.svg') }}" alt="Indicator 2">
                            </button>
                            <button type="button" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2" class="w-6 h-6 flex items-center justify-center">
                                <img src="{{ asset('/assets/indicator-unactive.svg') }}" alt="Indicator 3">
                            </button>
                        </div>

                        
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>



                    <!-- View More -->
                     <div class="flex flex-col lg:w-auto lg:h-auto gap-6">
                        <!-- Donation -->
                        <div class="grid grid-cols-3 gap-6 lg:min-w-[240px] ">
                            @foreach ($eventsDonation as $event)
                                <div class="relative lg:h-auto rounded-lg bg-greenbg hover:bg-greenpastel transition duration-300 ease-in-out flex flex-col justify-between p-4">
                                    <div>
                                        <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                                        <p class="text-base font-bold text-redb">Rp{{ number_format($event->total_donation_amount, 0, ',', '.') }}</p>
 
                                         <!-- Progress Bar -->
                                        @php
                                            $target = $event->total_donation_target ?? 0; 
                                            $donationCount = $event->donation_count ?? 0;
                                            $progress = $target > 0 ? min(100, ($donationCount / $target) * 100) : 0;
                                        @endphp
 
                                        <div class="w-full bg-creamcard rounded-full h-4 overflow-hidden mt-2">
                                            @if ($donationCount > 0)
                                                <div class="bg-redb h-4 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $progress }}%"></div>
                                            @endif
                                        </div>
 
                                        <p class="text-sm font-regular text-creamcard mt-2">{{ $event->donation_count }} donation</p>
                                    </div>


                                    @auth
                                        @php
                                            $loggedInUser = Auth::user();
                                            $isDonaturLoggedInAndActive = false;

                                            // Get the currently active role from the session
                                            $currentActiveRole = session('current_active_role');

                                            if ($loggedInUser && $currentActiveRole === 'donatur') {
                                                $isDonaturLoggedInAndActive = true;
                                            }
                                        @endphp

                                        @if($isDonaturLoggedInAndActive)
                                            {{-- If the user is logged in AND their current active session role is 'donatur', direct to the donation page --}}
                                            <div class="flex justify-center items-center mt-4">
                                                <a href="#" class="px-2 py-2 rounded-lg font-bold text-redb bg-creamhh shadow-quadrupleNonHover hover:text-greenbg hover:shadow-quadrupleHover transition duration-300 ease-in-out">Donate</a>
                                            </div>
                                        @else
                                            {{-- If the user is not logged in as 'donatur' (either not logged in, or logged in with a different active role) --}}
                                            <div class="flex flex-col justify-center items-center mt-4 text-center">
                                                @if ($loggedInUser) {{-- User is logged in but not as donatur --}}
                                                    <p class="text-redb text-xs mb-2">You are logged in, but not currently as a donatur. Please login again with the 'donatur' role to donate.</p>
                                                   
                                                        
                                                        <button type="submit" class="logout-slide px-2 py-2 rounded-lg font-bold text-redb bg-creamhh shadow-quadrupleNonHover hover:text-greenbg hover:shadow-quadrupleHover transition duration-300 ease-in-out">Login as Donatur</button>
                                                @endif
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            @endforeach
                             
                            <div class="flex items-end">
                                <div class="logout-slide cursor-pointer flex justify-center items-center font-bold text-redb text-lg bg-creamcard border-redb border-2 rounded-lg w-48 h-auto p-2 hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                                    View More
                                    <img src="{{ asset('/assets/next-button.svg') }}" alt="" class="w-8 h-8">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 flex-row-reverse gap-6">
                            <div class="flex justify-end items-end ml-6">
                                <div class="logout-slide cursor-pointer flex justify-center items-center font-bold text-redb text-lg bg-creamcard border-redb border-2 rounded-lg w-48 h-auto p-2 hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                                    View More
                                    <img src="{{ asset('/assets/next-button.svg') }}" alt="" class="w-8 h-8">
                                </div>
                            </div>
                            
                            @foreach ($eventsVolunteers as $event)
                                <div class="relative lg:h-auto rounded-lg bg-greenbg hover:bg-greenpastel transition duration-300 ease-in-out flex flex-col justify-between p-4">
                                    <div>
                                        <p class="text-base font-bold text-creamcard mb-4">{{ $event->event_name }}</p>
                                        <div class="flex flex-row items-center gap-2">
                                            <img src="{{ asset('/assets/location-icon.svg') }}" alt="" >
                                            <p class="text-xs font-regular text-creamcard">{{ $event->location->name }}</p>
                                        </div>
                                        
                                        <div class="flex flex-row items-center gap-2">
                                            <img src="{{ asset('/assets/calendar-icon.svg') }}" alt="" >
                                            <p class="text-xs font-regular text-creamcard">{{ $event->start_date }} — {{ $event->end_date }}</p>
                                        </div>
                                        
                                        <p class="text-sm font-regular text-creamcard">by {{ $event->partner->partner_name }}</p>
                                        
                                        
                                        <p class="text-sm font-bold text-redb flex justify-end">{{ $event->volunteer_count }} volunteers</p>
                                    </div>
                                    
                                    @auth
                                            @php
                                                $loggedInUser = Auth::user();
                                                $isVolunteerLoggedInAndActive = false;

                                                // Get the currently active role from the session
                                                $currentActiveRole = session('current_active_role');

                                                if ($loggedInUser && $currentActiveRole === 'volunteer') {
                                                    $isVolunteerLoggedInAndActive = true;
                                                }
                                            @endphp

                                            @if($isVolunteerLoggedInAndActive)
                                                {{-- If the user is logged in AND their current active session role is 'donatur', direct to the donation page --}}
                                                <div class="flex justify-center items-center mt-4">
                                                    <a href="#" class="px-2 py-2 rounded-lg font-bold text-redb bg-creamhh shadow-quadrupleNonHover hover:text-greenbg hover:shadow-quadrupleHover transition duration-300 ease-in-out">Volunteer</a>
                                                </div>
                                            @else
                                                {{-- If the user is not logged in as 'donatur' (either not logged in, or logged in with a different active role) --}}
                                                <div class="flex flex-col justify-center items-center mt-4 text-center">
                                                    @if ($loggedInUser) {{-- User is logged in but not as donatur --}}
                                                        <p class="text-redb text-xs mb-2">You are logged in, but not currently as a volunteer. Please login again with the 'volunteer' role to donate.</p>
                                                        <form action="{{ route('partner.logout') }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <input type="hidden" name="intended_url_after_login" value="{{ route('volunteer.events.create', ['event' => $event->id]) }}">
                                                            <button type="submit" class="px-2 py-2 rounded-lg font-bold text-redb bg-creamhh shadow-quadrupleNonHover hover:text-greenbg hover:shadow-quadrupleHover transition duration-300 ease-in-out">Login as Volunteer</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif
                                        @endauth
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                     
                </div>

                <!-- Our Services -->
                <div id="services" class="flex flex-col items-center justify-center mb-12">
                    <p class="font-bold text-redb text-xl p-6">Our Services</p>

                    <div class="flex flex-row gap-8 bg-greenbg rounded-lg w-auto h-auto p-12">
                        <div class="logout-slide group relative flex flex-col justify-center items-center bg-creamcard w-[150px] h-[205px] p-6 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                            <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="">
                            <p class="text-center text-redb font-bold text-base">Helping people with our energy</p>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                                <p class="text-creamcard font-bold text-base">Join Volunteer Now!</p>
                                <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                            </div>
                        </div>

                        <div class="logout-slide cursor-pointer group relative flex flex-col justify-center items-center bg-creamcard w-[150px] h-[205px] p-6 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                            <img src="{{ asset('/assets/default-icon-donations.svg') }}" alt="" >
                            <p class="text-center text-redb font-bold text-base">Giving people for helping</p>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/80 rounded-lg">
                                <p class="text-creamcard font-bold text-base">Donate For People!</p>
                                <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                            </div>
                        </div>

                        <a href="{{ route('partner.program.show') }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[150px] h-[205px] p-6 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                            <img src="{{ asset('/assets/default-icon-volunteer.svg') }}" alt="">
                            <p class="text-center text-redb font-bold text-base">Being home for people</p>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-8 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                                <p class="text-creamcard font-bold text-base">Be Our Partner!</p>
                                <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                            </div>
                        </a>
                    </div>
                </div>

                
            </main>
        </div>

        @push('scripts')
        <script>
            window.addEventListener('load', function () {
                document.title = "HelpHunger: A Way to Help Others and Reduce Hunger";
            });

            document.addEventListener('DOMContentLoaded', function() {
                const logoutSlides = document.querySelectorAll('.logout-slide');
                const logoutForm = document.getElementById('logout-form');
                const csrfToken = logoutForm.querySelector('input[name="_token"]').value;

                // Definisikan URL halaman login Anda
                // Ganti '/login' jika route login Anda berbeda
                const loginPageUrl = '/login'; // Sesuaikan ini dengan URL halaman login Anda

                logoutSlides.forEach(slide => {
                    slide.addEventListener('click', function(event) {
                        if (this.tagName === 'A') {
                            event.preventDefault();
                        }

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You have to logout before accessing this content!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Logout!',
                            cancelButtonText: 'No, Stay Logged In'
                            // SweetAlert2 default colors/styles from your override will apply
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Mencegah submit default dari form
                                event.preventDefault();

                                // Lakukan permintaan logout secara asinkron
                                fetch(logoutForm.action, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        'X-CSRF-TOKEN': csrfToken // Kirim CSRF token
                                    },
                                    body: new URLSearchParams(new FormData(logoutForm))
                                })
                                .then(response => {
                                    // Cek apakah respons menunjukkan keberhasilan logout (misal: status 200 OK)
                                    // Perlu diingat: Laravel defaultnya akan redirect setelah logout.
                                    // Jika ada redirect 302, fetch akan mengikutinya.
                                    // Jika Anda tidak mengubah controller, fetch mungkin akan mendapatkan respon HTML dari halaman login.
                                    // Yang penting adalah request logout ke server sudah dilakukan.
                                    if (response.ok || response.redirected) {
                                        // Logout berhasil atau sudah diarahkan oleh server
                                        window.location.href = loginPageUrl; // Arahkan ke halaman login
                                    } else {
                                        // Tangani jika ada error pada proses logout
                                        console.error('Logout failed:', response.statusText);
                                        Swal.fire('Error!', 'Failed to logout. Please try again.', 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error during logout:', error);
                                    Swal.fire('Error!', 'An error occurred during logout. Please try again.', 'error');
                                });
                            }
                        });
                    });
                });
            });
        </script>
        @endpush

        @stack('scripts')
    </div>
</x-app-layout>