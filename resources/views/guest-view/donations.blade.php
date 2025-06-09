<x-guest-layout>
    @section('title', 'Donations')
    <body>
        <div class="flex items-center justify-center text-center m-12 px-96">
            <p class="text-redb font-bold text-3xl">ONE DONATION, COUNTLESS IMPACT!</p>
        </div>
        <div class="space-y-8 mb-10">
            {{-- Baris pertama: 2 event --}}
            <div class="grid grid-cols-2 gap-6 mr-24 ml-24 ">
                @foreach ($events->take(2) as $event)
                    <a href="{{ route('register') }}" class="flex flex-col bg-greenbg rounded-lg p-8 hover:bg-greenpastel transition duration-300 ease-in-out">
                        <div class="flex items-center justify-center mb-4">
                            @if ($event->image_path)
                                <img src="{{ asset('/' . $event->image_path) }}" alt="Event Image" class="w-full h-64 object-cover rounded-lg">
                            @else
                                <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-full h-64 object-cover rounded-lg">
                            @endif
                        </div>
                        <div>
                            <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                            <p class="text-base font-bold text-redb">Rp{{ number_format($event->total_donation_amount, 0, ',', '.') }}</p>

                            <!-- Progress Bar -->
                            @php
                                $target = $event->total_donation_target ?? 0; 
                                $donationCount = $event->donation_count ?? 0;
                                $volunteerCount = $event->volunteer_count ?? 0;
                                $progress = $target > 0 ? min(100, ($donationCount / $target) * 100) : 0;
                            @endphp

                            <div class="w-full bg-creamcard rounded-full h-4 overflow-hidden mt-2">
                                @if ($donationCount > 0)
                                    <div class="bg-redb h-4 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $progress }}%"></div>
                                @endif
                            </div>

                            <p class="text-sm font-regular text-creamcard mt-2">{{ $event->donation_count }} donation</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Sisanya: tampilkan dalam 3 kolom per baris --}}
            <div class="grid grid-cols-3 gap-6 ml-36 mr-36">
                @foreach ($events->skip(2)->take(3) as $event)
                    <a href="{{ route('register') }}"  class="flex flex-col bg-greenbg rounded-lg p-8 h-full justify-between hover:bg-greenpastel transition duration-300 ease-in-out">
                        <div>
                            {{-- Gambar --}}
                            <div class="flex items-center justify-center mb-4">
                                @if ($event->image_path)
                                    <img src="{{ asset('/' . $event->image_path) }}" alt="Event Image" class="w-50 h-44 object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-32 h-32 object-cover rounded-lg">
                                @endif
                            </div>

                        {{-- Konten utama --}}
                        </div>
                            <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                            <p class="text-base font-bold text-redb mt-4">Rp{{ number_format($event->total_donation_amount, 0, ',', '.') }}</p>

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
                        </a>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-center pl-8 pr-8 pb-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex flex-row items-center justify-center gap-32 ml-64 mr-48 text-center">
            <div class="flex flex-col items-center justify-center text-redb">
                <p class="text-3xl font-bold">#STEP 1</p>
                <p class="text-lg font-bold">Register Account</p>
                <p class="text-base font-regular">Register yourself as a donor on the HelpHunger platform.</p>
            </div>
            <div class="flex ml-16">
                <hr class="border w-0 h-36 border-redb w-full">
            </div>

            <div class="flex flex-col items-center justify-center text-redb">
                <p class="text-3xl font-bold">#STEP 2</p>
                <p class="text-lg font-bold">Choose Donation Type</p>
                <p class="text-base font-regular">Fill out the form to donate food or money, including details like location, quantity, or payment method.</p>
            </div>
        </div>

        <div class="flex items-center justify-center ml-96 mr-96 mb-12 mt-6">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex items-center justify-center mb-14">
            <div class="flex flex-col items-center justify-center text-redb px-96 text-center">
                <p class="text-3xl font-bold">#STEP 3</p>
                <p class="text-lg font-bold">Track & See the Impact</p>
                <p class="text-base font-regular">Your donation will be distributed through our network of volunteers and social partners. You can view the impact of your contribution directly from your account dashboard.</p>
            </div>
        </div>

        <div class="flex items-center justify-center ml-8 mr-8 mb-14 mt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>
    </body>
</x-guest-layout>