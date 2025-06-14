<x-app-layout>
    @section('title', 'Manage Location')
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Manajemen Lokasi</h2>
    </x-slot>

    <div class="py-8" x-data="{ openModal: false, showManage: false, openDeleteModal: false, selectedId: null }">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-greenbg shadow p-8 rounded-lg">

                {{-- Search & Filter --}}
                <div class="flex justify-between items-center mb-4 gap-4">
                    <form action="{{ route('admin.location') }}" method="GET" class="flex items-center gap-6 w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search Location..."
                            class="w-full border border-redb bg-creamcard placeholder:text-redb rounded-lg focus:px-4 focus:outline-none focus:ring-2 focus:ring-redb">

                        <x-dropdown-register align="left">
                            <x-slot name="trigger">
                                <div class="relative">
                                    <button type="button"
                                        class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb">
                                        <span>{{ ucfirst(request('type', 'Select Type')) }}</span>
                                        <img src="{{ asset('/assets/arrow-down.svg') }}" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                    </button>
                                </div>
                            </x-slot>

                            <x-slot name="content">
                                <input type="hidden" name="type" id="type-input">
                                <div class="absolute z-50 w-48 max-h-48 overflow-y-auto flex flex-col text-xs text-redb font-bold bg-creamcard rounded-lg">
                                    <button type="submit" name="type" value="volunteer" class="px-4 py-2 text-left hover:text-greenbg">Volunteer</button>
                                    <button type="submit" name="type" value="donation" class="px-4 py-2 text-left hover:text-greenbg">Donation</button>
                                </div>
                            </x-slot>
                        </x-dropdown-register>

                        <x-button type="submit" class="inline-flex h-10 items-center px-6">Search</x-button>
                    </form>

                    <a href="#" @click.prevent="openModal = true">
                        <img src="{{ asset('/assets/add.svg') }}" onmouseover="this.src='/assets/add-hover.svg'" onmouseout="this.src='/assets/add.svg'" class="w-12 h-12">
                    </a>
                </div>

                @php
                    $success = session('success');
                @endphp

                @if($success)
                    <div 
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 3000)"
                        x-show="show"
                        x-transition
                        class="{{ str_contains($success, 'deleted') ? 'bg-redb border-greenbg text-creamcard' : 'bg-creamhh border-redb text-creamcard' }} border px-4 py-2 rounded-lg relative mb-4"
                        role="alert"
                    >
                        <strong class="font-bold">Congrats!</strong>
                        <span class="block sm:inline">{{ $success }}</span>
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto bg-creamcard rounded-lg shadow-md">
                    <table class="min-w-full text-sm text-center">
                        <thead class="bg-creamhh">
                            <tr>
                                <th class="px-6 py-2 text-redb font-bold">Province</th>
                                <th class="px-6 py-2 text-redb font-bold">City</th>
                                <th class="px-6 py-2 text-redb font-bold">Name</th>
                                <th class="px-6 py-2 text-redb font-bold">Address</th>
                                <th class="px-6 py-2 text-redb font-bold">Zip Code</th>
                                <th x-show="showManage" class="px-6 py-2 text-redb font-bold">Action</th>
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
                                    <td x-show="showManage" class="px-6 py-4">
                                        <button @click="openDeleteModal = true; selectedId = {{ $location->id }}">
                                            <img src="{{ asset('/assets/trash.svg') }}" onmouseover="this.src='/assets/trash-hover.svg'" onmouseout="this.src='/assets/trash.svg'" class="w-6 h-6">
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-redb p-4">No Data Location.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $locations->links() }}</div>

                <div class="flex justify-end mt-4">
                    <x-button @click="showManage = !showManage">
                        <span x-text="showManage ? 'Close Manage' : 'Manage Data'"></span>
                    </x-button>
                </div>
            </div>
        </div>

        {{-- Modal Add --}}
        <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-greenbg rounded-lg p-6 w-full max-w-xl relative">
                <h2 class="text-lg text-creamcard font-semibold mb-4">Add New Location</h2>
                <form method="POST" action="{{ route('admin.location.store') }}">
                    @csrf
                    <input type="hidden" name="type" value="{{ request('type', 'volunteer') }}">

                    {{-- Province Dropdown --}}
                    <div class="mb-3" 
                        x-data="{ 
                            openProvince: false, 
                            selectedProvinceName: '{{ old('province') ? $provinces->firstWhere('id', old('province'))->province_name : 'Select Province' }}', 
                            selectedProvinceId: '{{ old('province') ?? '' }}' 
                        }">
                        
                        <x-label for="province" value="Province" />
                        <input type="hidden" name="province" x-bind:value="selectedProvinceId">

                        <div @click="openProvince = !openProvince" class="relative">
                            <button type="button"
                                class="relative w-full inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb pr-10">
                                <span x-text="selectedProvinceName"></span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                            <div x-show="openProvince" x-transition @click.away="openProvince = false"
                                class="absolute z-50 w-full max-h-48 overflow-y-auto bg-creamcard rounded-lg shadow mt-2">
                                @foreach ($provinces as $province)
                                    <button type="button"
                                        @click="
                                            selectedProvinceName = '{{ $province->province_name }}';
                                            selectedProvinceId = '{{ $province->id }}';
                                            openProvince = true;
                                        "
                                        class="block w-full text-left px-4 py-2 text-xs text-redb hover:text-greenbg">
                                        {{ $province->province_name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <x-input-error for="province" />
                    </div>


                    {{-- City Dropdown --}}
                    <div class="mb-3" 
                        x-data="{ 
                            openCity: false, 
                            selectedCityName: '{{ old('city') ? $cities->firstWhere('id', old('city'))->cities_name : 'Select City' }}', 
                            selectedCityId: '{{ old('city') ?? '' }}' 
                        }">
                        
                        <x-label for="city" value="City" />
                        <input type="hidden" name="city" x-bind:value="selectedCityId">

                        <div @click="openCity = !openCity" class="relative">
                            <button type="button"
                                class="relative w-full inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb pr-10">
                                <span x-text="selectedCityName"></span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                            <div x-show="openCity" x-transition @click.away="openCity = false"
                                class="absolute z-50 mt-2 w-full max-h-48 overflow-y-auto bg-creamcard shadow-quadrupleNonHover rounded-lg shadow">
                                @foreach ($cities as $city)
                                    <button type="button"
                                        @click="
                                            selectedCityName = '{{ $city->cities_name }}';
                                            selectedCityId = '{{ $city->id }}';
                                            openCity = true;
                                        "
                                        class="block w-full text-left px-4 py-2 text-xs text-redb hover:text-greenbg">
                                        {{ $city->cities_name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <x-input-error for="city" />
                    </div>

                    <div class="mb-3">
                        <x-label for="name" value="Location Name" />
                        <x-input name="name" class="w-full" required />
                        <x-input-error for="name" />
                    </div>

                    <div class="mb-3">
                        <x-label for="address" value="Address" />
                        <textarea name="address" rows="3" class="w-full text-xs [box-shadow:4px_5px_0px_rgb(144,43,41,1)] focus:outline-none focus:ring-2 focus:ring-redb textarea:text-greyAuth textarea:text-xs bg-creamcard rounded-lg" required></textarea>
                        <x-input-error for="address" />
                    </div>

                    <div class="mb-3">
                        <x-label for="zipcode" value="Zip Code" />
                        <x-input name="zipcode" class="w-full" required />
                        <x-input-error for="zipcode" />
                    </div>

                    <div class="flex justify-end gap-3">
                        <x-button type="button" @click="openModal = false">Cancel</x-button>
                        <x-button type="submit">Save</x-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Delete --}}
        <div x-show="openDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-greenbg rounded-lg p-6 w-full max-w-md relative">
                <h2 class="text-lg font-semibold text-redb mb-4">Confirm Deletion</h2>
                <p class="mb-4 text-creamcard">Are you sure you want to delete this location?</p>
                <form method="POST" :action="'/admin/location/delete/' + selectedId">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="type" value="{{ request('type', 'volunteer') }}">
                    <div class="flex justify-end gap-3">
                        <x-button type="button" @click="openDeleteModal = false">Cancel</x-button>
                        <x-button type="submit" class="text-creamcard">Delete</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>