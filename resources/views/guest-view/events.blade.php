<x-guest-layout>
    @section('title', 'Event')
    <body>
        <div class="flex text-center m-12 px-96">
            <p class="text-redb font-bold text-3xl">CALL TO ACTION VOLUNTEERS!</p>
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
                            <p class="text-creamcard font-bold text-base mb-2">{{ $event->event_name }}</p>
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/location-icon.svg') }}" alt="" class="w-4 h-4">
                                <p class="font-regular text-creamcard">{{ $event->location->name }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/calendar-icon.svg') }}" alt="" class="w-4 h-4">
                                <p class="font-regular text-creamcard">{{ $event->start_date }} — {{ $event->start_date }}</p>
                            </div>

                            <p class="font-regular text-creamcard">by {{ $event->partner->partner_name }}</p>

                            <div class="flex justify-end mb-1 text-redb font-bold text-base">
                                @if ($event->volunteer_count > 1)
                                    <p>{{$event->volunteer_count}} volunteers</p>
                                @else
                                    <p>{{$event->volunteer_count}} volunteer</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Sisanya: tampilkan dalam 3 kolom per baris --}}
            <div class="grid grid-cols-3 gap-6 ml-36 mr-36">
                @foreach ($events->skip(2)->take(3) as $event)
                    <a href="{{ route('register') }}" class="flex flex-col bg-greenbg rounded-lg p-8 h-full justify-between hover:bg-greenpastel transition duration-300 ease-in-out">
                        <div>
                            {{-- Gambar --}}
                            <div class="flex items-center justify-center mb-4">
                                @if ($event->image_path)
                                    <img src="{{ asset('/' . $event->image_path) }}" alt="Event Image" class="w-64 h-32 object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-32 h-32 object-cover rounded-lg">
                                @endif
                            </div>

                            {{-- Konten utama --}}
                            <p class="text-creamcard font-bold text-base mb-2">{{ $event->event_name }}</p>
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/location-icon.svg') }}" alt="" class="w-4 h-4">
                                <p class="font-regular text-creamcard">{{ $event->location->name }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/calendar-icon.svg') }}" alt="" class="w-4 h-4">
                                <p class="font-regular text-creamcard">{{ $event->start_date }} — {{ $event->start_date }}</p>
                            </div>

                            <p class="font-regular text-creamcard">by {{ $event->partner->partner_name }}</p>
                        </div>

                        {{-- Volunteer count selalu di bawah --}}
                        <div class="flex justify-end mt-4 text-redb font-bold text-base">
                            @if ($event->volunteer_count > 1)
                                <p>{{ $event->volunteer_count }} volunteers</p>
                            @else
                                <p>{{ $event->volunteer_count }} volunteer</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-center pl-8 pr-8 pb-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex flex-row items-center justify-center gap-24 ml-64 mr-40 text-center">
            <div class="flex flex-col items-center justify-center text-redb">
                <p class="text-3xl font-bold">#STEP 1</p>
                <p class="text-lg font-bold">Register Account</p>
                <p class="text-base font-regular">Sign up now and join as a HelpHunger volunteer to spread kindness with us!</p>
            </div>
            <div class="flex items-center justify-center">
                <hr class="border w-0 h-36 border-redb w-full flex justify-center items-center">
            </div>

            <div class="flex flex-col items-center justify-center text-redb">
                <p class="text-3xl font-bold">#STEP 2</p>
                <p class="text-lg font-bold">Choose Event</p>
                <p class="text-base font-regular">Explore nearby activities in your city that fit your schedule and location — every contribution matters!</p>
            </div>
        </div>

        <div class="flex items-center justify-center ml-96 mr-96 mb-12 mt-6">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex items-center justify-center mb-14">
            <div class="flex flex-col items-center justify-center text-redb px-96 text-center">
                <p class="text-3xl font-bold">#STEP 3</p>
                <p class="text-lg font-bold">Confirmation & Start an Action</p>
                <p class="text-base font-regular">Join the activities you choose and become part of our volunteer team — real change starts here!</p>
            </div>
        </div>

        <div class="flex items-center justify-center ml-8 mr-8 mb-14 mt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>
    </body>
</x-guest-layout>