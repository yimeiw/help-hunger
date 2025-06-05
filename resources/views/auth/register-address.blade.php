<x-auth-layout>
    <a href="{{ route('guest.welcome') }}" class="flex justify-end m-6">
        <img src="{{ asset('/assets/close-button.svg') }}" alt="" class="w-8 h-8">
    </a>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="flex flex-col items-center">
            <div class="mb-4">
                <x-label for="gender" value="{{ __('Gender') }}"/>
                <x-dropdown-register align="left">
                    <x-slot name="trigger">
                        <button type="button" class="w-48 inline-flex items-center px-4 py-1 bg-creamcard shadow-quadrupleNonHover rounded-md text-sm font-bold text-redb leading-5 text-blackAuth">
                            {{ old('gender', 'Select Gender') }}
                            <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="ms-6 size-8">
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('register.address') }}" x-ref="form">
                            @csrf
                            <input type="hidden" name="gender" x-ref="genderInput" value="">
                            <div class="flex flex-col text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg">
                                <button type="button" @click="$refs.genderInput.value='Male'; $refs.form.submit()" class="px-4 py-2 text-left">Male</button>
                                <button type="button" @click="$refs.genderInput.value='Female'; $refs.form.submit()" class="px-4 py-2 text-left">Female</button>
                            </div>
                        </form>
                    </x-slot>
                </x-dropdown-register>

            </div>

            <div>
                <x-label for="dob" value="{{ __('Date of Birth') }}"/>
                <x-input id="dob" class="block mt-1 w-48 text-redb font-bold" type="date" name="dob" :value="old('dob')" required autocomplete="dob"/>
            </div>

            <!-- last disini -->
            <div>
                <x-label for="province" value="{{ __('Province') }}"/>
                <x-input id="dob" class="block mt-1 w-48 text-redb font-bold" type="date" name="dob" :value="old('dob')" required autocomplete="dob"/>
            </div>
        </div>
            

    </x-authentication-card>
</x-auth-layout>
