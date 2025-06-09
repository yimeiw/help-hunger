<x-auth-layout>
    <a href="{{ route('guest.welcome') }}" class="flex justify-end m-6">
        <img src="{{ asset('/assets/close-button.svg') }}" alt="" class="w-8 h-8">
    </a>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="flex flex-col items-center h-auto">
            <form method="POST" action="{{ route('register.address') }}" x-ref="form">
            @csrf
                <div class="flex flex-col items-center w-full">
                    <div class="mb-4">
                        <x-label for="gender" value="{{ __('Gender') }}"/>
                        <x-dropdown-register align="left">
                            <x-slot name="trigger">
                                <button id="gender-trigger" type="button" class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10">
                                    {{ old('gender', 'Select Gender') }}
                                    <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6">
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <input type="hidden" name="gender" id="gender-input" value="">
                                <div class="flex flex-col text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg">
                                    <button type="button" onclick="setGender('Male')" class="px-4 py-2 text-left">Male</button>
                                    <button type="button" onclick="setGender('Female')" class="px-4 py-2 text-left">Female</button>
                                </div>
                            </x-slot>
                        </x-dropdown-register>
                    </div>

                    <div class="mb-4">
                        <x-label for="date_of_birth" value="{{ __('Date of Birth') }}"/>
                        <x-input id="date_of_birth" class="block mt-1 w-48 text-redb font-bold" type="date" name="date_of_birth" :value="old('date_of_birth')" required autocomplete="date_of_birth"/>
                    </div>

                    <!-- Province -->
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

                    <!-- City -->
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

                <div class="flex items-center">
                    <input type="checkbox" id="terms" class="peer rounded bg-transparent border-greyCheck text-redb shadow-sm focus:ring-redb">
                    <label for="terms" class="ms-2 text-xs text-creamhh peer-checked:text-redb">
                        {{ __('I Agree with the Terms and Condition') }}
                    </label>
                </div>


                <div class="flex flex-col items-center justify-end mt-4 text-xs">
                    <x-button class="ms-4">
                        {{ __('Sign Up') }}
                    </x-button>
                </div>
            </form>

        </div>
    </x-authentication-card>
    

    <script>
        function setGender(value) {
            document.getElementById('gender-input').value = value;
            document.getElementById('gender-trigger').childNodes[0].nodeValue = value + " ";
        }

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


    </script>

</x-auth-layout>
