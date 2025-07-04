<x-auth-layout>
     @section('title', 'Register Account')
    <div class="flex justify-between items-center">
        <a href="#" onclick="history.back(); return false;" class="flex justify-end m-6">
            <img src="{{ asset('/assets/back-button.svg') }}" alt="" class="w-10 h-10">
        </a>
        <a href="{{ route('guest.welcome') }}" onclick="resetFormsAndNavigate(event);" class="flex justify-end m-6">
            <img src="{{ asset('/assets/close-button.svg') }}" alt="" class="w-8 h-8">
        </a>
    </div>
    <x-authentication-card>    
        <form method="POST" action="{{ route('partner.register.store') }}">
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>
    
            <x-validation-errors class="mb-4" />
            @csrf
            

            <div class="w-full">
                <x-label for="partner_name" value="{{ __('Community/NGO/Orphanage Name') }}" />
                <x-input id="partner_name" class="block mt-1 w-full" type="text" name="partner_name" :value="old('partner_name')" required autocomplete="partner_name" placeholder="Enter your Community/NGO/Orphanage Name"/>
            </div>

            <div class="flex flex-row gap-8 mt-4">
                <div>
                    <x-label for="type" value="{{ __('Type of Partner') }}"/>
                    <x-dropdown-register align="left">
                        <x-slot name="trigger">
                            <div class="relative">
                                <button id="type-trigger" type="button" class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10">
                                    <span id="type-text">{{ old('partner_type', 'Select Partner') }}</span>
                                    <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                </button>
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            <input type="hidden" name="type" id="type-input">
                            <div class="w-48 max-h-28 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg" id="type-list">
                                @foreach ($partnerTypes as $type)
                                    <button type="button" class="px-4 py-2 text-left type-btn text-capitalize" data-id="{{ $type }}">
                                        {{ ucwords($type) }}
                                    </button>
                                @endforeach
                            </div>
                        </x-slot>
                    </x-dropdown-register>
                </div>
                
                <div>
                    <x-label for="partner_email" value="{{ __('Email') }}" />
                    <x-input id="partner_email" class="block mt-1 w-48" type="email" name="partner_email" :value="old('partner_email')" required autocomplete="email" placeholder="Enter your email address"/>
                </div>
            </div>

            <div class="flex flex-row gap-8 mt-4 mb-4">
                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-48" type="password" name="password" required autocomplete="new-password" placeholder="Enter your password"/>
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-48" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password"/>
                </div>
            </div>
            
            <div id="payment-fields-container">
                <div class="flex flex-row mb-4 items-center gap-8 payment-field-row">
                    <div class="w-1/2">
                        <x-label for="rekening_type_0" value="Payment Type" />
                        <div class="relative"> <select id="rekening_type_0" name="payment_methods[0][rekening_type]" class="appearance-none w-full pl-4 pr-10 py-3 bg-creamcard border border-gray-300 rounded-lg shadow-[4px_5px_0px_rgb(144,43,41,1)] focus:outline-none text-xs font-bold text-redb transition-all duration-200 cursor-pointer" required>
                                <option value="">Select Payment Type</option>
                                <option value="BCA">BCA</option>
                                <option value="Master Card">Master Card</option>
                                <option value="Link Aja">Link Aja</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                </div>
                        </div> <x-input-error :messages="$errors->get('payment_methods.0.rekening_type')" class="mt-2" />
                    </div>
                    <div class="w-1/2">
                        <x-label for="no_rekening_0" value="Rekening Number" />
                        <x-input id="no_rekening_0" type="text" name="payment_methods[0][no_rekening]" class="block w-full mt-1" placeholder="e.g., 2702297731" required />
                        <x-input-error :messages="$errors->get('payment_methods.0.no_rekening')" class="mt-2" />
                    </div>
                    <div>
                        <img src="{{ asset('assets/add.svg') }}" alt="Add Payment" class="w-8 h-8 cursor-pointer add-payment-field mt-6">
                    </div>
                </div>
            </div>

            <template id="payment-field-template">
                <div class="flex flex-row mb-4 items-center gap-4 payment-field-row">
                    <div class="w-1/2">
                        <x-label value="Payment Type" />
                        <div class="relative">
                            <select name="payment_methods[INDEX][rekening_type]"
                                    class="appearance-none w-full pl-4 pr-10 py-3 bg-creamcard border-none rounded-lg shadow-[4px_5px_0px_rgb(144,43,41,1)] focus:outline-none text-sm font-bold text-redb transition-all duration-200 cursor-pointer">
                                <option value="">Select Payment Type</option>
                                <option value="BCA">BCA</option>
                                <option value="Master Card">Master Card</option>
                                <option value="Link Aja">Link Aja</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                </div>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <x-label value="Rekening Number" />
                        <x-input type="number" name="payment_methods[INDEX][no_rekening]" class="block w-full mt-1" placeholder="e.g., 2702297731" required />
                    </div>
                    <div>
                        <img src="{{ asset('assets/remove.svg') }}" alt="Remove Payment" class="w-10 h-10 cursor-pointer remove-payment-field mt-6">
                    </div>
                </div>
            </template>

            <!-- Provinces and Cities -->
            <div class="flex flex-row gap-8 mt-4">
                <div class="mb-4 relative">
                    <x-label for="province" value="{{ __('Province') }}"/>
                        <x-dropdown-register align="left">
                            <x-slot name="trigger">
                                <div class="relative">
                                    <button id="province-trigger" type="button" class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10">
                                        <span id="province-text">{{ old('province', 'Select Province') }}</span>
                                        <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                    </button>
                                </div>
                            </x-slot>

                            <x-slot name="content">
                                <input type="hidden" name="province" id="province-input">
                                <div class="w-48 max-h-28 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg" id="province-list">
                                    @foreach ($provinces as $province)
                                        <button type="button" class="px-4 py-2 text-left province-btn" data-id="{{ $province->id }}">
                                            {{ $province->province_name }}
                                        </button>
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-dropdown-register>
                </div>

                <div class="mb-4 relative">
                    <x-label for="city" value="{{ __('City') }}"/>
                    <x-dropdown-register align="left">
                        <x-slot name="trigger">
                            <div class="relative">
                                <button id="city-trigger" type="button" class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10">
                                    <span id="city-text">{{ old('city', 'Select City') }}</span>
                                    <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                </button>
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            <input type="hidden" name="city" id="city-input">
                            <div class="w-48 max-h-28 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg" id="city-list">
                                <!-- Cities loaded here -->
                            </div>
                        </x-slot>
                    </x-dropdown-register>
                </div>
            </div>
                
            
            <div class="w-full">
                <x-label for="partner_link" value="{{ __('Your Website Link') }}" />
                <x-input id="partner_link" class="block mt-1 w-full" type="text" name="partner_link" :value="old('partner_link')" required autocomplete="partner_link" placeholder="Enter your link"/>
            </div>
           


            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex flex-col items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Submit') }}
                </x-button>

                <a class="text-xs text-creamcard rounded-md hover:text-redb hover:underline transition duration-300 ease-in-out" href="{{ route('partner.login') }}">
                    {{ __('Already have an account? Sign in here') }}
                </a>
            </div>
        </form>
    </x-authentication-card>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const partnerTypeButtons = document.querySelectorAll('.type-btn');
            const partnerTypeInput = document.getElementById('type-input');
            const partnerTypeText = document.getElementById('type-text');

            partnerTypeButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const partnerTypeName = btn.textContent.trim();
                    const partnerTypeId = btn.getAttribute('data-id');

                    partnerTypeInput.value = partnerTypeId;
                    partnerTypeText.textContent = partnerTypeName;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const provinceButtons = document.querySelectorAll('.province-btn');
            const provinceInput = document.getElementById('province-input');
            const provinceText = document.getElementById('province-text');

            provinceButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const provinceName = btn.textContent.trim();
                    const provinceId = btn.getAttribute('data-id');

                    provinceInput.value = provinceId;
                    provinceText.textContent = provinceName;
                });
            });
        });



        document.addEventListener('DOMContentLoaded', function () {
            const provinceButtons = document.querySelectorAll('.province-btn');
            const provinceInput = document.getElementById('province-input');
            const provinceTrigger = document.getElementById('province-trigger');
            const cityList = document.getElementById('city-list');
            const cityInput = document.getElementById('city-input');
            const cityTrigger = document.getElementById('city-trigger');

            provinceButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const provinceId = this.dataset.id;
                    const provinceName = this.textContent.trim();

                    provinceInput.value = provinceId;
                    provinceTrigger.querySelector('#province-text').textContent = provinceName;

                    // Reset city input and UI (sama seperti sebelumnya)
                    cityInput.value = '';
                    cityTrigger.querySelector('#city-text').textContent = 'Select City';
                    cityList.innerHTML = '<div class="px-4 py-2">Loading...</div>';
                    // Fetch cities from backend
                    fetch(`/register/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(cities => {
                            console.log(cities); // debug dulu
                            cityList.innerHTML = '';

                            cities.forEach(city => {
                                const cityBtn = document.createElement('button');
                                cityBtn.type = 'button';
                                cityBtn.className = 'px-4 py-2 text-left city-btn';
                                cityBtn.textContent = city.cities_name;
                                cityBtn.addEventListener('click', () => {
                                    cityInput.value = city.id;
                                    cityTrigger.querySelector('#city-text').textContent = city.cities_name;

                                });
                                cityList.appendChild(cityBtn);
                            });
                        })
                        .catch(() => {
                            cityList.innerHTML = '<div class="px-4 py-2 text-red-500">Failed to load cities</div>';
                        });
                });
            });
        });

        function resetFormsAndNavigate(event) {
            // Mencegah navigasi default terlebih dahulu
            event.preventDefault(); 
        
            // Temukan semua form di halaman dan reset
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.reset(); // Mereset semua input di dalam form
            });
        
            // Setelah mereset form, arahkan ke halaman guest.welcome
            window.location.href = "{{ route('guest.welcome') }}";
        }
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('payment-fields-container');
            const template = document.getElementById('payment-field-template');
            let fieldIndex = 0; // Start index for new fields (initial 0 is often in HTML already)

            // Handle adding new fields
            container.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-payment-field')) {
                    fieldIndex++; // Increment index for new field
                    const newRow = template.content.cloneNode(true); // Clone the template content

                    // Get all input AND select elements within the new row
                    const formElements = newRow.querySelectorAll('.payment-field-row input, .payment-field-row select');

                    // Update the names in the cloned row
                    formElements.forEach(element => {
                        const currentName = element.getAttribute('name');
                        if (currentName && currentName.includes('[INDEX]')) { // Ensure it has the placeholder
                            element.setAttribute('name', currentName.replace('INDEX', fieldIndex));
                            // Update IDs for labels if you plan to link them dynamically
                            element.setAttribute('id', `payment_${fieldIndex}_${currentName.split('[')[2].replace(']','')}`);
                        }
                    });

                    // Set initial value for new input/select fields
                    formElements.forEach(element => {
                        if (element.tagName === 'INPUT') {
                            element.value = ''; // Clear default value from template
                        } else if (element.tagName === 'SELECT') {
                            element.selectedIndex = 0; // Reset select to the first option (e.g., "Select Payment Type")
                        }
                    });

                    // Append the new row
                    container.appendChild(newRow);

                    // Add focus to the first input/select of the newly added row
                    newRow.querySelector('input, select').focus();
                }
            });

            // Handle removing fields
            container.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-payment-field')) {
                    const rowToRemove = event.target.closest('.payment-field-row');
                    if (rowToRemove) {
                        rowToRemove.remove();
                    }
                }
            });

            // The initial add button setup line doesn't seem to have a functional impact
            // given the image is directly embedded and not dynamically changed by this JS.
            // You can safely remove it if it's not doing anything specific.
            // const initialAddButton = container.querySelector('.add-payment-field');
            // if (initialAddButton) {
            //     initialAddButton.closest('.payment-field-row').querySelector('.add-payment-field').setAttribute('src', '{{ asset('assets/add.svg') }}');
            // }
        });



    </script>
</x-auth-layout>
