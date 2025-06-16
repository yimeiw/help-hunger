<x-auth-layout>
    @section('title', 'Add New Donation Event')

    {{-- Tombol Back & Close --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.manage-event') }}" onclick="resetFormsAndNavigate(event);" class="flex justify-end m-6">
            <img src="{{ asset('/assets/close-button.svg') }}" 
                 onmouseover="this.src='/assets/close-hover.svg'" 
                 onmouseout="this.src='/assets/close-button.svg'" 
                 alt="Close" class="w-8 h-8">
        </a>
    </div>

    <x-authentication-card>
        <x-slot name="logo">
            <h2 class="text-xl font-bold text-creamcard">Add New Donation Event</h2>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form action="{{ route('admin.manage.event.donation.add') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <x-label for="event_name" value="Event Name" />
                <x-input id="event_name" type="text" name="event_name" class="block w-full mt-1" :value="old('event_name')" required autofocus />
            </div>

            <div class="mb-4">
                <x-label for="description" value="Description" class="mb-1"/>
                <textarea id="description" name="event_description" rows="4" class="w-full text-xs [box-shadow:4px_5px_0px_rgb(144,43,41,1)] focus:outline-none focus:ring-2 focus:ring-redb text-blackAuth textarea:text-xs bg-creamcard rounded-lg">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-row gap-4">
                <div class="mb-4 w-1/2">
                    <x-label for="start_date" value="Start Date" />
                    <x-input id="start_date" type="datetime-local" name="start_date" class="block w-48 mt-1" :value="old('start_date')" required />
                </div>

                <div class="mb-4 w-1/2">
                    <x-label for="end_date" value="End Date" />
                    <x-input id="end_date" type="datetime-local" name="end_date" class="block w-48 mt-1" :value="old('end_date')" required />
                </div>
            </div>

            <div class="mb-4">
                <x-label for="donation_target" value="Donation Target (IDR)" />
                <x-input id="donation_target" type="number" name="donation_target" class="block w-full mt-1" :value="old('donation_target')" min="0" step="any" 
                placeholder="eg. 100000" required />
            </div>



            

            <div class="mb-4">
                <x-label value="Select Location on Map" class="mb-2" />
                <div id="mapid" style="height: 400px; width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
                <p class="text-sm text-creamcard mt-2">Click on the map to select a location. Latitude and Longitude will be auto-filled.</p>
                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
            </div>

            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

            <div class="mb-4">
                <x-label for="location_name" value="Location Name" />
                <x-input id="location_name" type="text" name="location_name" class="block w-full mt-1" :value="old('location_name')" required />
                <x-input-error :messages="$errors->get('location_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="location_address" value="Address" />
                <x-input id="location_address" type="text" name="location_address" class="block w-full mt-1" :value="old('location_address')" required />
                <x-input-error :messages="$errors->get('location_address')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="location_zipcode" value="Zipcode" />
                <x-input id="location_zipcode" type="number" name="location_zipcode" class="block w-full mt-1" :value="old('location_zipcode')" required />
                <x-input-error :messages="$errors->get('location_zipcode')" class="mt-2" />
            </div>

            {{-- Di bagian atas file Blade Anda atau di tempat yang relevan --}}
            @php
                // --- Logic for Old Province Value ---
                // Note: The hidden input name is now 'province_id' to match validation
                $oldProvinceId = old('province_id'); // <--- Changed from 'province'
                $oldProvinceName = 'Select Province'; // Default text

                if ($oldProvinceId && isset($provinces)) {
                    $foundOldProvince = $provinces->firstWhere('id', $oldProvinceId);
                    if ($foundOldProvince) {
                        $oldProvinceName = $foundOldProvince->province_name;
                    }
                }

                // --- Logic for Old City Value ---
                // Note: The hidden input name is now 'city_id' to match validation
                $oldCityId = old('city_id'); // <--- Changed from 'city'
                $oldCityName = 'Select City'; // Default text
                // JS will handle loading and displaying the old city name based on oldCityId if present
            @endphp

            <div class="flex flex-row justify-between">
                {{-- BAGIAN DROPDOWN PROVINSI --}}
                <div class="mb-4 relative">
                    <x-label for="province" value="{{ __('Province') }}"/>
                    <x-dropdown-register align="left">
                        <x-slot name="trigger">
                            <div class="relative">
                                <button id="province-trigger" type="button" class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10">
                                    <span id="province-text">{{ $oldProvinceName }}</span>
                                    <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                </button>
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Input tersembunyi harus menyimpan ID provinsi --}}
                            <input type="hidden" name="province_id" id="province-input" value="{{ $oldProvinceId }}"> {{-- <--- Changed name --}}
                            <div class="w-48 max-h-28 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg" id="province-list">
                                @foreach ($provinces as $province)
                                    <button type="button" class="px-4 py-2 text-left province-btn" data-id="{{ $province->id }}">
                                        {{ $province->province_name }}
                                    </button>
                                @endforeach
                            </div>
                        </x-slot>
                    </x-dropdown-register>
                    <x-input-error :messages="$errors->get('province_id')" class="mt-2" /> {{-- Added error display --}}
                </div>

                {{-- BAGIAN DROPDOWN KOTA --}}
                <div class="mb-4 relative">
                    <x-label for="city" value="{{ __('City') }}"/>
                    <x-dropdown-register align="left">
                        <x-slot name="trigger">
                            <div class="relative">
                                <button id="city-trigger" type="button" class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10">
                                    <span id="city-text">{{ $oldCityName }}</span>
                                    <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                </button>
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Input tersembunyi harus menyimpan ID kota --}}
                            <input type="hidden" name="city_id" id="city-input" value="{{ $oldCityId }}"> {{-- <--- Changed name --}}
                            <div class="w-48 max-h-28 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg" id="city-list">
                                </div>
                        </x-slot>
                    </x-dropdown-register>
                    <x-input-error :messages="$errors->get('city_id')" class="mt-2" /> {{-- Added error display --}}
                </div>
            </div>


            {{-- Partner Dropdown --}}
            <div class="mb-4">
                <x-label for="partner_id" value="Partner" class="mb-1"/>
                <x-dropdown-register align="left">
                    <x-slot name="trigger">
                        <div class="relative">
                            <button id="partner-trigger" type="button"
                                class="relative w-full inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb leading-5 pr-10">
                                <span id="partner-text">
                                    {{ old('partner_name') ?? 'Select a partner' }}
                                </span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <input type="hidden" name="partner_id" id="partner_id" value="{{ old('partner_id') }}" class="mb-1">
                        <div class="w-full max-h-48 overflow-y-auto flex flex-col space-y-1 text-base text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg"
                            id="partner-list">
                            @foreach($partners as $partner)
                                <button type="button" class="px-4 py-2 text-left partner-option" data-id="{{ $partner->id }}" data-name="{{ $partner->partner_name }}">
                                    {{ $partner->partner_name }}
                                </button>
                            @endforeach
                        </div>
                    </x-slot>
                </x-dropdown-register>
            </div>

            <div class="mb-4">
                <x-label for="image" value="Event Image"/>
                <div class="flex items-center mt-1">
                    <label for="image" class="cursor-pointer flex items-start bg-creamcard shadow-quadrupleNonHover px-6 py-2 text-redb font-semibold text-sm rounded-3xl">
                        Upload Photo
                    </label>
                    <span id="file-chosen" class="text-sm text-creamdb px-4">No file chosen</span>
                </div>
                <input
                    id="image"
                    type="file"
                    name="image"
                    accept=".jpg, .jpeg, .png"
                    class="hidden"
                    onchange="updateFileName(this)"
                    required
                />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="flex flex-col items-center justify-end mt-4">
                <x-button class="w-full">
                    {{ __('Add Event') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

@push('scripts')
    <script>
        function resetFormsAndNavigate(event) {
            event.preventDefault();
            document.querySelectorAll('form').forEach(form => form.reset());
            window.location.href = "{{ route('admin.manage-event') }}";
        }

        function updateFileName(input) {
            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/png'];

            if (file && allowedTypes.includes(file.type)) {
                document.getElementById('file-chosen').textContent = file.name;
            } else {
                input.value = '';
                document.getElementById('file-chosen').textContent = 'Invalid file type. Only JPG/PNG allowed.';
            }
        }

        document.querySelectorAll('.partner-option').forEach(button => {
            button.addEventListener('click', function() {
                const partnerId = this.dataset.id;
                const partnerName = this.dataset.name;
                // Assuming you have elements with these IDs for the partner dropdown
                document.getElementById('partner_id').value = partnerId;
                document.getElementById('partner-text').textContent = partnerName;
            });
        });

        var map = L.map('mapid').setView([-6.201147507578286, 106.78232238809424], 13); // Default to Jakarta
        var marker; // To store the selected location marker

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Geocoder control for searching locations
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        }).on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var center = e.geocode.center;

            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(center).addTo(map);
            map.fitBounds(bbox);

            updateLocationInputs(center.lat, center.lng);
            // Attempt to auto-fill address from geocoder result
            document.getElementById('location_address').value = e.geocode.name;
            document.getElementById('location_name').value = e.geocode.name || ''; // Also fill location name
            document.getElementById('location_zipcode').value = ''; // Clear zipcode
            resetProvinceAndCityDropdowns(); // Clear province/city dropdowns
        }).addTo(map);

        // Handle map clicks
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            map.setView(e.latlng, map.getZoom()); // Center map on new marker

            updateLocationInputs(e.latlng.lat, e.latlng.lng);
            reverseGeocode(e.latlng.lat, e.latlng.lng); // This fills address, name, zipcode
            resetProvinceAndCityDropdowns(); // Clear province/city dropdowns
        });

        // Function to update hidden latitude and longitude inputs
        function updateLocationInputs(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Helper function to reset province and city dropdowns
        function resetProvinceAndCityDropdowns() {
            document.getElementById('province-input').value = '';
            document.getElementById('province-trigger').querySelector('#province-text').textContent = 'Select Province';
            document.getElementById('city-input').value = '';
            document.getElementById('city-trigger').querySelector('#city-text').textContent = 'Select City';
            document.getElementById('city-list').innerHTML = ''; // Clear city list
        }

        // Function to reverse geocode coordinates (get address from lat/lng)
        function reverseGeocode(lat, lng) {
            fetch(`/api/geocode/reverse?lat=${lat}&lon=${lng}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.address) {
                        console.log('Nominatim address data:', data.address);

                        // Fill Location Name, Address, and Zipcode
                        document.getElementById('location_address').value = data.display_name || '';
                        document.getElementById('location_name').value = data.address.road || data.address.neighbourhood || data.address.village || data.address.town || data.address.city || '';
                        document.getElementById('location_zipcode').value = data.address.postcode || '';

                        // Province and City dropdowns are INTENTIONALLY NOT filled here
                        // They are reset by resetProvinceAndCityDropdowns()
                    } else {
                        console.warn('Nominatim reverse geocoding did not return a valid address for this location. Clearing location fields.');
                        document.getElementById('location_address').value = '';
                        document.getElementById('location_name').value = '';
                        document.getElementById('location_zipcode').value = '';
                    }
                })
                .catch(error => console.error('Error during reverse geocoding:', error));
        }

        // --- All DOMContentLoaded related logic combined ---
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map with old coordinates if available
            const oldLat = document.getElementById('latitude').value;
            const oldLng = document.getElementById('longitude').value;
            if (oldLat && oldLng) {
                const latlng = L.latLng(parseFloat(oldLat), parseFloat(oldLng));
                map.setView(latlng, 13);
                marker = L.marker(latlng).addTo(map);
            }

            // Province Dropdown Logic (for new location selection)
            const provinceButtons = document.querySelectorAll('.province-btn');
            const provinceInput = document.getElementById('province-input');
            const provinceText = document.getElementById('province-text');

            provinceButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const provinceName = btn.textContent.trim();
                    const provinceId = btn.getAttribute('data-id');

                    provinceInput.value = provinceId;
                    provinceText.textContent = provinceName;

                    // When a province is selected, clear and load cities
                    document.getElementById('city-input').value = ''; // Clear city ID
                    document.getElementById('city-trigger').querySelector('#city-text').textContent = 'Select City'; // Reset city display text
                    const cityList = document.getElementById('city-list');
                    cityList.innerHTML = '<div class="px-4 py-2">Loading...</div>'; // Show loading

                    fetch(`/register/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(cities => {
                            cityList.innerHTML = ''; // Clear loading
                            cities.forEach(city => {
                                const cityBtn = document.createElement('button');
                                cityBtn.type = 'button';
                                cityBtn.className = 'px-4 py-2 text-left city-btn';
                                cityBtn.textContent = city.cities_name;
                                cityBtn.addEventListener('click', () => {
                                    document.getElementById('city-input').value = city.id;
                                    document.getElementById('city-trigger').querySelector('#city-text').textContent = city.cities_name;
                                });
                                cityList.appendChild(cityBtn);
                            });
                        })
                        .catch(() => {
                            cityList.innerHTML = '<div class="px-4 py-2 text-red-500">Failed to load cities</div>';
                            document.getElementById('city-trigger').querySelector('#city-text').textContent = 'Select City';
                        });
                });
            });

            // City Dropdown Logic (for loading old city if province was old)
            const oldProvinceId = document.getElementById('province-input').value; // Get old province ID
            const oldCityId = document.getElementById('city-input').value;         // Get old city ID
            const cityList = document.getElementById('city-list');
            const cityTriggerText = document.getElementById('city-text');

            if (oldProvinceId) {
                // Only load cities if there's an old province ID
                cityList.innerHTML = '<div class="px-4 py-2">Loading cities...</div>';
                fetch(`/register/cities/${oldProvinceId}`)
                    .then(response => response.json())
                    .then(cities => {
                        cityList.innerHTML = ''; // Clear loading
                        let foundOldCityName = 'Select City';

                        cities.forEach(city => {
                            const cityBtn = document.createElement('button');
                            cityBtn.type = 'button';
                            cityBtn.className = 'px-4 py-2 text-left city-btn';
                            cityBtn.textContent = city.cities_name;
                            cityBtn.addEventListener('click', () => {
                                document.getElementById('city-input').value = city.id;
                                cityTriggerText.textContent = city.cities_name;
                            });
                            cityList.appendChild(cityBtn);

                            // If this city matches the oldCityId, update the displayed text
                            if (oldCityId && city.id == oldCityId) {
                                foundOldCityName = city.cities_name;
                            }
                        });
                        // Set the city dropdown text to the old city's name (if found), or "Select City"
                        cityTriggerText.textContent = foundOldCityName;
                    })
                    .catch(() => {
                        cityList.innerHTML = '<div class="px-4 py-2 text-red-500">Failed to load cities</div>';
                        cityTriggerText.textContent = 'Select City'; // Reset on error
                    });
            }
        });
    </script>
@endpush

</x-auth-layout>