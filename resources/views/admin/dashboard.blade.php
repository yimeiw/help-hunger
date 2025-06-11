<x-app-layout>
    @section('title', 'Admin Dashboard')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="flex items-center justify-center text-[32px] font-bold text-redb mb-4">Ringkasan Statistik</h3>
            <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-12">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total Donasi Terkumpul</p>
                            <p class="text-2xl font-bold text-redb">Rp{{ number_format($statistics['totalDonationAmount'], 0, ',', '.') }}</p>
                        </div>
                        <img src="{{ asset('/assets/default-icon-donations.svg') }}" alt="Donasi" class="h-12 w-12 text-blue-500"> 
                    </div>

                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total Pengguna</p>
                            <p class="text-2xl font-bold text-redb">{{ number_format($statistics['totalUsers']) }}</p>
                            <p class="text-xs text-redb">
                                (Volunteer: {{ number_format($statistics['totalVolunteers']) }} | Donatur: {{ number_format($statistics['totalDonaturs']) }})
                            </p>
                        </div>
                        <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Pengguna" class="h-12 w-12 text-green-500"> 
                    </div>

                    <div class="bg-creamcard p-4 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm text-redb font-semibold">Total Event</p>
                            <p class="text-2xl font-bold text-redb">{{ number_format($statistics['totalEvents']) }}</p>
                            <p class="text-xs text-redb">
                                (Aktif: {{ number_format($statistics['activeEvents']) }} | Mendatang: {{ number_format($statistics['upcomingEvents']) }})
                            </p>
                        </div>
                        <img src="{{ asset('assets/default-icon-volunteer.svg') }}" alt="Event" class="h-12 w-12 text-yellow-500">
                    </div>

                    </div>
            </div>
        </div>
    </div>
</x-app-layout>