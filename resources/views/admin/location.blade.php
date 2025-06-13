<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Manajemen Lokasi</h2>
    </x-slot>

    <div class="py-8" x-data="{ openModal: false }">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-greenbg shadow p-8 rounded-lg">
                <div class="flex justify-between items-center mb-2 gap-4">
                    <form action="{{ route('admin.location') }}" method="GET" class="flex w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Location..."
                            class="w-full border border-redb bg-creamcard placeholder:text-redb rounded-lg placeholder:px-4">
                    </form>
                        
                    <x-button class="px-6">Search</x-button>
                    
                    <a href="#" 
                    @click.prevent="$dispatch('open-modal', 'add-location-modal')" 
                    class="inline-flex items-center px-4 py-2 text-redb rounded-md text-sm font-medium transition">
                        <img src="{{ asset('/assets/add.svg') }}" 
                            onmouseover="this.src='/assets/add-hover.svg'" 
                            onmouseout="this.src='/assets/add.svg'" 
                            alt="icon" class="w-16 h-16">
                    </a>

                </div>

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto bg-creamcard rounded-lg shadow-md">
                    <table class="min-w-full text-sm text-center">
                        <thead class="bg-creamhh rounded-lg">
                            <tr>
                                <th class="px-6 py-2 text-redb text-base font-bold">Province</th>
                                <th class="px-6 py-2 text-redb text-base font-bold">City</th>
                                <th class="px-6 py-2 text-redb text-base font-bold">Location Name</th>
                                <th class="px-6 py-2 text-redb text-base font-bold">Address</th>
                                <th class="px-6 py-2 text-redb text-base font-bold">Zip Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations as $location)
                                <tr class="border-b">
                                    <td class="px-6 py-4">{{ $location->province->province_name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $location->city->cities_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-left">{{ $location->name }}</td>
                                    <td class="px-6 py-4 text-left">{{ $location->address }}</td>
                                    <td class="px-6 py-4">{{ $location->zipcode }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-redb">No Data Location.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $locations->links() }}
                </div>
            </div>
        </div>

        {{-- Modal Tambah Lokasi --}}
        <div x-show="openModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-greenbg rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
                <h2 class="text-lg font-semibold mb-4">Add New Location</h2>
                <form method="POST" action="{{ route('admin.location.search') }}">
                    @csrf

                    <div class="mb-3">
                        <x-label for="province" value="Provinsi" />
                        <x-input name="province" id="province" class="w-full" required />
                        <x-input-error for="province" />
                    </div>

                    <div class="mb-3">
                        <x-label for="city" value="Kota" />
                        <x-input name="city" id="city" class="w-full" required />
                        <x-input-error for="city" />
                    </div>

                    <div class="mb-3">
                        <x-label for="name" value="Nama Lokasi" />
                        <x-input name="name" id="name" class="w-full" required />
                        <x-input-error for="name" />
                    </div>

                    <div class="mb-3">
                        <x-label for="address" value="Alamat" />
                        <textarea name="address" id="address" class="w-full border-gray-300 rounded" rows="3" required></textarea>
                        <x-input-error for="address" />
                    </div>

                    <div class="mb-3">
                        <x-label for="zipcode" value="Kode Pos" />
                        <x-input name="zipcode" id="zipcode" class="w-full" required />
                        <x-input-error for="zipcode" />
                    </div>

                    <div class="flex justify-end gap-3">
                        <x-button type="button" @click="openModal = false">Cancel</x-button>
                        <x-button type="submit">Save</x-button>
                    </div>
                </form>

                <button class="absolute top-2 right-2 text-gray-500 hover:text-red-600" @click="openModal = false">✖</button>
            </div>
        </div>
    </div>
</x-app-layout>