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

            <div class="flex flex-row gap-8 mt-4">
                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-48" type="password" name="password" required autocomplete="new-password" placeholder="Enter your password"/>
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-48" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password"/>
                </div>
            </div>

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


    </script>
</x-auth-layout>
