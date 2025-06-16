<x-app-layout>
    @section('title', 'Admin Dashboard')
    <div class="p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="flex items-center justify-center text-[32px] font-bold text-redb mb-4">Summary Statistics</h3>
            <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-12">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total Donations Collected</p>
                            <p class="text-2xl font-bold text-redb">IDR {{ number_format($statistics['totalDonationAmount'], 0, ',', '.') }}</p>
                        </div>
                        <img src="{{ asset('/assets/default-icon-donations.svg') }}" alt="Donasi" class="h-12 w-12 text-blue-500"> 
                    </div>

                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total User</p>
                            <p class="text-2xl font-bold text-redb">{{ number_format($statistics['totalUsers']) }}</p>
                            <p class="text-xs text-redb">
                                (Volunteers: {{ number_format($statistics['totalVolunteers']) }} | Donaturs: {{ number_format($statistics['totalDonaturs']) }} | Partners: {{ number_format($statistics['totalPartners']) }})
                            </p>
                        </div>
                        <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Pengguna" class="h-12 w-12 text-green-500"> 
                    </div>

                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total Events</p>
                            <p class="text-2xl font-bold text-redb">{{ number_format($statistics['totalEvents']) }}</p>
                            <p class="text-xs text-redb">
                                (Active: {{ number_format($statistics['activeEvents']) }} | Upcoming: {{ number_format($statistics['upcomingEvents']) }})
                            </p>
                        </div>
                        <img src="{{ asset('assets/default-icon-volunteer.svg') }}" alt="Event" class="h-12 w-12 text-yellow-500">
                    </div>

                </div>
            </div>
        </div>
        
        <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="flex items-center font-bold justify-center text-[32px] text-redb mb-4">Event Approval Dashboard</h2>
                <div class="bg-greenbg shadow-xl sm:rounded-lg p-6">
    
                    {{-- Success/Error Messages --}}
                    @if (session('success'))
                        <div class="bg-greenbg border border-redb text-creamcard px-4 py-3 rounded-lg relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-redb border border-creamcard text-creamcard px-4 py-3 rounded-lg relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
    
                    {{-- Tabs for Event Statuses --}}
                    <div x-data="{ activeTab: 'pending' }">
                        <div class="mb-4 border-redb overflow-x-auto">
                            <ul class="flex items-center gap-4 text-base font-semibold text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'pending', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'pending' }" @click="activeTab = 'pending'" type="button" role="tab" aria-controls="pending" aria-selected="true">Pending Events</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'ongoing', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'ongoing' }" @click="activeTab = 'ongoing'" type="button" role="tab" aria-controls="ongoing" aria-selected="false">Ongoing Events</button>
                                </li>
                                 <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'completed', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'completed' }" @click="activeTab = 'completed'" type="button" role="tab" aria-controls="completed" aria-selected="false">Completed Events</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'declined', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'declined' }" @click="activeTab = 'declined'" type="button" role="tab" aria-controls="declined" aria-selected="false">Declined Events</button>
                                </li>
                            </ul>
                        </div>
    
                        <div id="default-tab-content">
                            {{-- Pending Events Tab Content --}}
                            <div x-show="activeTab === 'pending'" class="p-4 rounded-lg bg-creamcard">
                                <h3 class="text-lg px-4 font-semibold text-redb py-2">Pending Events (Approval Needed)</h3>
                                @if($pendingEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No pending events found</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard rounded-lg shadow-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Donation Target</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($pendingEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">
                                                            @if($event->event_type == 'donation')
                                                                IDR {{ number_format($event->donation_target, 0, ',', '.') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            <form action="{{ route('admin.approve.event', ['type' => $event->event_type, 'id' => $event->id]) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit">
                                                                    <img 
                                                                        src="{{ asset('/assets/approve.svg') }}" 
                                                                        class="w-6 h-6" 
                                                                        alt="Approve"
                                                                        onmouseover="this.src='/assets/approve-hover.svg'" onmouseout="this.src='/assets/approve.svg'"
                                                                    >
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.decline.event', ['type' => $event->event_type, 'id' => $event->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to decline this event?');">
                                                                @csrf
                                                                <button type="submit">
                                                                    <img 
                                                                        src="{{ asset('/assets/decline.svg') }}" 
                                                                        class="w-6 h-6" 
                                                                        alt="Decline"
                                                                        onmouseover="this.src='/assets/decline-hover.svg'" onmouseout="this.src='/assets/decline.svg'"
                                                                    >
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4">
                                        {{ $pendingEvents->links('pagination::tailwind') }}
                                    </div>
                                @endif
                            </div>
    
                            {{-- Ongoing Events Tab Content --}}
                            <div x-show="activeTab === 'ongoing'" class="p-4 rounded-lg bg-creamcard" x-cloak>
                                <h3 class="text-lg font-semibold text-redb px-4 py-2">Ongoing Events</h3>
                                @if($ongoingEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No ongoing events found.</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard rounded-lg shadow-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Donation Target</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($ongoingEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">
                                                            @if($event->event_type == 'donation')
                                                                IDR {{ number_format($event->donation_target, 0, ',', '.') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
    
                            {{-- Completed Events Tab Content --}}
                            <div x-show="activeTab === 'completed'" class="p-4 rounded-lg bg-creamcard" x-cloak>
                                <h3 class="text-lg font-semibold text-redb px-4 py-2">Completed Events</h3>
                                @if($completedEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No completed events found.</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard shadow-lg rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Details</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($completedEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">
                                                            @if($event->event_type == 'volunteer')
                                                                Total Volunteers: {{ $event->eventsVolunteersDetails->count() }}
                                                            @elseif($event->event_type == 'donation')
                                                                Total Collected: IDR {{ number_format($event->donations->sum('amount'), 0, ',', '.') }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
    
                            {{-- Declined Events Tab Content --}}
                            <div x-show="activeTab === 'declined'" class="p-4 rounded-lg bg-creamcard" x-cloak>
                                <h3 class="text-lg font-semibold text-redb px-4 py-2">Declined Events</h3>
                                @if($declinedEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No declined events found.</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard rounded-lg shadow-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Donation Target</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($declinedEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">
                                                            @if($event->event_type == 'donation')
                                                                IDR {{ number_format($event->donation_target, 0, ',', '.') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="flex items-center font-bold justify-center text-[32px] text-redb mb-4">Donation Approval Dashboard</h2>
                <div class="bg-greenbg shadow-xl sm:rounded-lg p-6">
    
                    {{-- Success/Error Messages --}}
                    @if (session('success'))
                        <div class="bg-greenbg border border-redb text-creamcard px-4 py-3 rounded-lg relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-redb border border-creamcard text-creamcard px-4 py-3 rounded-lg relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
    
                    {{-- Tabs for Event Statuses --}}
                    <div x-data="{ activeTab: 'pending' }">
                        <div class="mb-4 border-redb overflow-x-auto">
                            <ul class="flex items-center gap-4 text-base font-semibold text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'pending', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'pending' }" @click="activeTab = 'pending'" type="button" role="tab" aria-controls="pending" aria-selected="true">Pending Donations</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'accepted', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'accepted' }" @click="activeTab = 'accepted'" type="button" role="tab" aria-controls="accepted" aria-selected="false">Accepted Donations</button>
                                </li>
                                 <li class="me-2" role="presentation">
                                    <button class="px-4 py-2 border-2 border-red rounded-3xl bg-creamcard" :class="{ 'border-redb border-2 text-creamcard bg-redb shadow-lg': activeTab === 'failed', 'border-redb border-2 text-redb hover:text-greenbg hover:border-greenbg': activeTab !== 'failed' }" @click="activeTab = 'failed'" type="button" role="tab" aria-controls="failed" aria-selected="false">Failed Donations</button>
                                </li>
                                
                            </ul>
                        </div>
    
                        <div id="default-tab-content">
                            {{-- Pending Events Tab Content --}}
                            <div x-show="activeTab === 'pending'" class="p-4 rounded-lg bg-creamcard">
                                <h3 class="text-lg px-4 font-semibold text-redb py-2">Pending Donations (Approval Needed)</h3>
                                @if($pendingEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No pending events found</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard rounded-lg shadow-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Donation Target</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($pendingEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">
                                                            @if($event->event_type == 'donation')
                                                                IDR {{ number_format($event->donation_target, 0, ',', '.') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            <form action="{{ route('admin.approve.event', ['type' => $event->event_type, 'id' => $event->id]) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit">
                                                                    <img 
                                                                        src="{{ asset('/assets/approve.svg') }}" 
                                                                        class="w-6 h-6" 
                                                                        alt="Approve"
                                                                        onmouseover="this.src='/assets/approve-hover.svg'" onmouseout="this.src='/assets/approve.svg'"
                                                                    >
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.decline.event', ['type' => $event->event_type, 'id' => $event->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to decline this event?');">
                                                                @csrf
                                                                <button type="submit">
                                                                    <img 
                                                                        src="{{ asset('/assets/decline.svg') }}" 
                                                                        class="w-6 h-6" 
                                                                        alt="Decline"
                                                                        onmouseover="this.src='/assets/decline-hover.svg'" onmouseout="this.src='/assets/decline.svg'"
                                                                    >
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4">
                                        {{ $pendingEvents->links('pagination::tailwind') }}
                                    </div>
                                @endif
                            </div>
    
                            {{-- Ongoing Events Tab Content --}}
                            <div x-show="activeTab === 'ongoing'" class="p-4 rounded-lg bg-creamcard" x-cloak>
                                <h3 class="text-lg font-semibold text-redb px-4 py-2">Ongoing Events</h3>
                                @if($ongoingEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No ongoing events found.</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard rounded-lg shadow-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Donation Target</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($ongoingEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-xs text-blackAuth whitespace-nowrap">
                                                            @if($event->event_type == 'donation')
                                                                IDR {{ number_format($event->donation_target, 0, ',', '.') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
    
                            {{-- Completed Events Tab Content --}}
                            <div x-show="activeTab === 'completed'" class="p-4 rounded-lg bg-creamcard" x-cloak>
                                <h3 class="text-lg font-semibold text-redb px-4 py-2">Completed Events</h3>
                                @if($completedEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No completed events found.</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard shadow-lg rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-redb uppercase tracking-wider">Details</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($completedEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">
                                                            @if($event->event_type == 'volunteer')
                                                                Total Volunteers: {{ $event->eventsVolunteersDetails->count() }}
                                                            @elseif($event->event_type == 'donation')
                                                                Total Collected: IDR {{ number_format($event->donations->sum('amount'), 0, ',', '.') }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
    
                            {{-- Declined Events Tab Content --}}
                            <div x-show="activeTab === 'declined'" class="p-4 rounded-lg bg-creamcard" x-cloak>
                                <h3 class="text-lg font-semibold text-redb px-4 py-2">Declined Events</h3>
                                @if($declinedEvents->isEmpty())
                                    <p class="text-blackAuth px-4 py-2">No declined events found.</p>
                                @else
                                    <div class="overflow-x-auto bg-creamcard rounded-lg shadow-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-creamhh rounded-lg">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Event Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Type</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Partner</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Location</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Start Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">End Date</th>
                                                    <th class="px-6 py-3 text-left text-xs font-xs text-redb uppercase tracking-wider">Donation Target</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-creamcard rounded-lg divide-y divide-gray-200">
                                                @foreach($declinedEvents as $event)
                                                    <tr>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->event_name }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ ucfirst($event->event_type) }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->partner->partner_name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ $event->location->name ?? 'N/A' }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                                        <td class="px-6 py-4 text-blackAuth text-xs whitespace-nowrap">
                                                            @if($event->event_type == 'donation')
                                                                IDR {{ number_format($event->donation_target, 0, ',', '.') }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
</x-app-layout>