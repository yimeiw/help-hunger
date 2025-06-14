<footer class="flex flex-row bg-greenbg w-full p-6 gap-48 font-[poppins] bottom-0">
    <div class="flex flex-col justify-center items-center gap-4 pl-10 ">
        <img src="{{ asset('/assets/logo-footer.svg') }}" alt="">
        <p class="font-bold text-creamhh text-lg">©HelpHunger, 2025.</p>
    </div>

    <div class="flex flex-row gap-20">
        <div class="flex flex-col">
            <p class="font-bold text-redb text-base mb-3">Show Your Support</p>
            <a href="{{ route('volunteer.events.show') }}" class="font-regular text-creamhh text-sm hover:text-redb hover:underline transition duration-300 ease-in-out">Volunteer</a>
            <a href="{{ route('guest.donations') }}" class="font-regular text-creamhh text-sm  hover:text-redb hover:underline transition duration-300 ease-in-out">Donate</a>
        </div>

        <div class="flex flex-col">
            <p class="font-bold text-redb text-base mb-3">Learn More</p>
            <a href="{{ route('guest.about') }}" class="font-regular text-creamhh text-sm hover:text-redb hover:underline transition duration-300 ease-in-out">About</a>
            <a href="{{ route('guest.partner') }}" class="font-regular text-creamhh text-sm  hover:text-redb hover:underline transition duration-300 ease-in-out">Our Partner</a>
            <a href="{{ route('guest.locations.index') }}" class="font-regular text-creamhh text-sm  hover:text-redb hover:underline transition duration-300 ease-in-out">Location</a>
        </div>

                <div class="flex flex-col">
                    <p class="font-bold text-redb text-base mb-3">Contact</p>
                    <a href="" class="font-regular text-creamhh text-sm">Binus Anggrek, Jl. Kemanggisan Raya</a>
                    <a href="" class="flex flex-row items-center gap-2 font-regular text-creamhh text-sm">
                        <img src="{{ asset('/assets/email-icon-footer.svg') }}" alt="">
                        help.hunger@binus.ac.id
                    </a>
                    <a href="" class="flex flex-row items-center gap-2 font-regular text-creamhh text-sm">
                        <img src="{{ asset('/assets/phone-icon-footer.svg') }}" alt="">
                        021-333-555
                    </a>
                </div>                    
            </div>
</footer>