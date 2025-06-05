@if (Route::has('register'))
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
                            <button type="button" class="inline-flex items-center  font-bold text-creamhh text-sm leading-4 font-bold text-base transition duration-300 ease-out -mb-px -me-0 {{ request()->routeIs('guest.partner') ? 'text-redb' : 'text-creamhh hover:underline hover:text-redb' }}">
                                Our Partners
                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content" class="bg-greenbg scroll-smooth">
                        <x-dropdown-link href="{{ route('guest.partner')}}#community" class="text-right font-bold text-creamhh text-base hover:text-redb hover:underline hover:bg-transparent transition duration-300 ease-out">
                            Community
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('guest.partner')}}#ngo" class="text-right font-bold text-creamhh text-base hover:text-redb hover:underline hover:bg-transparent transition duration-300 ease-out">
                            NGO
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('guest.partner')}}#orphanage" class="text-right font-bold text-creamhh text-base hover:text-redb hover:underline hover:bg-transparent transition duration-300 ease-out">
                            Orphanage
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>

        <div class="flex justify-end ms-auto me-8">
            <a
                href="{{ route('register') }}"
                class="flex items-center justify-center font-bold text-base text-redb border-redb bg-creamhh w-28 h-10 border rounded-lg hover:border-greenbg hover:text-greenbg transition duration-300 ease-in-out">
                Register
            </a>
        </div>
    </nav>
</header>
@endif
