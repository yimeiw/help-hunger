<x-app-layout>
    @section('title', 'Events Register')

    @if($selectedEvent)
        <div class="mx-8 mt-8 mb-8">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('donatur.details.show') }}" class="flex-shrink-0">
                    <svg width="44" height="44" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="9" y="9" width="52" height="52" rx="26" stroke="#3F8044" stroke-width="2"/>
                        <rect x="11" y="11" width="48" height="48" rx="24" fill="#1E1E1E"/>
                        <rect x="11" y="11" width="48" height="48" rx="24" stroke="#D9D9D9" stroke-width="2"/>
                        <path d="M39 22.5L27 35L39 47.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <div class="text-center flex-grow">
                    <h2 class="uppercase text-xl text-redb font-bold max-w-xl mx-auto">
                        {{ $selectedEvent->event_name }}
                    </h2>
                </div>
            </div>

            <div class="bg-greenbg rounded-lg p-8 mb-8 ">
                <div class="flex flex-row gap-x-4 mb-6">
                    <div>
                        <img src="{{ asset($selectedEvent->image_path) }}" alt="" class="h-full">
                    </div>

                    <div class="flex flex-col">
                        <div class="text-creamcard font-regular max-w-2xl">
                            <p class="mb-2 text-lg"><span class="font-bold">{{ $selectedEvent->event_name }}</span> by <span class="font-bold">"{{ $selectedEvent->partner->partner_name }}"</span></p>

                            <p class="text-sm font-bold">Total Donation Donated by You: Rp{{ number_format($totalDonatedAmountByYou, 0, ',', '.') }}</p>

                            {{-- Pastikan ini untuk total donasi/transaksi sukses di event ini (dari semua donatur) --}}
                            <p class="text-sm">Total Donations (for this event): {{ $selectedEvent->total_donations_count_for_event ?? 0 }}</p>

                            {{-- Atau jika Anda ingin menampilkan total uang yang terkumpul untuk event ini: --}}
                            <p class="text-sm">Total Amount Collected (for this event): Rp{{ number_format($selectedEvent->total_donations_collected_amount ?? 0, 0, ',', '.') }}</p>


                            <p class="text-xs text-justify mb-4 mt-4">{{ $selectedEvent->first_paragraph }}</p>

                            <div class="flex flex-row gap-x-4 text-xs mb-2">
                                <svg width="24" height="24" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5079 7.50016C10.9008 6.76275 11.1055 5.93973 11.1039 5.10419C11.1039 2.28518 8.81872 0 5.99971 0C3.18069 0 0.895516 2.28518 0.895516 5.10419C0.893397 6.30827 1.31903 7.47396 2.0965 8.39339L2.10251 8.4009L2.10791 8.4069H2.0965L5.12539 11.6225C5.23767 11.7417 5.37314 11.8367 5.52347 11.9016C5.6738 11.9665 5.83581 12 5.99956 12C6.1633 12 6.32532 11.9665 6.47565 11.9016C6.62597 11.8367 6.76144 11.7417 6.87372 11.6225L9.90291 8.4069H9.8915L9.89631 8.4012L9.8969 8.4006C9.91852 8.37478 9.94004 8.34875 9.96146 8.32253C10.1698 8.06662 10.3528 7.7914 10.5079 7.50016ZM6.00121 7.05549C5.52343 7.05549 5.06521 6.86569 4.72737 6.52785C4.38953 6.19001 4.19973 5.7318 4.19973 5.25401C4.19973 4.77623 4.38953 4.31802 4.72737 3.98018C5.06521 3.64233 5.52343 3.45253 6.00121 3.45253C6.47899 3.45253 6.93720 3.64233 7.27504 3.98018C7.61289 4.31802 7.80269 4.77623 7.80269 5.25401C7.80269 5.73180 7.61289 6.19001 7.27504 6.52785C6.93720 6.86569 6.47899 7.05549 6.00121 7.05549Z" fill="#902B29"/>
                                </svg>
                                <p>{{ $selectedEvent->location->address }}</p>
                            </div>

                            <div class="flex flex-row gap-x-4 text-xs">
                                <svg width="24" height="23" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.94811 5.62963C8.94811 5.52674 8.98898 5.42807 9.06173 5.35532C9.13448 5.28257 9.23315 5.24170 9.33604 5.24170H10.1119C10.2148 5.24170 10.3135 5.28257 10.3862 5.35532C10.4590 5.42807 10.4998 5.52674 10.4998 5.62963V6.40549C10.4998 6.50838 10.4590 6.60705 10.3862 6.67980C10.3135 6.75255 10.2148 6.79342 10.1119 6.79342H9.33604C9.23315 6.79342 9.13448 6.75255 9.06173 6.67980C8.98898 6.60705 8.94811 6.50838 8.94811 6.40549V5.62963ZM6.62052 5.62963C6.62052 5.52674 6.66139 5.42807 6.73414 5.35532C6.80689 5.28257 6.90557 5.24170 7.00845 5.24170H7.78431C7.88720 5.24170 7.98587 5.28257 8.05862 5.35532C8.13137 5.42807 8.17225 5.52674 8.17225 5.62963V6.40549C8.17225 6.50838 8.13137 6.60705 8.05862 6.67980C7.98587 6.75255 7.88720 6.79342 7.78431 6.79342H7.00845C6.90557 6.79342 6.80689 6.75255 6.73414 6.67980C6.66139 6.60705 6.62052 6.50838 6.62052 6.40549V5.62963ZM2.74121 7.95722C2.74121 7.85433 2.78208 7.75566 2.85483 7.68291C2.92758 7.61016 3.02626 7.56929 3.12914 7.56929H3.905C4.00789 7.56929 4.10656 7.61016 4.17931 7.68291C4.25206 7.75566 4.29294 7.85433 4.29294 7.95722V8.73308C4.29294 8.83596 4.25206 8.93464 4.17931 9.00739C4.10656 9.08014 4.00789 9.12101 3.90500 9.12101H3.12914C3.02626 9.12101 2.92758 9.08014 2.85483 9.00739C2.78208 8.93464 2.74121 8.83596 2.74121 8.73308V7.95722ZM5.06880 7.95722C5.06880 7.85433 5.10967 7.75566 5.18242 7.68291C5.25517 7.61016 5.35384 7.56929 5.45673 7.56929H6.23259C6.33548 7.56929 6.43415 7.61016 6.50690 7.68291C6.57965 7.75566 6.62052 7.85433 6.62052 7.95722V8.73308C6.62052 8.83596 6.57965 8.93464 6.50690 9.00739C6.43415 9.08014 6.33548 9.12101 6.23259 9.12101H5.45673C5.35384 9.12101 5.25517 9.08014 5.18242 9.00739C5.10967 8.93464 5.06880 8.83596 5.06880 8.73308V7.95722Z" fill="#902B29"/>
                                </svg>
                                <p>{{ $selectedEvent->start_date }} — {{ $selectedEvent->end_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    @if($selectedEvent->remaining_description)
                        <div class="text-creamcard font-regular">
                            <p class="text-xs text-justify mb-4">{!! nl2br(e($selectedEvent->remaining_description)) !!}</p>
                        </div>
                    @endif
                </div>
                
                <!-- Tambah case ongoing -->
                @php
                    $eventStartDate = $selectedEvent->start_date;
                    if (!($eventStartDate instanceof \Carbon\Carbon)) {
                        $eventStartDate = \Carbon\Carbon::parse($eventStartDate);
                    }

                    $eventEndDate = $selectedEvent->end_date;
                    if (!($eventEndDate instanceof \Carbon\Carbon)) {
                        $eventEndDate = \Carbon\Carbon::parse($eventEndDate);
                    }

                    $eventIsUpcoming = $eventStartDate->gt($now);
                    $eventIsDone = $eventEndDate->lt($now);
                    $eventIsOngoing = $eventStartDate->lte($now) && $eventEndDate->gte($now);
                @endphp

                @if (!$eventIsDone && !$eventIsOngoing)
                    <div class="flex justify-center items-center mt-10">
                        <form id="cancelParticipationForm" action="{{ route('volunteer.cancel_participation', ['event' => $selectedEvent->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" id="confirmCancelButton" class="px-6 py-2 bg-creamcard border-2 border-redb rounded-lg text-redb font-bold hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                                Cancel To Volunteer
                            </button>
                        </form>
                    </div>
                {{-- Tombol Download Certificate jika event sudah selesai --}}
                @elseif ($eventIsDone)
                    <div class="flex justify-center items-center mt-10">
                        {{-- **PERBAIKAN DI SINI:** Ambil EventsVolunteersDetail yang spesifik untuk event ini --}}
                        @php
                            // $eventDetails adalah koleksi semua partisipasi user.
                            // Kita perlu mencari partisipasi yang cocok dengan $selectedEvent
                            $selectedEventDetailForDownload = $eventDetails->where('event_id', $selectedEvent->id)->first();
                        @endphp

                        @if ($selectedEventDetailForDownload)
                            <a href="{{ route('donatur.certificate.download', $selectedEventDetailForDownload->id) }}" class="px-6 py-2 bg-creamcard border-2 border-redb rounded-lg text-redb font-bold hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                                Download Certificate
                            </a>
                        @else
                            {{-- Ini seharusnya tidak terjadi jika logika controller benar,
                                tapi sebagai fallback jika detail partisipasi tidak ditemukan --}}
                            <p class="text-gray-500">Certificate not available (participation detail not found).</p>
                        @endif
                    </div>
                {{-- Tombol Volunteer Now jika belum berpartisipasi atau sudah dibatalkan/belum diterima --}}
                @elseif($eventIsOngoing)
                    <div class="flex justify-center items-center mt-10">
                        <a href="" class="px-6 py-2 bg-greyAuth border-2 border-greyAuth rounded-lg text-redb font-bold hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                            Fighting!
                        </a>
                    </div>
                @else
                    <div class="flex justify-center items-center mt-10">
                        <a href="{{ route('volunteer.events.create', ['event' => $selectedEvent->id]) }}" class="px-6 py-2 bg-creamcard border-2 border-redb rounded-lg text-redb font-bold hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                            Volunteer Now
                        </a>
                    </div>
                @endif

            </div> {{-- Penutup div class="bg-greenbg rounded-lg p-8 mb-8" --}}

        </div> {{-- Penutup div class="mx-8 mt-8 mb-8" --}}

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const confirmButton = document.getElementById('confirmCancelButton');
                    if (confirmButton) { // Pastikan tombol ada sebelum menambahkan event listener
                        confirmButton.addEventListener('click', function(event) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You will not be able to return your participation!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#902B29', // Merah untuk konfirmasi batal
                                cancelButtonColor: '#3085d6', // Biru untuk batal
                                background: '#FFF7D9',
                                color: '#902B29',
                                confirmButtonText: 'Yes, Cancel Participation!',
                                cancelButtonText: 'No, Keep Participation'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika user mengklik 'Ya, Batalkan Partisipasi!', submit form
                                    document.getElementById('cancelParticipationForm').submit();
                                }
                            });
                        });
                    }
                });
            </script>
        @endpush

    @endif {{-- Penutup @if($selectedEvent) --}}
</x-app-layout>