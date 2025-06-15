<x-auth-layout>
@section('title', 'Login Account')
    <a href="{{ route('guest.welcome') }}" class="flex justify-end m-6">
        <img src="{{ asset('/assets/close-button.svg') }}" alt="" class="w-8 h-8">
    </a>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="flex flex-col px-20">
                <div x-data="{
                    email: '',
                    role: '',
                    roleOptions: ['volunteer', 'donatur'],
                    errorMessage: '',
                    checkEmailRoleCompatibility() {
                        if (this.email.endsWith('@admin.com')) {
                            this.errorMessage = '';
                            return;
                        }

                        if (!this.email || !this.role) {
                            return;
                        }

                        // Lakukan AJAX request untuk validasi
                        fetch('/api/check-email-role?email=' + encodeURIComponent(this.email) + '&role=' + this.role)
                            .then(response => response.json())
                            .then(data => {
                                this.errorMessage = data.valid ? '' : data.message;
                            });
                    }
                }">
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                
                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>
                
                <div class="mt-4">
                    <x-label for="role" value="{{ __('Choose Role') }}" />
                    <div x-data="{ open: false, selectedRole: 'Select Role' }" class="relative mt-1 w-full">
                        <button
                            type="button"
                            @click="open = !open"
                            class="relative w-full inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-xs font-bold text-redb leading-5 text-blackAuth pr-10"
                        >
                            <span x-text="selectedRole"></span>
                            <img src="{{ asset('/assets/arrow-down.svg') }}" alt="" class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6">
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-full bg-creamcard shadow-quadrupleNonHover rounded-lg">
                            <div class="flex flex-col text-xs font-bold">
                                <button
                                    type="button"
                                    class="px-4 py-2 text-left text-redb text-xs cursor-pointer"
                                    @click="selectedRole = 'Volunteer'; $refs.roleInput.value = 'volunteer'; open = false"
                                >
                                    Volunteer
                                </button>
                                <button
                                    type="button"
                                    class="px-4 py-2 text-left text-redb text-xs cursor-pointer"
                                    @click="selectedRole = 'Donatur'; $refs.roleInput.value = 'donatur'; open = false"
                                >
                                    Donatur
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="role" x-ref="roleInput" value="{{ old('role') }}">
                    </div>
                    <x-input-error for="role" class="mt-2" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" wire:model.defer="remember" />
                        <span class="ms-2 text-xs text-creamhh peer-checked:text-redb">{{ __('Remember me') }}</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>

                @if (Route::has('password.request'))
                    <a class="text-xs text-creamhh hover:text-redb hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

            </div>
        </form>
    </x-authentication-card>
</x-auth-layout>
