<x-auth-layout>
    <a href="{{ route('guest.welcome') }}" class="flex justify-end m-6">
        <img src="{{ asset('/assets/close-button.svg') }}" alt="" class="w-8 h-8">
    </a>
    <x-authentication-card>
        
        <form method="POST" action="{{ route('register') }}">
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>
    
            <x-validation-errors class="mb-4" />
            @csrf

            <div class="flex flex-row justify-between gap-4">
                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Enter your full name"/>
                </div>

                <div>
                    <x-label for="phone" value="{{ __('Phone Number') }}" />
                    <div class="relative">
                        <span class="absolute left-3 top-1/2  -translate-y-1/2 text-xs text-greyAuth">+62</span>
                        <x-input
                            type="tel"
                            name="phone"
                            id="phone"
                            class="block w-[197px] pl-12 mt-1"
                            placeholder="Enter your phone number"
                            required
                        />
                    </div>
                </div>

            </div>

            <div class="flex flex-row justify-between gap-4 mt-4">
                <div>
                    <x-label for="username" value="{{ __('Username') }}" />
                    <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Enter your username"/>
                </div>
                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Enter your username"/>
                </div>
            </div>

            <div class="flex flex-row justify-between gap-4 mt-4">
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address"/>
                </div>

                <div>
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password"/>
                </div>
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
                    {{ __('Continue') }}
                </x-button>

                <a class="text-xs text-creamcard rounded-md hover:text-redb hover:underline transition duration-300 ease-in-out" href="{{ route('login') }}">
                    {{ __('Already have an account? Sign in here') }}
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-auth-layout>
