<x-app-layout>
    @section('title', 'Profile')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-redb leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>
            
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <x-section-border />
            
            <div class="mt-10 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
            @endif
            
            <x-section-border />

            <div class="flex justify-end">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                        <x-button href="{{ route('logout') }}" class="text-redb font-semibold text-xl"
                            @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                        </x-button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
