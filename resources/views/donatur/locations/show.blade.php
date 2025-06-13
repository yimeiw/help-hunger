<x-app-layout>
    @section('title', 'Location')
    <body>
        <div class="flex flex-row items-center justify-center rounded-lg bg-greenbg mt-12 ml-64 mr-64 mb-64 gap-24 p-8">
            <img src="{{ asset('/assets/logo home default.svg') }}" alt="">
            <div class="flex flex-col">
                <div class="font-bold text-creamhh text-lg">
                    <p>Find Nearest From Your Location</p>
                </div>
                <form action="{{ route('donatur.locations.search') }}" method="post" class="flex flex-row gap-4 items-center justify-center">
                    @csrf
                    <input type="number" name="zipcode" id="zipcode" placeholder="Enter Zip Code" class="rounded-lg font-regular text-lg pl-4 mt-4 mb-4 border border-creamcard bg-greenbg placeholder:text-creamcard focus:outline-none focus:border-redb focus:ring-1 focus:ring-redb">
                    <button type="submit" name="search" class="bg-creamcard text-redb border border-2 border-redb rounded-lg text-lg font-bold w-24 h-12">Search</button>
                </form>
            </div>
        </div>
    </body>
</x-app-layout>