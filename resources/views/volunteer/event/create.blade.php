<x-app-layout>
    @section('title', 'Events Register')

    <div class="flex flex-row items-center m-8 w-full gap-96">

        <a href="{{ route('volunteer.events.show') }}" class="">
            <svg width="44" height="44" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="9" y="9" width="52" height="52" rx="26" stroke="#3F8044" stroke-width="2"/>
                <rect x="11" y="11" width="48" height="48" rx="24" fill="#1E1E1E"/>
                <rect x="11" y="11" width="48" height="48" rx="24" stroke="#D9D9D9" stroke-width="2"/>
                <path d="M39 22.5L27 35L39 47.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        @if($selectedEvent)
            <div class="text-center">
                <h2 class="text-transform: uppercase text-xl text-redb font-bold mb-2">Program {{ $selectedEvent->event_name }}</h2>       
            </div>
        @endif
    </div>

</x-app-layout>