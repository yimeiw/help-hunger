<x-app-layout>
    @section('title', 'Donations')
    @inject('Storage', 'Illuminate\Support\Facades\Storage')

    <body>
        <div class="flex items-center justify-center text-center m-12 px-96">
            <p class="text-redb font-bold text-3xl">ONE DONATION, COUNTLESS IMPACT!</p>
        </div>
        <div class="space-y-8 mb-10">
            {{-- Baris pertama: 2 event --}}
            <div class="grid grid-cols-2 gap-6 mr-24 ml-24 ">
                @foreach ($events->take(2) as $event)
                <a href="{{ route('donatur.donations.create', ['event' => $event->id]) }}" class="flex flex-col bg-greenbg rounded-lg p-8 hover:bg-greenpastel transition duration-300 ease-in-out">
                    {{-- ... image section ... --}}
                    <div class="flex items-center justify-center mb-4">
                        @if ($event->image_path)
                            <img src="{{ asset('/' . $event->image_path) }}" alt="Event Image" class="w-full h-64 object-cover rounded-lg">
                        @else
                            <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-full h-64 object-cover rounded-lg">
                        @endif
                    </div>
                    <div>
                        <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                        {{-- Ini akan menampilkan total dari successfulDonations --}}
                        <p class="text-base font-bold text-redb">Rp{{ number_format($event->total_donation_amount, 0, ',', '.') }}</p>

                        @php
                            $target = $event->donation_target ?? 0;
                            // $donationCollectedAmount sekarang sudah datang dari controller
                            $donationCollectedAmount = $event->total_donation_amount; // Gunakan yang sudah dihitung di controller

                            $progress = $target > 0 ? min(100, ($donationCollectedAmount / $target) * 100) : 0;
                        @endphp

                        <div class="w-full bg-creamcard rounded-full h-4 overflow-hidden mt-2">
                            @if ($donationCollectedAmount > 0)
                                <div class="bg-redb h-4 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $progress }}%"></div>
                            @endif
                        </div>

                        {{-- Ini akan menampilkan count dari successfulDonations --}}
                        <p class="text-sm font-regular text-creamcard mt-2">{{ $event->donation_count }} donation</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Sisanya: tampilkan dalam 3 kolom per baris --}}
        <div class="ml-36 mr-36">
            <div class="flex gap-6 overflow-x-scroll scrollbar-hide pb-4">
                @foreach ($events->skip(2) as $event)
                    <a href="{{ route('donatur.donations.create', ['event' => $event->id]) }}" class="flex-shrink-0 w-80 flex flex-col bg-greenbg rounded-lg p-8 h-90 justify-between hover:bg-greenpastel transition duration-300 ease-in-out">
                        <div>
                            {{-- Gambar --}}
                            <div class="flex items-center justify-center mb-4">
                            @if ($event->image_path)
                                @php
                                    $imageUrl = '';
                                    // Check if the path starts with 'assets/' (from seeder/public directory)
                                    if ($event->image_path && str_starts_with($event->image_path, 'assets/')) {
                                        $imageUrl = asset($event->image_path);
                                    }
                                    // Otherwise, assume it's a path for storage (uploaded files)
                                    else if ($event->image_path) {
                                        $imageUrl = $Storage::url($event->image_path);
                                    }
                                    // Fallback for null/empty path or if no image is found via the above methods
                                    else {
                                        $imageUrl = asset('/assets/default-icon-community.svg'); // Your default image
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" alt="Event Image" class="w-50 h-44 object-cover rounded-lg">
                            @else
                                <img src="{{ asset('/assets/default-icon-community.svg') }}" alt="Default Event Image" class="w-32 h-32 object-cover rounded-lg">
                            @endif
                        </div>

                            {{-- Konten utama --}}
                            <p class="text-base font-bold text-creamcard">{{ $event->event_name }}</p>
                            {{-- Ini akan menampilkan total dari successfulDonations --}}
                            <p class="text-base font-bold text-redb mt-4">Rp{{ number_format($event->total_donation_amount, 0, ',', '.') }}</p>

                            @php
                                $target = $event->donation_target ?? 0; // Seharusnya $event->donation_target, bukan total_donation_target
                                // $donationCollectedAmount sekarang sudah datang dari controller
                                $donationCollectedAmount = $event->total_donation_amount; // Gunakan yang sudah dihitung di controller

                                $progress = $target > 0 ? min(100, ($donationCollectedAmount / $target) * 100) : 0;
                            @endphp

                            <div class="w-full bg-creamcard rounded-full h-4 overflow-hidden mt-2">
                                @if ($donationCollectedAmount > 0)
                                    <div class="bg-redb h-4 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $progress }}%"></div>
                                @endif
                            </div>

                            {{-- Ini akan menampilkan count dari successfulDonations --}}
                            <p class="text-sm font-regular text-creamcard mt-2">{{ $event->donation_count }} donation</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        </div>



    </body>
</x-app-layout>