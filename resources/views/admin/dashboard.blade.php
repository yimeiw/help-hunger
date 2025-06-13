<x-app-layout>
    @section('title', 'Admin Dashboard')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="flex items-center justify-center text-[32px] font-bold text-redb mb-4">Summary Statistics</h3>
            <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-12">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total Donations Collected</p>
                            <p class="text-2xl font-bold text-redb">IDR{{ number_format($statistics['totalDonationAmount'], 0, ',', '.') }}</p>
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
    </div>
</x-app-layout>