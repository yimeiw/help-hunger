<header class="font-[poppins] w-full text-sm not-has-[nav]:hidden bg-greenbg">
    <nav class="flex items-center gap-32">
        <a href="{{ route('guest.welcome') }}" class="flex pl-8 pt-1.5 pb-2">
            <img src="{{ asset('/assets/logo home default.svg') }}" alt="Logo HelpHunger" class="w-64 h-20">
        </a>

        <div class="flex items-center justify-between w-full">
            <a href="{{ route('guest.about') }}">
                <p class="font-bold text-base transition duration-300 ease-out -mb-px -me-0
                        {{ request()->routeIs('guest.about') ? 'text-redb' : 'text-creamhh hover:underline hover:text-redb' }}">
                    About
                </p>
            </a>
            <a href="{{ route('guest.locations.index') }}" class="flex">
                <p class="font-bold text-base transition duration-300 ease-out -me-0
                        {{ request()->routeIs('guest.locations.index') ? 'text-redb' : 'text-creamhh hover:underline hover:text-redb' }}">
                        Location
                </p>
            </a>
            <a href="{{ route('guest.events') }}" class="flex ">
                <p class="font-bold text-base transition duration-300 ease-out -mb-px -me-0
                        {{ request()->routeIs('guest.events') ? 'text-redb' : 'text-creamhh hover:underline hover:text-redb' }}">
                        Event
                </p>
            </a>

            <a href="{{ route('guest.donations') }}" class="flex ">
                <p class="font-bold text-base transition duration-300 ease-out -mb-px -me-0
                        {{ request()->routeIs('guest.donations') ? 'text-redb' : 'text-creamhh hover:underline hover:text-redb' }}">
                        Donate
                </p>
            </a>

            <div class="ms-3 relative ">
                <x-dropdown align="right" width="48" contentClasses="bg-greenbg" dropdownClasses=" shadow-3xl">
                    <x-slot name="trigger">
                        <span class="inline-flex">
                            <button type="button" class="inline-flex items-center font-bold text-creamhh text-base leading-4 font-bold text-base transition duration-300 ease-out -mb-px -me-0 {{ request()->routeIs('guest.partner') ? 'text-redb' : 'text-creamhh hover:underline hover:text-redb' }}">
                                Our Partners
                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content" class="bg-greenbg scroll-smooth">
                        <x-dropdown-link href="{{ route('guest.partner')}}#community" class="text-left font-bold text-creamhh text-base hover:text-redb hover:underline hover:bg-transparent transition duration-300 ease-out">
                            Community
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('guest.partner')}}#ngo" class="text-left font-bold text-creamhh text-base hover:text-redb hover:underline hover:bg-transparent transition duration-300 ease-out">
                            NGO
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('guest.partner')}}#orphanage" class="text-left font-bold text-creamhh text-base hover:text-redb hover:underline hover:bg-transparent transition duration-300 ease-out">
                            Orphanage
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>

        <div class="flex flex-row items-center justify-end ms-auto me-8">
            <div>
                <svg width="20" height="20" viewBox="0 0 31 37" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blackAuth hover:text-redb transition duration-300 ease-in-out cursor-pointer">
                    <path d="M30.5746 29.1022L30.2258 28.782C29.2364 27.8648 28.3702 26.8132 27.6506 25.6556C26.8641 24.0581 26.3931 22.313 26.2655 20.5232V15.2521C26.2722 12.4411 25.2918 9.72425 23.5083 7.61206C21.7249 5.49986 19.2612 4.13767 16.5801 3.78143V2.40496C16.5801 2.02716 16.4358 1.66484 16.1789 1.39769C15.922 1.13055 15.5736 0.980469 15.2104 0.980469C14.8471 0.980469 14.4987 1.13055 14.2418 1.39769C13.985 1.66484 13.8407 2.02716 13.8407 2.40496V3.80277C11.1836 4.1847 8.74965 5.55512 6.98962 7.66022C5.22958 9.76532 4.26273 12.4624 4.26814 15.2521V20.5232C4.14046 22.313 3.6695 24.0581 2.88304 25.6556C2.17601 26.8105 1.32373 27.862 0.348838 28.782L0 29.1022V32.1112H30.5746V29.1022Z" fill="currentColor"/>
                    <path d="M12.5889 33.2314C12.6788 33.9078 13.0011 34.5275 13.4961 34.976C13.9912 35.4245 14.6256 35.6716 15.2821 35.6716C15.9387 35.6716 16.573 35.4245 17.0681 34.976C17.5631 34.5275 17.8854 33.9078 17.9753 33.2314H12.5889Z" fill="currentColor"/>
                </svg>

            </div> 
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}
            
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>
            
                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>
            
                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>
            
                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan
            
                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>
            
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>
            
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif
            
                <!-- Settings Dropdown -->
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex ml-6 rounded-md transition ease-in-out duration-150">
                                        <svg width="35" height="35" viewBox="0 0 59 61" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blackAuth hover:text-redb transition duration-300 ease-in-out cursor-pointer">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M29.5742 0.5C33.3825 0.499982 37.1535 1.26663 40.672 2.75617C44.1904 4.2457 47.3874 6.42896 50.0803 9.18128C52.7732 11.9336 54.9093 15.2011 56.3667 18.7972C57.8241 22.3933 58.5742 26.2475 58.5742 30.1399C58.5742 46.5097 45.5904 59.78 29.5742 59.78C13.558 59.78 0.574219 46.5097 0.574219 30.1399C0.574219 13.7703 13.558 0.5 29.5742 0.5ZM32.4742 33.104H26.6742C19.4947 33.104 13.3309 37.5482 10.6723 43.8922C14.8788 49.9209 21.7773 53.852 29.5742 53.852C37.371 53.852 44.2695 49.9209 48.4761 43.8918C45.8176 37.5482 39.6538 33.104 32.4742 33.104ZM29.5742 9.39199C24.7693 9.39199 20.8742 13.3731 20.8742 18.284C20.8742 23.1949 24.7693 27.176 29.5742 27.176C34.379 27.176 38.2741 23.1949 38.2741 18.284C38.2741 13.3731 34.3791 9.39199 29.5742 9.39199Z" fill="currentColor"/>
                                        </svg>

                                    </button>
                                </span>
                            @endif
                        </x-slot>
            
                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
            
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>
            
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif
            
                            <div class="border-t border-gray-200"></div>
            
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
            
                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>
</header>


