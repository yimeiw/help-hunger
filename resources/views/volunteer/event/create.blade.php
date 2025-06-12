<x-app-layout>
    @section('title', 'Events Register')

    @if($selectedEvent)
        <div class="mx-8 mt-8 mb-8">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('volunteer.events.show') }}" class="flex-shrink-0">
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
                            <p class="mb-4">Program <span class="font-bold">{{ $selectedEvent->event_name }}</span> by <span class="font-bold">"{{ $selectedEvent->partner->partner_name }}"</span></p>

                            <p class="text-sm text-justify mb-4">{{ $selectedEvent->first_paragraph }}</p>

                            <div class="flex flex-row gap-x-4 text-sm mb-2">
                                <svg width="24" height="24" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5079 7.50016C10.9008 6.76275 11.1055 5.93973 11.1039 5.10419C11.1039 2.28518 8.81872 0 5.99971 0C3.18069 0 0.895516 2.28518 0.895516 5.10419C0.893397 6.30827 1.31903 7.47396 2.0965 8.39339L2.10251 8.4009L2.10791 8.4069H2.0965L5.12539 11.6225C5.23767 11.7417 5.37314 11.8367 5.52347 11.9016C5.6738 11.9665 5.83581 12 5.99956 12C6.1633 12 6.32532 11.9665 6.47565 11.9016C6.62597 11.8367 6.76144 11.7417 6.87372 11.6225L9.90291 8.4069H9.8915L9.89631 8.4012L9.8969 8.4006C9.91852 8.37478 9.94004 8.34875 9.96146 8.32253C10.1698 8.06662 10.3528 7.7914 10.5079 7.50016ZM6.00121 7.05549C5.52343 7.05549 5.06521 6.86569 4.72737 6.52785C4.38953 6.19001 4.19973 5.7318 4.19973 5.25401C4.19973 4.77623 4.38953 4.31802 4.72737 3.98018C5.06521 3.64233 5.52343 3.45253 6.00121 3.45253C6.47899 3.45253 6.9372 3.64233 7.27504 3.98018C7.61289 4.31802 7.80269 4.77623 7.80269 5.25401C7.80269 5.7318 7.61289 6.19001 7.27504 6.52785C6.9372 6.86569 6.47899 7.05549 6.00121 7.05549Z" fill="#902B29"/>
                                </svg>
                                <p>{{ $selectedEvent->location->address }}</p>
                            </div>

                            <div class="flex flex-row gap-x-4 text-sm">
                                <svg width="24" height="23" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.94811 5.62963C8.94811 5.52674 8.98898 5.42807 9.06173 5.35532C9.13448 5.28257 9.23315 5.2417 9.33604 5.2417H10.1119C10.2148 5.2417 10.3135 5.28257 10.3862 5.35532C10.459 5.42807 10.4998 5.52674 10.4998 5.62963V6.40549C10.4998 6.50838 10.459 6.60705 10.3862 6.6798C10.3135 6.75255 10.2148 6.79342 10.1119 6.79342H9.33604C9.23315 6.79342 9.13448 6.75255 9.06173 6.6798C8.98898 6.60705 8.94811 6.50838 8.94811 6.40549V5.62963ZM6.62052 5.62963C6.62052 5.52674 6.66139 5.42807 6.73414 5.35532C6.80689 5.28257 6.90557 5.2417 7.00845 5.2417H7.78431C7.8872 5.2417 7.98587 5.28257 8.05862 5.35532C8.13137 5.42807 8.17225 5.52674 8.17225 5.62963V6.40549C8.17225 6.50838 8.13137 6.60705 8.05862 6.6798C7.98587 6.75255 7.8872 6.79342 7.78431 6.79342H7.00845C6.90557 6.79342 6.80689 6.75255 6.73414 6.6798C6.66139 6.60705 6.62052 6.50838 6.62052 6.40549V5.62963ZM2.74121 7.95722C2.74121 7.85433 2.78208 7.75566 2.85483 7.68291C2.92758 7.61016 3.02626 7.56929 3.12914 7.56929H3.905C4.00789 7.56929 4.10656 7.61016 4.17931 7.68291C4.25206 7.75566 4.29294 7.85433 4.29294 7.95722V8.73308C4.29294 8.83596 4.25206 8.93464 4.17931 9.00739C4.10656 9.08014 4.00789 9.12101 3.905 9.12101H3.12914C3.02626 9.12101 2.92758 9.08014 2.85483 9.00739C2.78208 8.93464 2.74121 8.83596 2.74121 8.73308V7.95722ZM5.0688 7.95722C5.0688 7.85433 5.10967 7.75566 5.18242 7.68291C5.25517 7.61016 5.35384 7.56929 5.45673 7.56929H6.23259C6.33548 7.56929 6.43415 7.61016 6.5069 7.68291C6.57965 7.75566 6.62052 7.85433 6.62052 7.95722V8.73308C6.62052 8.83596 6.57965 8.93464 6.5069 9.00739C6.43415 9.08014 6.33548 9.12101 6.23259 9.12101H5.45673C5.35384 9.12101 5.25517 9.08014 5.18242 9.00739C5.10967 8.93464 5.0688 8.83596 5.0688 8.73308V7.95722Z" fill="#902B29"/>
                                    <path d="M3.12958 0.586426C3.23247 0.586426 3.33114 0.627297 3.40389 0.700048C3.47664 0.772799 3.51751 0.871471 3.51751 0.974357V1.36229H9.72441V0.974357C9.72441 0.871471 9.76528 0.772799 9.83803 0.700048C9.91078 0.627297 10.0095 0.586426 10.1123 0.586426C10.2152 0.586426 10.3139 0.627297 10.3866 0.700048C10.4594 0.772799 10.5003 0.871471 10.5003 0.974357V1.36229H11.2761C11.6877 1.36229 12.0824 1.52577 12.3734 1.81678C12.6644 2.10778 12.8279 2.50247 12.8279 2.91401V11.4485C12.8279 11.86 12.6644 12.2547 12.3734 12.5457C12.0824 12.8367 11.6877 13.0002 11.2761 13.0002H1.96579C1.55424 13.0002 1.15956 12.8367 0.868552 12.5457C0.577547 12.2547 0.414063 11.86 0.414062 11.4485V2.91401C0.414063 2.50247 0.577547 2.10778 0.868552 1.81678C1.15956 1.52577 1.55424 1.36229 1.96579 1.36229H2.74165V0.974357C2.74165 0.871471 2.78252 0.772799 2.85527 0.700048C2.92802 0.627297 3.02669 0.586426 3.12958 0.586426ZM1.18992 3.68987V11.4485C1.18992 11.6543 1.27167 11.8516 1.41717 11.9971C1.56267 12.1426 1.76002 12.2244 1.96579 12.2244H11.2761C11.4819 12.2244 11.6792 12.1426 11.8247 11.9971C11.9703 11.8516 12.052 11.6543 12.052 11.4485V3.68987H1.18992Z" fill="#902B29"/>
                                </svg>

                                <p>{{ $selectedEvent->start_date }} — {{ $selectedEvent->end_date }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div>
                    @if($selectedEvent->remaining_description)
                        <div class="text-creamcard font-regular">
                            {{-- Use {!! !!} if your remaining description might contain HTML, like new paragraphs --}}
                            <p class="text-sm text-justify mb-4">{!! nl2br(e($selectedEvent->remaining_description)) !!}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-center items-center">
                <form action="{{ route('volunteer.events.store') }}" method="POST">
                    @csrf {{-- CSRF token for security --}}
                    <input type="hidden" name="event_id" value="{{ $selectedEvent->id }}">

                    <button type="submit" class="px-6 py-2 bg-creamcard border-2 border-redb rounded-lg text-redb font-bold hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">
                        I Want To Volunteer
                    </button>
                </form>
            </div>

            {{-- Add any validation error display here if you're redirecting back on error --}}
            @if ($errors->any())
                <div class="alert alert-danger text-red-600 text-center mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger text-red-600 text-center mt-4">
                    {{ session('error') }}
                </div>
            @endif

        </div>
    @endif

</x-app-layout>