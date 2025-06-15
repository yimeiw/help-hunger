<x-app-layout>
    @section('title', 'Events')
    <div>
        <div class="flex justify-center items-center text-center m-12 px-96">
            <p class="text-redb font-bold text-3xl">CALL TO ACTION VOLUNTEERS!</p>
        </div>
        <div class="space-y-8 mb-10">
            {{-- Baris pertama: 2 event --}}
            <div class="grid grid-cols-2 gap-6 mr-24 ml-24 ">
                @foreach ($events->take(2) as $event)
                    <a href="{{ route('volunteer.events.create', ['event' => $event->id]) }}" class="flex flex-col bg-greenbg rounded-lg p-8 hover:bg-greenpastel transition duration-300 ease-in-out">
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
            <div class="ml-36 mr-36">
                <div class="flex gap-6 overflow-x-scroll scrollbar-hide pb-4">
                    @foreach ($events->skip(2) as $event)
                        @if($event->status == 'accepted')
                            <a href="{{ route('volunteer.events.create', ['event' => $event->id]) }}" class="flex-shrink-0 w-80 flex flex-col bg-greenbg rounded-lg p-8 h-90 justify-between hover:bg-greenpastel transition duration-300 ease-in-out">
                                <div>
                                    {{-- Gambar --}}
                                    <div class="flex items-center justify-center mb-4">
                                        @if ($event->image_path)
                                            @php
                                                $imageUrl = '';
                                                // Check if the path starts with 'assets/' (from seeder/public directory)
                                                if ($event->image_path && str_starts_with($event->image_path, 'assets/')) {
                                                    $imageUrl = asset($event->image_path);
                                                }
                                                // Otherwise, assume it's a path for storage (uploaded files)
                                                else if ($event->image_path) {
                                                    $imageUrl = $Storage::url($event->image_path);
                                                }
                                                // Fallback for null/empty path or if no image is found via the above methods
                                                else {
                                                    $imageUrl = asset('/assets/default-icon-community.svg'); // Your default image
                                                }
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="Event Image" class="w-50 h-44 object-cover rounded-lg">
                                        @else
                                            <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-32 h-32 object-cover rounded-lg">
                                        @endif
                                    </div>

                                    {{-- Konten utama --}}
                                    <p class="text-creamcard font-bold text-base mb-2">{{ $event->event_name }}</p>
                                    <div class="flex items-center gap-2 text-xs">
                                        <img src="{{ asset('assets/location-icon.svg') }}" alt="" class="w-4 h-4">
                                        <p class="font-regular text-creamcard">{{ $event->location->name }}</p>
                                    </div>

                                    <div class="flex items-center gap-2 text-xs">
                                        <img src="{{ asset('assets/calendar-icon.svg') }}" alt="" class="w-4 h-4">
                                        <p class="font-regular text-creamcard">{{ $event->start_date }} — {{ $event->start_date }}</p>
                                    </div>

                                    <p class="font-regular text-creamcard text-xs mt-1">by {{ $event->partner->partner_name }}</p>
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
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</x-app-layout>