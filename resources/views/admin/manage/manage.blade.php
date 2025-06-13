<x-app-layout>
    @section('title', 'Manage User')
    <body>
        <div class="flex flex-row gap-8 px-20 py-12">
            <button>
                <a 
                    href="{{ route('admin.manage-user') }}" 
                    class="flex items-center justify-center font-bold text-base text-redb border-redb bg-creamcard
                    w-28 h-10 md:w-20 md:text-xs lg:text-sm lg:w-28 xl:text-base xl:w-32 border-2 rounded-lg 
                    hover:border-greenbg hover:text-greenbg transition duration-300 ease-in-out">
                    Volunteer
                </a>
            </button>
            <button>
                <a 
                    href="{{ route('admin.manage-user') }}" 
                    class="flex items-center justify-center font-bold text-base text-redb border-redb bg-creamcard
                    w-28 h-10 md:w-20 md:text-xs lg:text-sm lg:w-28 xl:text-base xl:w-32 border-2 rounded-lg 
                    hover:border-greenbg hover:text-greenbg transition duration-300 ease-in-out">
                    Donatur
                </a>
            </button>
            <button>
                <a 
                    href="{{ route('admin.manage-user') }}" 
                    class="flex items-center justify-center font-bold text-base text-redb border-redb bg-creamcard
                    w-28 h-10 md:w-20 md:text-xs lg:text-sm lg:w-28 xl:text-base xl:w-32 border-2 rounded-lg 
                    hover:border-greenbg hover:text-greenbg transition duration-300 ease-in-out">
                    Partner
                </a>
            </button>
        </div>
    </body>
</x-app-layout>