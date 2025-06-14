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
                    List Events Participated
                </h2>
            </div>
        </div>

        <div class="flex flex-col md:flex-row ms-8 mb-4 mt-12 items-center">
            <p class="font-bold text-md text-redb me-4 mb-2 md:mb-0">Filter By Date: </p>
            <div class="flex space-x-4">
                {{-- Tombol Filter --}}
                <a href="{{ route('donatur.details.show', ['filter' => 'all']) }}"
                   class="py-2 px-4 rounded-full text-sm font-semibold 
                          @if(request('filter', 'all') == 'all') bg-redb text-white @else bg-gray-200 text-gray-700 hover:bg-gray-300 @endif">
                    All
                </a>
                <a href="{{ route('donatur.details.show', ['filter' => 'upcoming']) }}"
                   class="py-2 px-4 rounded-full text-sm font-semibold 
                          @if(request('filter') == 'upcoming') bg-redb text-white @else bg-gray-200 text-gray-700 hover:bg-gray-300 @endif">
                    Upcoming
                </a>
                <a href="{{ route('donatur.details.show', ['filter' => 'ongoing']) }}"
                   class="py-2 px-4 rounded-full text-sm font-semibold 
                          @if(request('filter') == 'ongoing') bg-redb text-white @else bg-gray-200 text-gray-700 hover:bg-gray-300 @endif">
                    Ongoing
                </a>
                <a href="{{ route('donatur.details.show', ['filter' => 'done']) }}"
                   class="py-2 px-4 rounded-full text-sm font-semibold 
                          @if(request('filter') == 'done') bg-redb text-white @else bg-gray-200 text-gray-700 hover:bg-gray-300 @endif">
                    Done
                </a>
            </div>
        </div>

        <div>
            @if($eventsDetail->isEmpty())
                <p class="text-creamcard text-center text-lg mt-8">You have not participated in any events that match this filter.</p>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8"> {{-- Updated grid for better responsiveness --}}
                @foreach ($eventsDetail as $detail)
                    <a href="{{ route('donatur.details.details', ['event' => $detail->event->id]) }}"
                       class="block group"> 
                        <div class="flex flex-col items-center sm:flex-row gap-6 bg-greenbg rounded-lg p-8 m-6 h-auto sm:h-64 text-creamcard 
                                    hover:bg-greenpastel transition duration-300 ease-in-out shadow-md">
                            {{-- Image Section --}}
                            <div class="flex-shrink-0">
                                @if($detail->event && $detail->event->image_path)
                                    <img src="{{ asset($detail->event->image_path) }}" alt="{{ $detail->event->event_name ?? 'Event Image' }}" 
                                         class="w-full sm:w-36 h-32 object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="No Image" 
                                         class="w-full sm:w-36 h-32 object-cover rounded-lg">
                                @endif
                            </div>

                            {{-- Details Section --}}
                            <div class="flex flex-col text-creamcard text-xs text-justify flex-grow">
                                <p class="font-bold mb-2 text-base">{{ $detail->event->event_name ?? 'N/A' }}</p>

                                {{-- Location --}}
                                <div class="flex gap-2 text-xs mb-1 items-center">
                                    <img src="{{ asset('assets/location-icon.svg') }}" alt="Location" class="w-4 h-4">
                                    <p class="font-regular text-creamcard">{{ $detail->event->location->address ?? 'N/A' }}</p>
                                </div>

                                {{-- Date --}}
                                <div class="flex items-center gap-2 text-xs mb-1">
                                    <img src="{{ asset('assets/calendar-icon.svg') }}" alt="Calendar" class="w-4 h-4">
                                    <p class="font-regular text-creamcard">
                                        {{ $detail->event->start_date ? \Carbon\Carbon::parse($detail->event->start_date)->format('d M Y') : 'N/A' }} 
                                        — 
                                        {{ $detail->event->end_date ? \Carbon\Carbon::parse($detail->event->end_date)->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                                
                                
                            </div>
                        </div>
                    </a>
                @endforeach 
            </div>
            @endif
        </div>
    </div>
</x-app-layout>