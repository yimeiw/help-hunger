<x-auth-layout>
@section('title', 'Login Account')
    <a href="{{ route('guest.welcome') }}" class="flex justify-end m-6">
        <img src="{{ asset('/assets/close-button.svg') }}" alt="" class="w-8 h-8">
    </a>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('partner.login.attempt') }}">
            @csrf

            <div class="flex flex-col px-20">
                <div>
                    <x-label for="partner_email" value="{{ __('Email') }}" />
                    <x-input id="partner_email" class="block mt-1 w-full" type="email" name="partner_email" :value="old('partner_email')" required autofocus autocomplete="partner_email" />
                </div>

                
                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
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

            </div>
        </form>
    </x-authentication-card>
</x-auth-layout>
