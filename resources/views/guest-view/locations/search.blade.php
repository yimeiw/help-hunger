<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        

<x-guest-layout>
    @section('title', 'Search Location')
    <body>
        <div class="flex flex-row gap-96 items-center m-8">
            <a href="{{ route('guest.locations.index') }}" class="mr-10 ml-10">
                <img src="{{ asset('/assets/back-button.svg') }}" alt="" class="w-10 h-10">
            </a>
            <p class="font-bold text-xl text-redb text-center">List of Nearby Activities</p>
        </div>

        <div class="flex flex-row">
            <div class="bg-greenbg m-5 ml-28 rounded-lg p-5">
                <div id="map" class="w-96 h-96"></div>
            </div>

            <div class="flex flex-col overflow-y-auto h-96 m-5 mr-10">
                @foreach ($locations as $location)
                    <div class="bg-greenbg w-full rounded-lg mb-4">
                        @php
                            $hasVolunteers = isset($location->events_volunteers) && $location->events_volunteers->isNotEmpty();
                            $hasDonatur = isset($location->events_donatur) && $location->events_donatur->isNotEmpty();
                        @endphp

                        @if (! $hasVolunteers && ! $hasDonatur)
                            <div class="flex justify-center items-center">
                                <p class="text-gray-500 mt-2 text-lg font-regular">No events in this location.</p>
                            </div>
                        @endif
                        @if ($hasVolunteers)
                            <ul class="list-disc list-inside">
                                @foreach ($location->events_volunteers ?? [] as $event)
                                    <li class="list-none flex flex-row items-center gap-6 p-6">
                                        <div class="flex justify-center items-center">
                                            {{-- Gambar --}}
                                            @if ($event->image_path)
                                                <img src="{{ asset('/' . $event->image_path) }}" alt="{{ $event->event_name }}" class="rounded-lg">
                                            @else
                                                <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-48 h-48 rounded-lg mr-16 ml-12">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                                            @if ($event->partner)
                                                <p class="text-creamcard font-regular text-base">by {{ $event->partner->partner_name }}</p>
                                            @endif
                                            <div class="flex flex-row gap-2 items-center mt-4">
                                                <img src="{{ asset('/assets/calendar-icon.svg') }}" alt="" class="w-6 h-6">
                                                <p class="text-xs font-regular text-creamcard">{{ $event->start_date }} — {{ $event->end_date }}</p>
                                            </div>
                                            <div class="flex flex-row gap-2 items-center mt-2">
                                                <img src="{{ asset('/assets/location-icon.svg') }}" alt="" class="w-6 h-6">
                                                <p class="text-xs font-regular text-creamcard">{{ $location->name }}</p>
                                            </div>
                                            <div class="flex items-center mt-4">
                                                <a href="{{ route('register') }}" class="px-10 py-2 bg-creamcard border rounded-lg shadow-quadrupleNonHover text-redb font-bold text-base hover:shadow-quadrupleHover hover:text-greenbg"> View Detail</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach                               
                            </ul>
                        @endif
                        @if ($hasDonatur)
                            <ul class="list-disc list-inside">
                                @foreach ($location->events_donatur ?? [] as $event)
                                    <li class="list-none flex flex-row items-center gap-6 p-6">
                                        <div class="flex justify-center items-center">
                                            {{-- Gambar --}}
                                            @if ($event->image_path)
                                                <img src="{{ asset('/' . $event->image_path) }}" alt="{{ $event->event_name }}" class="rounded-lg">
                                            @else
                                                <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-48 h-48 rounded-lg mr-16 ml-12">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                                            @if ($event->partner)
                                                <p class="text-creamcard font-regular text-base">by {{ $event->partner->partner_name }}</p>
                                            @endif
                                            <div class="flex flex-row gap-2 items-center mt-4">
                                                <img src="{{ asset('/assets/calendar-icon.svg') }}" alt="" class="w-6 h-6">
                                                <p class="text-xs font-regular text-creamcard">{{ $event->start_date }} — {{ $event->end_date }}</p>
                                            </div>
                                            <div class="flex flex-row gap-2 items-center mt-2">
                                                <img src="{{ asset('/assets/location-icon.svg') }}" alt="" class="w-6 h-6">
                                                <p class="text-xs font-regular text-creamcard">{{ $location->name }}</p>
                                            </div>
                                            <div class="flex items-center mt-4">
                                                <a href="{{ route('register') }}" class="px-10 py-2 bg-creamcard border rounded-lg shadow-quadrupleNonHover text-redb font-bold text-base hover:shadow-quadrupleHover hover:text-greenbg"> View Detail</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        var locations = @json($locations);

        if (locations.length > 0) {
            map.setView([locations[0].latitude, locations[0].longitude], 13);

            locations.forEach(function(location) {
                if(location.latitude && location.longitude) {
                    var marker = L.marker([location.latitude, location.longitude]).addTo(map);

                    var popupContent = `<strong>${location.name}</strong><br>${location.address}<br>Zipcode: ${location.zipcode}`;

                    // Gabungkan semua event dari events_volunteers dan events_donatur
                    var allEvents = [];
                    if (location.events_volunteers) {
                        allEvents = allEvents.concat(location.events_volunteers);
                    }
                    if (location.events_donatur) {
                        allEvents = allEvents.concat(location.events_donatur);
                    }

                    if(allEvents.length > 0) {
                        popupContent += `<br><u>Events:</u><ul>`;
                        allEvents.forEach(function(event) {
                            popupContent += `<li>${event.event_name} (${event.start_date} - ${event.end_date})</li>`;
                        });
                        popupContent += `</ul>`;
                    }

                    marker.bindPopup(popupContent);
                }
            });
        }
    });

    </script>


</x-guest-layout>