<x-guest-layout>
    @section('title', 'Welcome')
    <script src="https://unpkg.com/alpinejs" defer></script>
    <body class="flex items-center lg:justify-center min-h-screen flex-col scroll-smooth">
        <div class="w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 mt-6">
            <main class="flex flex-col w-auto">
                <div class="flex flex-row w-full max-w-[1200px] m-7 rounded-lg overflow-hidden">           
                    <div class="flex flex-col">
                        <div class="bg-greenbg">
                            <div class="flex bg-all rounded-br-lg w-[584px] h-[125px] justify-center items-center w-full">
                                <p class=" font-bold text-redb text-4xl m-16">A WAY TO HELP OTHERS AND REDUCE HUNGER</p>
                            </div>
                        </div>

                        <div class="flex flex-row rounded-tl-lg rounded-bl-lg p-11 gap-12 bg-greenbg">
                            <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-[142px] h-[104px]">
                                <img src="{{ asset('/assets/default-icon-donations.svg') }}" alt="" class="w-10 h-10">
                                <p class=" font-bold text-lg text-redb">25.000+</p>
                                <p class=" font-bold text-xs text-redb">Donations</p>
                            </div>

                            <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-[142px] h-[104px]">
                                <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="" class="w-10 h-10">
                                <p class=" font-bold text-lg text-redb">1.200+</p>
                                <p class=" font-bold text-xs text-redb">Communities</p>
                            </div>

                            <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-[142px] h-[104px]">
                                <img src="{{ asset('/assets/default-icon-volunteer.svg') }}" alt="" class="w-10 h-10">
                                <p class=" font-bold text-lg text-redb">5.000+</p>
                                <p class=" font-bold text-xs text-redb">Volunteers</p>
                            </div>
                            
                        </div>
                    </div>

                    <div class="flex flex-row justify-center items-center rounded-tl-lg rounded-tr-lg rounded-br-lg gap-6 bg-greenbg w-full">
                        <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-40 h-50 p-6">
                            <p class=" font-light text-redb text-xs">“Being a volunteer at HelpHunger isn’t just about sharing food — it’s about sharing hope. One smile from them makes all the effort worth it.”</p>
                            <p class=" font-semibold text-redb text-xs mt-6"> — Andi, HelpHunger Volunteer</p>
                        </div>

                        <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-40 h-50 p-5">
                            <p class=" font-light text-redb text-xs">“I never imagined a simple donation could have such a big impact. HelpHunger showed me that even the smallest act of kindness can save someone’s day.”</p>
                            <p class=" font-semibold text-redb text-xs mt-6"> — Sinta, Regular Donor</p>
                        </div>

                        <div class="flex flex-col justify-center items-center bg-creamcard rounded-lg w-40 h-50 p-6">
                            <p class=" font-light text-redb text-xs">“Partnering with HelpHunger has strengthened our aid distribution. We no longer feel like we’re fighting hunger alone.”</p>
                            <p class=" font-semibold text-redb text-xs mt-6"> — Artha Graha Peduli Foundation, NGO Partner</p>
                        </div>
                    </div>
                </div>


                <div class="flex justify-center items-center">
                    <a href="#services" class="flex justify-center items-center  font-bold text-redb text-lg bg-creamcard border-redb border-2 rounded-xl w-56 h-auto p-2 hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                        Start HelpHunger
                    </a>
                </div>

                <div class="flex flex-row gap-8 w-full max-w-[1200px] m-7 rounded-lg overflow-hidden mt-16">
                    <!-- Slider -->
                    <div id="default-carousel" class="relative bg-greenbg rounded-lg w-[684px] h-[502px] " data-carousel="slide">
                        <!-- Carousel wrapper -->
                        <div class="relative h-56 overflow-hidden rounded-lg md:h-96 justify-center items-center mt-8">
                            <!-- Item 1 -->
                            <a href="{{ route('guest.events') }}" class="hidden duration-700 ease-in-out flex flex-col justify-center items-center gap-4 text-center" data-carousel-item>
                                <p class="text-creamhh font-bold text-lg px-6 pt-14">One day of your time = dozens of full stomachs!</p>
                                <img src="{{ asset('/assets/slider-image-1.svg') }}" class="w-4/5 max-w-md" alt="...">
                            </a>

                            <!-- Item 2 -->
                            <a href="{{ route('guest.donations') }}" class="hidden duration-700 ease-in-out flex flex-col justify-center items-center gap-4 text-center" data-carousel-item>
                                <p class="text-creamhh font-bold text-lg px-6 pt-14">#1 Food Donation Connecting Platform in Indonesia</p>
                                <img src="{{ asset('/assets/slider-image-2.svg') }}" class="w-4/5 max-w-md" alt="...">
                            </a>

                            <!-- Item 3 -->
                            <a href="{{ route('guest.partner') }}" class="hidden duration-700 ease-in-out flex flex-col justify-center items-center gap-4 text-center" data-carousel-item>
                                <p class="text-creamhh font-bold text-lg px-20 pt-14">With HelpHunger, your social efforts reach even more people in need!</p>
                                <img src="{{ asset('/assets/slider-image-3.svg') }}" class="w-4/5 max-w-md" alt="...">
                            </a>

                        </div>
                        <!-- Slider indicators -->
                        <div class="absolute z-30 flex -translate-x-1/2 left-1/2 rtl:space-x-reverse">
                            <button type="button" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0" class="w-6 h-6">
                                <img src="{{ asset('/assets/indicator-unactive.svg') }}" alt="Indicator 1">
                            </button>
                            <button type="button" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1" class="w-6 h-6">
                                <img src="{{ asset('/assets/indicator-unactive.svg') }}" alt="Indicator 2">
                            </button>
                            <button type="button" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2" class="w-6 h-6">
                                <img src="{{ asset('/assets/indicator-unactive.svg') }}" alt="Indicator 3">
                            </button>
                        </div>

                        
                    </div>


                    <!-- View More -->
                     <div class="">
                        <div class="flex flex-wrap gap-7 mb-4 items-start">
                            @foreach ($eventsDonation as $event)
                                <div class="border p-4 w-[34%] rounded-lg bg-greenbg hover:bg-greenpastel transition duration-300 ease-in-out flex flex-col justify-between" style="min-height: 228px;">
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

                                    <div class="flex justify-center items-center mt-4">
                                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg font-bold text-redb bg-creamhh shadow-quadrupleNonHover hover:text-greenbg hover:shadow-quadrupleHover transition duration-300 ease-in-out">Donate</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="flex-none self-end flex items-center justify-end">
                                <a href="{{ route('guest.donations') }}" class="flex flex-row items-center gap-2 text-lg font-bold text-redb border border-2 border-redb px-4 py-2 rounded-lg hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                                    View More
                                    <img src="{{ asset('/assets/next-button.svg') }}" alt="" class="w-8 h-8">
                                </a>
                            </div>
                        </div>


                        <div class="flex flex-wrap gap-7 mb-4 items-start">
                            <div class="flex-none self-end flex items-center justify-end">
                                <a href="{{ route('guest.events') }}" class="flex flex-row items-center gap-2 text-lg font-bold text-redb border border-2 border-redb px-4 py-2 rounded-lg hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                                    View More
                                    <img src="{{ asset('/assets/next-button.svg') }}" alt="" class="w-8 h-8">
                                </a>
                            </div>
                            @foreach ($eventsVolunteers as $event)
                                <div class="border p-4 w-[34%] rounded-lg bg-greenbg hover:bg-greenpastel transition duration-300 ease-in-out flex flex-col justify-between" style="min-height: 250px;">
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

                                    <div class="flex justify-center items-center mt-4">
                                        <a href="{{ route('guest.events') }}" class="px-4 py-2 rounded-lg font-bold text-redb bg-creamhh shadow-quadrupleNonHover hover:text-greenbg hover:shadow-quadrupleHover transition duration-300 ease-in-out">Volunteer</a>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                     </div>
                     
                </div>

                <!-- Our Services -->
                <div id="services" class="flex flex-col items-center justify-center">
                    <p class="font-bold text-redb text-xl p-6">Our Services</p>

                    <div class="flex flex-row gap-8 bg-greenbg rounded-lg w-auto h-auto p-12">
                        <a href="{{ route('guest.events') }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[150px] h-[205px] p-6 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                            <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="">
                            <p class="text-center text-redb font-bold text-base">Helping people with our energy</p>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                                <p class="text-creamcard font-bold text-base">Join Volunteer Now!</p>
                                <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                            </div>
                        </a>

                        <a href="{{ route('guest.donations') }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[150px] h-[205px] p-6 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                            <img src="{{ asset('/assets/default-icon-donations.svg') }}" alt="" >
                            <p class="text-center text-redb font-bold text-base">Giving people for helping</p>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/80 rounded-lg">
                                <p class="text-creamcard font-bold text-base">Donate For People!</p>
                                <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                            </div>
                        </a>

                        <a href="{{ route('guest.partner') }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[150px] h-[205px] p-6 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                            <img src="{{ asset('/assets/default-icon-volunteer.svg') }}" alt="">
                            <p class="text-center text-redb font-bold text-base">Being home for people</p>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-8 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">
                                <p class="text-creamcard font-bold text-base">Be Our Partner!</p>
                                <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Partners -->
                 <div class="flex flex-col items-center justify-center mb-8">
                    <p class="font-bold text-redb text-xl p-6 mt-4">Our Partners</p>

                    <div class="flex flex-row justify-center items-center gap-5 bg-greenbg rounded-lg max-w-[1200px] h-auto p-12">
                        @foreach ($eventsPartner as $partner)
                            <!-- Community -->
                            @if ($partner->type === 'community')          
                                <a target="_blank" rel="noopener noreferrer" href="{{ $partner->partner_link }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[108px] h-[156px] p-8 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                                    <div class="h-[40px] flex items-center">
                                        <p class="text-center text-redb font-bold text-sm leading-tight">{{ $partner->partner_name }}</p>
                                    </div>
                                    <div class="h-[60px] flex items-center mt-6">
                                        <img src="{{ asset('/assets/community-partner.svg') }}" alt="" class="object-contain max-h-full">
                                    </div>

                                    <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/90 rounded-lg">
                                        <p class="text-creamcard font-bold text-base">{{ $partner->partner_name }}</p>
                                        <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                                    </div>
                                </a>
                            <!-- NGO -->
                            @elseif($partner->type == 'ngo')
                                <a target="_blank" rel="noopener noreferrer" href="{{ $partner->partner_link }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[108px] h-[156px] p-8 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                                    <div class="h-[40px] flex items-center">
                                        <p class="text-center text-redb font-bold text-sm leading-tight">{{ $partner->partner_name }}</p>
                                    </div>
                                    <div class="h-[60px] flex items-center mt-6">
                                        <img src="{{ asset('/assets/ngo-partner.svg') }}" alt="" class="object-contain max-h-full">
                                    </div>

                                    <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/90 rounded-lg">
                                        <p class="text-creamcard font-bold text-base">{{ $partner->partner_name }}</p>
                                        <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                                    </div>
                                </a>

                            <!-- Orphanage -->
                            @elseif($partner->type == 'orphanage')
                                <a target="_blank" rel="noopener noreferrer" href="{{ $partner->partner_link }}" class="group relative flex flex-col justify-center items-center bg-creamcard w-[108px] h-[156px] p-8 rounded-lg shadow-quadrupleNonHover hover:bg-redb transition duration-300 ease-in-out">
                                    <div class="h-[40px] flex items-center">
                                        <p class="text-center text-redb font-bold text-sm leading-tight">{{ $partner->partner_name }}</p>
                                    </div>
                                    <div class="h-[60px] flex items-center mt-6">
                                        <img src="{{ asset('/assets/orphanage-partner.svg') }}" alt="" class="object-contain max-h-full">
                                    </div>

                                    <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/90 rounded-lg">
                                        <p class="text-creamcard font-bold text-base">{{ $partner->partner_name }}</p>
                                        <img src="{{ asset('/assets/next-button.svg') }}" alt="">
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        
                    </div>
                 </div>
            </main>
        </div>
    </body>

</x-guest-layout>