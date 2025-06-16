<x-app-layout>
    @section('title', 'Manage Event')
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            Manajemen Event - {{ ucfirst($eventType) }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        {{-- Filter, Search, Tambah --}}
        <div class="flex flex-col md:flex-row items-center md:items-center mb-6 space-y-4 md:space-y-0">
            <form method="GET" action="{{ route('admin.manage-event') }}" class="flex flex-wrap gap-4 flex-grow">
                {{-- Filter Type --}}
                <x-dropdown-register align="left">
                    <x-slot name="trigger">
                        <div class="relative">
                            <button id="event-type-trigger" type="button"
                                class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb leading-5 pr-10">
                                <span id="event-type-text">{{ ucfirst($eventType ?? 'Select Type') }}</span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <input type="hidden" name="type" id="event-type-input" value="{{ $eventType }}">
                        <div class="w-48 max-h-48 overflow-y-auto flex flex-col space-y-1 text-base text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg"
                            id="event-type-list">
                            <button type="button" class="px-4 py-2 text-left event-type-btn" data-type="volunteer">Volunteer</button>
                            <button type="button" class="px-4 py-2 text-left event-type-btn" data-type="donation">Donation</button>
                        </div>
                    </x-slot>
                </x-dropdown-register>

                {{-- Filter Partner --}}
                <x-dropdown-register align="left">
                    <x-slot name="trigger">
                        <div class="relative">
                            <button id="partner-trigger" type="button"
                                class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb leading-5 pr-10">
                                <span id="partner-text">
                                    {{ $partners->firstWhere('id', request('partner_id'))?->partner_name ?? 'Semua Partner' }}
                                </span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <input type="hidden" name="partner_id" id="partner-input" value="{{ request('partner_id') }}">
                        <div class="w-48 max-h-48 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg"
                            id="partner-list">
                            <button type="button" class="px-4 py-2 text-left partner-btn" data-id="">-- Semua Partner --</button>
                            @foreach($partners as $partner)
                                <button type="button" class="px-4 py-2 text-left partner-btn"
                                    data-id="{{ $partner->id }}">
                                    {{ $partner->partner_name }}
                                </button>
                            @endforeach
                        </div>
                    </x-slot>
                </x-dropdown-register>
            </form>

            {{-- Tombol Tambah Event --}}
            @if ($eventType === 'volunteer')
                <a href="{{ route('admin.manage.event.volunteer.add') }}">
                    <img src="{{ asset('/assets/add.svg') }}" onmouseover="this.src='/assets/add-hover.svg'" 
                        onmouseout="this.src='/assets/add.svg'" 
                        alt="icon" class="w-10 h-10">
                </a>
            @else
                <a href="{{ route('admin.manage.event.donation.add') }}">
                    <img src="{{ asset('/assets/add.svg') }}" onmouseover="this.src='/assets/add-hover.svg'" 
                        onmouseout="this.src='/assets/add.svg'" 
                        alt="icon" class="w-10 h-10">
                </a>
            @endif
        </div>

        {{-- Kartu Event --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div class="h-full">
                    <div class="bg-greenbg p-4 rounded-lg shadow-md flex flex-col justify-between h-full">
                        <div>
                            <h3 class="text-lg font-semibold text-creamcard mb-2">{{ $event->event_name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $event->description }}</p>
                            <p class="text-sm text-creamcard">
                                <strong class="text-creamcard">
                                    <img src="{{ asset('/assets/location-icon.svg') }}" alt="location" class="inline w-4 h-4 mr-1">
                                </strong> {{ $event->location->name ?? '-' }}
                            </p>

                            @if($eventType === 'volunteer')
                                <p class="text-sm text-creamhh">
                                    <strong class="text-creamcard">
                                        <img src="{{ asset('/assets/calendar-icon.svg') }}" alt="date" class="inline w-4 h-4 mr-1">
                                    </strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                </p>
                            @else
                                <p class="text-sm text-creamcard">
                                    <strong class="text-creamcard">
                                        <img src="{{ asset('/assets/target.svg') }}" alt="target" class="inline w-4 h-4 mr-1">
                                    </strong> {{ number_format($event->donation_target ?? 0, 0, ',', '.') }}
                                </p>
                            @endif
                            <p class="text-xs text-creamcard">by {{ $event->partner->partner_name ?? '-' }}</p>

                            <a href="{{ $eventType === 'volunteer'
                                ? route('admin.manage.event.volunteer', $event->id)
                                : route('admin.manage.event.donation', $event->id) }}"
                                class="text-redb hover:underline text-xs">View Detail
                            </a>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-end items-center mt-2 space-x-3">
                                <form method="POST" action="{{ $eventType === 'volunteer'
                                    ? route('admin.manage.event.volunteer.delete', $event->id)
                                    : route('admin.manage.event.donation.delete', $event->id) }}"
                                    onsubmit="return confirm('Are you sure delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="text-red-600 text-sm">Delete</x-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">
                    No Events found.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- Script --}}
    <script>
        document.querySelectorAll('.event-type-btn').forEach(button => {
            button.addEventListener('click', function () {
                const type = this.dataset.type;
                document.getElementById('event-type-input').value = type;
                document.getElementById('event-type-text').innerText = type.charAt(0).toUpperCase() + type.slice(1);
                this.closest('form').submit();
            });
        });

        document.querySelectorAll('.partner-btn').forEach(button => {
            button.addEventListener('click', function () {
                const partnerId = this.dataset.id;
                document.getElementById('partner-input').value = partnerId;
                document.getElementById('partner-text').innerText = this.innerText.trim();
                this.closest('form').submit();
            });
        });
    </script>
</x-app-layout>