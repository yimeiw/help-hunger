<x-app-layout>
    <div class="mx-8 mt-8 mb-8">
        {{-- Tombol Kembali dan Judul --}}
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('volunteer.events.show') }}" class="flex-shrink-0">
                <svg width="44" height="44" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="9" y="9" width="52" height="52" rx="26" stroke="#3F8044" stroke-width="2"/>
                    <rect x="11" y="11" width="48" height="48" rx="24" fill="#1E1E1E"/>
                    <rect x="11" y="11" width="48" height="48" rx="24" stroke="#D9D9D9" stroke-width="2"/>
                    <path d="M39 22.5L27 35L39 47.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>

            <div class="text-center flex-grow">
                <h2 class="text-xl text-redb font-bold max-w-xl mx-auto">
                    List Events Participated (Donation)
                </h2>
            </div>
        </div>

        {{-- Filter --}}
        <div class="flex flex-col md:flex-row ms-8 mb-4 mt-12 items-center">
            <p class="font-bold text-md text-redb me-4 mb-2 md:mb-0">Filter By Date: </p>
            <div class="flex space-x-4">
                @foreach (['all', 'upcoming', 'ongoing', 'done'] as $filterOption)
                    <a href="{{ route('donatur.details.show', ['filter' => $filterOption]) }}"
                       class="py-2 px-4 rounded-full text-sm font-semibold 
                              @if(request('filter', 'all') == $filterOption) bg-redb text-white @else bg-gray-200 text-gray-700 hover:bg-gray-300 @endif">
                        {{ ucfirst($filterOption) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            @if($eventsDetail->isEmpty())
                <p class="text-creamcard text-center text-lg mt-8">You have not participated in any donation events that match this filter.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
                    @foreach ($eventsDetail as $detail)
                        @php
                            $event = $detail->event;
                        @endphp

                        <div class="flex flex-col items-center sm:flex-row gap-6 bg-greenbg rounded-lg p-8 m-6 h-auto sm:h-64 text-creamcard 
                                    hover:bg-greenpastel transition duration-300 ease-in-out shadow-md">
                            {{-- Image --}}
                            <div class="flex-shrink-0">
                                @if($event && $event->image_path)
                                    <img src="{{ asset($event->image_path) }}" alt="{{ $event->event_name ?? 'Event Image' }}" 
                                         class="w-full sm:w-36 h-32 object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="No Image" 
                                         class="w-full sm:w-36 h-32 object-cover rounded-lg">
                                @endif
                            </div>

                            {{-- Detail --}}
                            <div class="flex flex-col text-creamcard text-xs text-justify flex-grow">
                                <p class="font-bold mb-2 text-base">{{ $event->event_name ?? 'N/A' }}</p>

                                {{-- Location --}}
                                <div class="flex gap-2 text-xs mb-1 items-center">
                                    <img src="{{ asset('assets/location-icon.svg') }}" alt="Location" class="w-4 h-4">
                                    <p class="font-regular text-creamcard">{{ $event->location->address ?? 'N/A' }}</p>
                                </div>

                                {{-- Date --}}
                                <div class="flex items-center gap-2 text-xs mb-1">
                                    <img src="{{ asset('assets/calendar-icon.svg') }}" alt="Calendar" class="w-4 h-4">
                                    <p class="font-regular text-creamcard">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} — 
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                    </p>
                                </div>

                                {{-- Sertifikat --}}
                                <div class="mt-4">
                                    <a href="{{ route('certifications.download', ['eventType' => 'donation', 'eventId' => $event->id]) }}"
                                       class="inline-block bg-redb text-creamcard text-xs px-4 py-2 rounded-full hover:bg-red-700 transition">
                                        Download Certificate
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach 
                </div>
            @endif
        </div>
    </div>
</x-app-layout>