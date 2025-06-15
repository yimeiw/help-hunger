<x-app-layout>
    @section('title', 'Donatur Register')
    @inject('Storage', 'Illuminate\Support\Facades\Storage')


    @if($event)
        <div class="mx-8 mt-8 mb-8">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('donatur.donations.show') }}" class="flex-shrink-0">
                    <svg width="44" height="44" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="9" y="9" width="52" height="52" rx="26" stroke="#3F8044" stroke-width="2"/>
                        <rect x="11" y="11" width="48" height="48" rx="24" fill="#1E1E1E"/>
                        <rect x="11" y="11" width="48" height="48" rx="24" stroke="#D9D9D9" stroke-width="2"/>
                        <path d="M39 22.5L27 35L39 47.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <div class="text-center flex-grow">
                    <h2 class="uppercase text-xl text-redb font-bold max-w-xl mx-auto">
                        {{ $event->event_name }}
                    </h2>
                </div>
            </div>

            <div class="flex flex-row">
                <div class="p-8 mb-8 text-redb w-1/2">
                    <div class="bg-greenbg p-8 rounded-lg  mb-4 flex items-center justify-center">
                        {{-- Display the event image --}}
                        @php
                            $imageUrl = '';
                            if ($event->image_path && str_starts_with($event->image_path, 'assets/')) {
                                $imageUrl = asset($event->image_path);
                            }
                            else if ($event->image_path) {
                                $imageUrl = $Storage::url($event->image_path);
                            }
                            // Fallback for null/empty path or if no image is found via the above methods
                            else {
                                $imageUrl = asset('/assets/default-icon-community.svg'); // Your default image
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="Event Image" class="h-full">
                    </div>

                    <p class="mb-4 font-bold">{{ $event->event_name }} </p>
                    <p class="text-sm text-justify mb-4">{{ $event->first_paragraph }}</p>
                    @if($event->remaining_description)
                        <div class="text-redb font-regular">
                            <p class="text-sm text-justify mb-4">{!! nl2br(e($event->remaining_description)) !!}</p>
                        </div>
                    @endif
        

                    <div class="flex flex-row gap-x-4 text-sm mb-2">
                        <svg width="24" height="24" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.5079 7.50016C10.9008 6.76275 11.1055 5.93973 11.1039 5.10419C11.1039 2.28518 8.81872 0 5.99971 0C3.18069 0 0.895516 2.28518 0.895516 5.10419C0.893397 6.30827 1.31903 7.47396 2.0965 8.39339L2.10251 8.4009L2.10791 8.4069H2.0965L5.12539 11.6225C5.23767 11.7417 5.37314 11.8367 5.52347 11.9016C5.6738 11.9665 5.83581 12 5.99956 12C6.1633 12 6.32532 11.9665 6.47565 11.9016C6.62597 11.8367 6.76144 11.7417 6.87372 11.6225L9.90291 8.4069H9.8915L9.89631 8.4012L9.8969 8.4006C9.91852 8.37478 9.94004 8.34875 9.96146 8.32253C10.1698 8.06662 10.3528 7.7914 10.5079 7.50016ZM6.00121 7.05549C5.52343 7.05549 5.06521 6.86569 4.72737 6.52785C4.38953 6.19001 4.19973 5.7318 4.19973 5.25401C4.19973 4.77623 4.38953 4.31802 4.72737 3.98018C5.06521 3.64233 5.52343 3.45253 6.00121 3.45253C6.47899 3.45253 6.9372 3.64233 7.27504 3.98018C7.61289 4.31802 7.80269 4.77623 7.80269 5.25401C7.80269 5.7318 7.61289 6.19001 7.27504 6.52785C6.9372 6.86569 6.47899 7.05549 6.00121 7.05549Z" fill="#902B29"/>
                        </svg>
                        <p>{{ $event->location->address }}</p>
                    </div>

                    <div class="flex flex-row gap-x-4 text-sm">
                        <svg width="24" height="23" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.94811 5.62963C8.94811 5.52674 8.98898 5.42807 9.06173 5.35532C9.13448 5.28257 9.23315 5.2417 9.33604 5.2417H10.1119C10.2148 5.2417 10.3135 5.28257 10.3862 5.35532C10.459 5.42807 10.4998 5.52674 10.4998 5.62963V6.40549C10.4998 6.50838 10.459 6.60705 10.3862 6.6798C10.3135 6.75255 10.2148 6.79342 10.1119 6.79342H9.33604C9.23315 6.79342 9.13448 6.75255 9.06173 6.6798C8.98898 6.60705 8.94811 6.50838 8.94811 6.40549V5.62963ZM6.62052 5.62963C6.62052 5.52674 6.66139 5.42807 6.73414 5.35532C6.80689 5.28257 6.90557 5.2417 7.00845 5.2417H7.78431C7.8872 5.2417 7.98587 5.28257 8.05862 5.35532C8.13137 5.42807 8.17225 5.52674 8.17225 5.62963V6.40549C8.17225 6.50838 8.13137 6.60705 8.05862 6.6798C7.98587 6.75255 7.8872 6.79342 7.78431 6.79342H7.00845C6.90557 6.79342 6.80689 6.75255 6.73414 6.6798C6.66139 6.60705 6.62052 6.50838 6.62052 6.40549V5.62963ZM2.74121 7.95722C2.74121 7.85433 2.78208 7.75566 2.85483 7.68291C2.92758 7.61016 3.02626 7.56929 3.12914 7.56929H3.905C4.00789 7.56929 4.10656 7.61016 4.17931 7.68291C4.25206 7.75566 4.29294 7.85433 4.29294 7.95722V8.73308C4.29294 8.83596 4.25206 8.93464 4.17931 9.00739C4.10656 9.08014 4.00789 9.12101 3.905 9.12101H3.12914C3.02626 9.12101 2.92758 9.08014 2.85483 9.00739C2.78208 8.93464 2.74121 8.83596 2.74121 8.73308V7.95722ZM5.0688 7.95722C5.0688 7.85433 5.10967 7.75566 5.18242 7.68291C5.25517 7.61016 5.35384 7.56929 5.45673 7.56929H6.23259C6.33548 7.56929 6.43415 7.61016 6.5069 7.68291C6.57965 7.75566 6.62052 7.85433 6.62052 7.95722V8.73308C6.62052 8.83596 6.57965 8.93464 6.5069 9.00739C6.43415 9.08014 6.33548 9.12101 6.23259 9.12101H5.45673C5.35384 9.12101 5.25517 9.08014 5.18242 9.00739C5.10967 8.93464 5.0688 8.83596 5.0688 8.73308V7.95722Z" fill="#902B29"/>
                            <path d="M3.12958 0.586426C3.23247 0.586426 3.33114 0.627297 3.40389 0.700048C3.47664 0.772799 3.51751 0.871471 3.51751 0.974357V1.36229H9.72441V0.974357C9.72441 0.871471 9.76528 0.772799 9.83803 0.700048C9.91078 0.627297 10.0095 0.586426 10.1123 0.586426C10.2152 0.586426 10.3139 0.627297 10.3866 0.700048C10.4594 0.772799 10.5003 0.871471 10.5003 0.974357V1.36229H11.2761C11.6877 1.36229 12.0824 1.52577 12.3734 1.81678C12.6644 2.10778 12.8279 2.50247 12.8279 2.91401V11.4485C12.8279 11.86 12.6644 12.2547 12.3734 12.5457C12.0824 12.8367 11.6877 13.0002 11.2761 13.0002H1.96579C1.55424 13.0002 1.15956 12.8367 0.868552 12.5457C0.577547 12.2547 0.414063 11.86 0.414062 11.4485V2.91401C0.414063 2.50247 0.577547 2.10778 0.868552 1.81678C1.15956 1.52577 1.55424 1.36229 1.96579 1.36229H2.74165V0.974357C2.74165 0.871471 2.78252 0.772799 2.85527 0.700048C2.92802 0.627297 3.02669 0.586426 3.12958 0.586426ZM1.18992 3.68987V11.4485C1.18992 11.6543 1.27167 11.8516 1.41717 11.9971C1.56267 12.1426 1.76002 12.2244 1.96579 12.2244H11.2761C11.4819 12.2244 11.6792 12.1426 11.8247 11.9971C11.9703 11.8516 12.052 11.6543 12.052 11.4485V3.68987H1.18992Z" fill="#902B29"/>
                        </svg>

                        <p>{{ $event->start_date }} — {{ $event->end_date }}</p>
                    </div>

                    <p class="font-reguler">by {{ $event->partner->partner_name }}</p>
                </div>

                <div class="p-8 mb-8 text-redb w-1/2">
                    <div class="bg-greenbg flex flex-col items-center justify-center rounded-lg p-8 mb-4">
                        <p class="font-bold text-creamhh text-lg mb-4">Gift Amount</p>

                        <form action="{{ route('donatur.donations.store') }}" method="post" id="donationForm">
                            @csrf

                            {{-- Hidden input to store the event ID --}}
                            <input type="hidden" name="event_id" value="{{ $event->id }}" required> 

                            {{-- Hidden input to store the selected donation amount --}}
                            <input type="hidden" id="donation_amount_input" name="amount" value="0" required> {{-- Default selected amount --}}

                            <div class="flex flex-col gap-4 font-bold">
                                <div class="flex flex-row gap-x-6">
                                    {{-- Buttons now update the hidden input and calculate meals --}}
                                    <button type="button" class="amount-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 w-36 text-center" data-amount="50000">50,000</button>
                                    <button type="button" class="amount-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 w-36 text-center" data-amount="100000">100,000</button>
                                </div>

                                <div class="flex flex-row gap-x-6">
                                    <button type="button" class="amount-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 w-36 text-center" data-amount="200000">200,000</button>
                                    <button type="button" class="amount-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 w-36 text-center" data-amount="250000">250,000</button>
                                </div>

                                <div class="flex flex-row gap-x-6">
                                    <button type="button" class="amount-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 w-36 text-center" data-amount="500000">500,000</button>
                                    <button type="button" class="amount-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 w-36 text-center" data-amount="1000000">1,000,000</button>
                                </div>
                            </div>

                            {{-- Custom input field for other amounts --}}
                            <div class="mt-4">
                                <label for="custom_amount" class="block text-creamcard text-sm font-bold mb-2">Or enter custom amount:</label>
                                <input type="number" id="custom_amount" min="1000" placeholder="Enter amount" 
                                    class="rounded-md bg-creamcard w-full text-black focus:outline-none focus:ring-2 focus:ring-redb placeholder:text-greyAuth placeholder:text-xs" oninput="updateSelectedAmount(this.value, null)">
                            </div>

                            <div>
                                @php
                                $target = $event->donation_target ?? 0; 
                                
                                // Sum the 'amount' from the associated 'donations' relationship
                                // Ensure 'donations' relationship is eager loaded in the controller!
                                $donationCollectedAmount = $event->donations->sum('amount') ?? 0;
                                
                                $progress = $target > 0 ? min(100, ($donationCollectedAmount / $target) * 100) : 0;
                                @endphp
                                
                                <div class="w-full bg-creamcard rounded-full h-4 overflow-hidden mt-2">
                                    @if ($donationCollectedAmount > 0)
                                    <div class="bg-redb h-4 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $progress }}%"></div>
                                    @endif
                                </div>
                                
                                <p class="text-xs font-regular text-creamcard mt-2">{{ $event->donation_count }} donation</p>
                            </div>
                            {{-- Display for estimated meals --}}
                            <div class="text-creamcard">
                                <p class="text-xs">Estimated Meals: <span id="estimated_meals">0</span></p>
                            </div>

                            {{-- Payment Method --}}
                            <div class="flex flex-row gap-4 mt-4">
                                <button type="button" class="payment-method-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 text-center" data-payment-method="BCA">
                                    <svg width="59" height="39" viewBox="0 0 79 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.0506 31.4021C13.0506 30.3658 13.0608 27.596 13.0377 27.2547C13.0579 23.1331 10.3487 20.2257 8.63712 20.4523C7.45279 20.566 6.46024 21.1002 5.9273 22.6369C5.43335 24.069 5.87496 25.974 7.51721 26.421C9.27326 26.901 10.2987 27.3004 11.0407 27.8639C11.95 28.5537 12.6923 29.8717 12.712 31.4037" fill="#0060AF"/>
                                        <path d="M13.752 37.667C10.6556 37.667 7.47347 36.8234 4.29555 35.155L4.21757 35.1126L4.18028 35.0247C2.75417 31.6948 2 28.0528 2 24.4896C2 20.9317 2.72323 17.4455 4.1504 14.1202L4.1896 14.0318L4.26907 13.9877C7.2088 12.4473 10.3713 11.667 13.6714 11.667C16.7457 11.667 20.029 12.5357 23.1647 14.1835L23.2453 14.2231L23.2823 14.3131C24.7358 17.7043 25.5022 21.3454 25.5022 24.8496C25.5022 28.3402 24.7663 31.8294 23.3111 35.2185L23.2728 35.3076L23.1918 35.3488C20.297 36.8647 17.0324 37.667 13.752 37.667ZM4.58968 34.6984C7.6769 36.3047 10.7559 37.1159 13.752 37.1159C16.9288 37.1159 20.0883 36.3478 22.9007 34.8918C24.2978 31.6077 25.006 28.2277 25.006 24.8496C25.006 21.4579 24.2668 17.9298 22.8687 14.6384C19.8255 13.056 16.6474 12.2169 13.6714 12.2169C10.4764 12.2169 7.41393 12.9665 4.56298 14.4453C3.1945 17.6684 2.49797 21.0458 2.49797 24.4896C2.49797 27.9398 3.22184 31.4694 4.58968 34.6984Z" fill="#0060AF"/>
                                        <path d="M12.3176 31.4035C12.3233 30.0752 11.6531 28.9006 10.7771 28.2694C10 27.7115 8.95681 27.3449 7.27387 26.8729C6.75365 26.7257 6.20948 26.3987 6.04102 25.9819C5.59538 26.4786 5.51443 27.5953 5.59284 28.2478C5.68396 29.003 6.48178 30.2477 7.68306 30.2964C8.41667 30.329 9.34417 30.1218 9.78896 30.0173C10.5563 29.834 11.7703 30.3656 11.9635 31.4018" fill="#0060AF"/>
                                        <path d="M13.6708 14.0283C11.634 14.0283 9.87452 15.5141 9.88088 18.0852C9.88724 20.2473 11.4591 21.4047 12.02 22.2314C12.8677 23.4772 13.3264 24.9518 13.3741 27.2081C13.4112 29.0038 13.4093 30.777 13.4176 31.4054H13.8672C13.8594 30.7479 13.839 28.8655 13.8623 27.1525C13.8928 24.8956 14.3681 23.4772 15.2162 22.2314C15.782 21.4047 17.3526 20.2473 17.356 18.0852C17.3636 15.5141 15.6052 14.0283 13.5701 14.0283" fill="#0060AF"/>
                                        <path d="M14.188 31.4021C14.188 30.3658 14.1774 27.596 14.2001 27.2547C14.1802 23.1331 16.8877 20.2257 18.6007 20.4523C19.785 20.566 20.7765 21.1002 21.311 22.6369C21.8045 24.069 21.3603 25.974 19.72 26.421C17.9631 26.901 16.939 27.3004 16.195 27.8639C15.2867 28.5537 14.5964 29.8717 14.5752 31.4037" fill="#0060AF"/>
                                        <path d="M14.9219 31.4035C14.9156 30.0752 15.5856 28.9006 16.4591 28.2694C17.2393 27.7115 18.2838 27.3449 19.9652 26.8729C20.4865 26.7257 21.03 26.3987 21.1955 25.9819C21.6433 26.4786 21.724 27.5953 21.6456 28.2478C21.5526 29.003 20.7569 30.2477 19.5577 30.2964C18.8243 30.329 17.892 30.1218 17.4491 30.0173C16.6847 29.834 15.4674 30.3656 15.2733 31.4018" fill="#0060AF"/>
                                        <path d="M15.5497 35.6922L15.2891 33.5885L15.9182 33.483C16.0714 33.4598 16.2579 33.4893 16.3325 33.5955C16.4149 33.7064 16.4401 33.798 16.456 33.9434C16.4797 34.1231 16.4327 34.331 16.2496 34.4346V34.441C16.4541 34.441 16.5776 34.6034 16.6135 34.8776C16.6188 34.9355 16.6342 35.0755 16.6188 35.1922C16.5772 35.4699 16.4274 35.5593 16.1746 35.5984L15.5497 35.6922ZM15.9547 35.3155C16.0292 35.3037 16.1049 35.2993 16.164 35.2576C16.2545 35.1922 16.2462 35.0523 16.2337 34.9484C16.2022 34.7201 16.1483 34.6334 15.9294 34.6693L15.7919 34.6927L15.879 35.3272L15.9547 35.3155ZM15.8228 34.3435C15.9061 34.3285 16.0191 34.3174 16.0661 34.23C16.0907 34.1717 16.1223 34.1252 16.1015 33.9954C16.0759 33.8414 16.0297 33.746 15.8529 33.783L15.6883 33.8123L15.7531 34.3514" fill="#0060AF"/>
                                        <path d="M18.2747 34.4262C18.2796 34.4654 18.2853 34.509 18.2874 34.5481C18.3383 34.9318 18.2747 35.2494 17.8848 35.3369C17.3084 35.4597 17.198 35.0635 17.0965 34.509L17.0425 34.209C16.963 33.6783 16.9289 33.2765 17.4909 33.1528C17.8077 33.0888 18.017 33.2282 18.1041 33.577C18.1177 33.629 18.1346 33.6806 18.141 33.7329L17.7962 33.8117C17.7564 33.6806 17.7036 33.4465 17.5485 33.4662C17.2701 33.5032 17.362 33.8864 17.3906 34.0465L17.4943 34.6224C17.5254 34.7966 17.5873 35.0748 17.8282 35.0211C18.0238 34.9778 17.9386 34.6407 17.9212 34.5027" fill="#0060AF"/>
                                        <path d="M18.8283 35.0629L18.709 32.8858L19.1722 32.7295L20.1434 34.6229L19.7787 34.7436L19.5485 34.2624L19.1436 34.397L19.1959 34.944L18.8283 35.0629ZM19.1097 34.0454L19.4023 33.9516L19.0137 33.0708" fill="#0060AF"/>
                                        <path d="M7.38726 33.417C7.53221 32.9037 7.6621 32.5258 8.21517 32.6937C8.5112 32.7851 8.69471 32.9295 8.68602 33.3099C8.68459 33.3945 8.65932 33.4808 8.64279 33.5644L8.29845 33.4592C8.34358 33.2492 8.37219 33.0825 8.13825 33.0028C7.86786 32.9208 7.80196 33.2834 7.76466 33.44L7.6246 34.0107C7.5801 34.1802 7.5267 34.4603 7.76466 34.5325C7.96131 34.5911 8.08061 34.3776 8.15181 34.0658L7.91088 33.9953L7.99416 33.665L8.56058 33.8666L8.29167 34.9666L8.03103 34.8883L8.08972 34.6558H8.0823C7.96237 34.8459 7.81594 34.8658 7.68774 34.8386C7.12132 34.6691 7.18044 34.2597 7.31564 33.7126" fill="#0060AF"/>
                                        <path d="M9.49596 34.3462L9.32538 35.2411L8.94141 35.1492L9.35059 33.0596L10.0052 33.2232C10.3883 33.3146 10.504 33.5033 10.4497 33.8917C10.4188 34.1146 10.3194 34.3548 10.0768 34.3354L10.0742 34.3317C10.2794 34.4112 10.2967 34.5256 10.2609 34.7234C10.2455 34.8076 10.1389 35.3183 10.2124 35.4008L10.2149 35.4634L9.81763 35.3488C9.8011 35.2072 9.85725 34.9527 9.8795 34.8118C9.90196 34.6871 9.93778 34.5113 9.82335 34.4452C9.73371 34.3924 9.70044 34.395 9.59916 34.3692L9.49596 34.3462ZM9.56144 34.0225L9.81996 34.0996C9.97698 34.1247 10.0643 34.0347 10.0952 33.8249C10.1232 33.6324 10.087 33.5572 9.94604 33.5199L9.66887 33.4578" fill="#0060AF"/>
                                        <path d="M11.9582 33.5264L12.3379 33.5751L12.1743 35.0441C12.0948 35.5098 11.9321 35.7135 11.4689 35.6498C10.9976 35.5839 10.8857 35.3465 10.9143 34.877L11.079 33.4092L11.4617 33.4577L11.2974 34.8927C11.2801 35.0485 11.2474 35.2794 11.4981 35.3073C11.7204 35.3261 11.7708 35.1632 11.7958 34.9606" fill="#0060AF"/>
                                        <path d="M12.7578 35.7305L12.872 33.6299L13.6016 33.6648C13.9464 33.6836 14.0367 33.9951 14.0258 34.2923C14.0159 34.473 13.9648 34.6748 13.8224 34.7843C13.7057 34.8773 13.5556 34.8994 13.4164 34.8919L13.1787 34.8773L13.1312 35.7577L12.7578 35.7305ZM13.1895 34.5569L13.3827 34.5689C13.5397 34.5752 13.6438 34.5065 13.6573 34.2515C13.665 34.0066 13.5813 33.9651 13.3778 33.9552L13.2246 33.9494" fill="#0060AF"/>
                                        <path d="M64.2134 16.0587L61.3137 21.8804C60.2193 20.8973 58.8828 20.1738 57.1776 20.1738C53.1423 20.1738 51.5032 23.501 51.5032 25.8447C51.5032 27.5844 52.5331 30.1512 56.1236 30.1512C57.6306 30.1512 59.7732 28.9915 60.3898 28.4638L57.5219 35.2179C56.1549 35.5196 55.7059 35.7066 54.5487 35.7463C48.1223 35.9584 45.5254 31.5916 45.5273 27.1294C45.5316 21.2306 50.2729 14.0568 58.1329 14.0568C58.6145 14.0568 59.2036 14.241 59.7073 14.4452L60.2163 13.7251" fill="#0060AF"/>
                                        <path d="M76.1797 13.9072L77.0008 35.0665H70.8899L70.8863 31.4376H66.7194L65.348 35.0665H58.7207L65.6493 19.957L64.087 19.9457L67.0555 13.9072H76.1797ZM70.8467 20.3803L68.4907 26.5348H70.9177" fill="#0060AF"/>
                                        <path d="M41.671 13.9077C44.6972 13.9265 46.4073 15.7435 46.4073 18.3683C46.4073 20.7879 44.6038 22.9298 42.6239 24.0374C44.6622 24.8662 44.8385 26.9007 44.8385 28.3401C44.8385 31.8176 41.6839 35.067 37.5834 35.067H28.6406L32.129 20.168L30.6961 20.1588L33.6252 13.9077C33.6252 13.9077 39.2102 13.889 41.671 13.9077ZM38.702 22.4866C39.328 22.4866 40.4333 22.3113 40.7096 20.9712C41.0124 19.5166 39.9751 19.4774 39.4776 19.4774L37.6997 19.4688L37.0797 22.4867L38.702 22.4866ZM36.1884 26.2257L35.3698 29.7031H37.4632C38.2869 29.7031 39.4094 29.251 39.6844 28.1193C39.9561 26.9844 39.1714 26.2257 38.3507 26.2257" fill="#0060AF"/>
                                    </svg>
                                </button>

                                <button type="button" class="payment-method-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 text-center" data-payment-method="Master Card">
                                    <svg width="59" height="39" viewBox="0 0 79 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M48.8311 8.22656H30.1758V41.7067H48.8311V8.22656Z" fill="#FF5F00"/>
                                        <path d="M31.3593 24.9667C31.3593 18.46 34.3797 12.249 39.4729 8.22663C30.234 0.950917 16.8496 2.54803 9.56512 11.8349C2.28066 21.0626 3.87969 34.431 13.1777 41.7067C20.936 47.7994 31.7738 47.7994 39.5321 41.7067C34.3797 37.6844 31.3593 31.4734 31.3593 24.9667Z" fill="#EB001B"/>
                                        <path d="M73.9992 24.9667C73.9992 36.738 64.4642 46.2615 52.6788 46.2615C47.8817 46.2615 43.2623 44.6644 39.5312 41.7068C48.7701 34.431 50.3691 21.0626 43.0846 11.7758C42.0186 10.4744 40.8342 9.23222 39.5312 8.22663C48.7701 0.950917 62.2138 2.54803 69.439 11.8349C72.4002 15.5615 73.9992 20.1754 73.9992 24.9667Z" fill="#F79E1B"/>
                                        <path d="M71.9868 38.1577V37.4479H72.2829V37.3296H71.5723V37.4479H71.8684V38.1577H71.9868ZM73.349 38.1577V37.3296H73.1121L72.8752 37.9211L72.6383 37.3296H72.4014V38.1577H72.5791V37.507L72.816 38.0394H72.9936L73.2305 37.507V38.1577H73.349Z" fill="#F79E1B"/>
                                    </svg>
                                </button>

                                <button type="button" class="payment-method-button rounded-md [box-shadow:4px_5px_0px_rgb(144,43,41,1)] bg-creamcard px-4 py-2 text-center" data-payment-method="Link Aja">
                                    <svg width="59" height="39" viewBox="0 0 49 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_1206_8318" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="49" height="49">
                                        <path d="M0 0.666992H48.1661V48.667H0V0.666992Z" fill="white"/>
                                        </mask>
                                        <g mask="url(#mask0_1206_8318)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M43.6437 48.667H4.52235C2.03515 48.667 0 46.639 0 44.1602V5.17375C0 2.69512 2.03515 0.666992 4.52235 0.666992H43.6437C46.1311 0.666992 48.1661 2.69512 48.1661 5.17375V44.1602C48.1661 46.639 46.1311 48.667 43.6437 48.667Z" fill="#E82529"/>
                                        </g>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3914 9.70557H12.6734C12.8472 9.70557 12.9806 9.85906 12.9559 10.0304L11.8961 17.3569C11.8553 17.6389 12.0748 17.8914 12.3607 17.8914H16.3639C16.4776 17.8914 16.5648 17.9921 16.5482 18.1041L16.2376 20.2084C16.2216 20.3177 16.1274 20.3989 16.0164 20.3989H11.4898C10.1434 20.3989 8.85212 19.2984 9.04211 17.9699L10.1086 9.95256C10.1273 9.81123 10.2482 9.70557 10.3914 9.70557Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.0016 12.6288L16.957 20.1006C16.9404 20.2191 17.0328 20.325 17.1528 20.325H19.3611C19.5181 20.325 19.6512 20.2096 19.673 20.0546L20.7074 12.7043C20.7294 12.5349 20.5972 12.3848 20.4257 12.3848H18.2829C18.1411 12.3848 18.0212 12.4889 18.0016 12.6288Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5564 19.7523C21.8751 19.7278 21.5563 19.9406 21.1543 20.1796C21.2513 19.506 22.0121 14.2562 22.0815 13.9337C22.1549 13.5899 22.2216 13.0163 22.525 12.7269C22.8806 12.3873 23.4309 12.1929 26.1693 12.1841C28.9646 12.1751 29.5061 14.1799 29.3578 15.4826C29.2313 16.5975 28.8154 19.3523 28.698 20.122C28.6801 20.239 28.5798 20.3251 28.4615 20.3251H26.3023C26.1441 20.3251 26.0225 20.1861 26.0446 20.0301C26.1538 19.2605 26.4466 17.2087 26.546 16.6129C26.6692 15.8759 26.7679 15.0649 26.5705 14.7447C26.3732 14.4252 25.7812 14.1799 24.6468 14.3766L23.8077 20.2886C23.8077 20.2886 23.2679 19.778 22.5564 19.7523Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M31.6995 9.28125H34.0947C34.1839 9.28125 34.2524 9.35975 34.2402 9.44775L32.7498 20.2076C32.7388 20.2874 32.6702 20.3469 32.5892 20.3469H30.2245C30.1261 20.3469 30.0505 20.2604 30.0641 20.1634L31.554 9.40775C31.5641 9.33525 31.6261 9.28125 31.6995 9.28125Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M33.5527 15.7642L36.2597 12.6051C36.345 12.5056 36.4697 12.4482 36.6012 12.4482H38.9775C39.1491 12.4482 39.2394 12.6507 39.1247 12.7776L36.3569 15.8387L38.887 21.2616C38.9799 21.4606 38.834 21.6882 38.6139 21.6882H36.4661C36.3538 21.6882 36.252 21.6231 36.2052 21.5216L33.5527 15.7642Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1694 10.3616C20.9758 11.1758 20.2401 11.7816 19.4698 11.7816C18.6996 11.7816 18.1089 11.1216 18.3028 10.3076C18.4964 9.49349 19.1341 8.8335 20.0481 8.8335C20.8182 8.8335 21.3631 9.54748 21.1694 10.3616Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23.605 22.2298C23.4113 23.044 22.6756 23.6498 21.9053 23.6498C21.1352 23.6498 20.5445 22.9898 20.7383 22.1758C20.932 21.3616 21.5697 20.7017 22.4836 20.7017C23.2538 20.7017 23.7987 21.4156 23.605 22.2298Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M35.1904 31.959C35.0272 32.7635 34.2838 33.362 33.4741 33.3615C32.6641 33.3612 32.0104 32.7085 32.1736 31.9042C32.3368 31.0997 32.9745 30.4477 33.9355 30.4482C34.7453 30.4487 35.3537 31.1546 35.1904 31.959Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.803 27.952H13.3529C13.299 27.952 13.2621 27.898 13.2818 27.848L14.5438 24.6558C14.5679 24.5949 14.6578 24.6079 14.6637 24.6729L14.9473 27.7945C14.955 27.879 14.8883 27.952 14.803 27.952ZM18.3161 31.9608L16.6978 22.3083C16.6271 21.8863 16.2605 21.5771 15.8312 21.5771H14.2075C13.7123 21.5771 13.2627 21.8653 13.0577 22.3145L8.69856 31.9728C8.63535 32.113 8.7387 32.2711 8.89273 32.2703L11.1577 32.2571C11.3127 32.2563 11.4522 32.1636 11.5127 32.0216L12.2656 30.2565C12.286 30.2083 12.3334 30.1772 12.3859 30.1772H15.127C15.1942 30.1772 15.2505 30.228 15.2571 30.2947L15.4206 31.965C15.4395 32.1593 15.6036 32.3076 15.7996 32.3076H18.0212C18.206 32.3076 18.3465 32.1423 18.3161 31.9608Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2347 33.7091L17.7578 35.3196C17.8518 35.5846 17.9227 35.6434 18.1065 35.6047C18.7673 35.4659 20.3639 34.9957 21.1451 33.9426C22.1634 32.5696 22.3031 30.1423 22.4829 28.9087C22.6309 27.8925 22.955 25.3912 23.0647 24.5411C23.0844 24.3881 22.9648 24.2529 22.81 24.2529H20.7795C20.6001 24.2529 20.4484 24.3849 20.4243 24.5621C20.2606 25.7629 19.6709 30.081 19.5679 30.6795C19.4481 31.376 19.4242 32.3791 18.3903 32.9779C17.8744 33.2766 17.6098 33.3336 17.4056 33.4286C17.3018 33.4769 17.1843 33.5288 17.2347 33.7091Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M28.4088 29.9909C28.4088 29.9909 27.35 30.3497 26.8417 29.9697C26.3333 29.5899 26.291 28.8091 26.5875 27.6906C26.8841 26.572 27.6253 26.3821 27.9429 26.361C28.2606 26.3398 28.8578 26.4896 28.8578 26.4896L28.4088 29.9909ZM31.3407 24.5418C30.656 24.3712 29.5049 23.9962 27.6544 24.1313C25.947 24.256 24.0191 25.043 23.658 28.4018C23.2969 31.7605 24.8377 32.4084 27.0525 32.5044C28.6755 32.5747 29.9494 32.1297 30.5143 31.8869C30.711 31.8024 30.848 31.6212 30.8767 31.4097L31.6951 24.943C31.7272 24.6863 31.5984 24.606 31.3407 24.5418Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32.9211 29.3773L33.517 23.1849C33.5384 22.9631 33.7252 22.8726 33.9488 22.8726H36.0044C36.1959 22.8726 36.277 23.0174 36.2241 23.2546L34.9695 29.4553C34.9441 29.5753 34.8381 29.6611 34.715 29.6611H33.1799C33.0265 29.6611 32.9064 29.5294 32.9211 29.3773Z" fill="#FEFEFE"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.86566 40.7958C9.27272 41.02 9.74819 41.0852 10.2007 40.9783C12.0034 40.5527 15.9928 39.4069 24.4316 38.1912C35.0336 36.6639 42.8615 36.6702 42.8615 36.6702L42.882 36.6577C42.882 36.6577 35.9439 35.7078 24.557 36.8161C13.1699 37.9244 6.81445 39.6662 6.81445 39.6662L8.86566 40.7958Z" fill="#FEFEFE"/>
                                    </svg>
                                </button>
                            </div>
                            <input type="hidden" id="payment_method_input" name="payment_method" value="" required>
                            
                            <button type="submit" id="donateButton"
                            class="rounded-md px-4 py-2 mt-4 w-full text-center font-bold
                                {{ $canDonate ? 'bg-creamcard text-redb [box-shadow:4px_5px_0px_rgb(144,43,41,1)] hover:shadow-none hover:translate-y-px hover:translate-x-px' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                            {{ $canDonate ? '' : 'disabled' }}>
                                {{ $canDonate ? 'Donate Now' : 'Donation Closed' }}
                            </button>

                            {{-- Pesan opsional jika donasi ditutup --}}
                            @unless($canDonate)
                                <p class="text-red-500 text-sm mt-2 text-center">This donation period has ended.</p>
                            @endunless
                                
                            {{-- Terms And Conditions --}}
                            <div class="mt-4">
                                <input type="checkbox" name="agree" id="agree" class="peer rounded bg-transparent shadow-sm focus:ring-redb border border-creamcard rounded-sm mr-2" required>
                                <label for="agree" class="text-sm text-creamcard text-xs text-creamhh peer-checked:text-redb">I Agree with the Terms and Conditions</label>
                            </div>
                            
                            
                        </form>
                        <div class="flex items-center justify-center w-3/4 px-4 font-regular text-xs text-creamcard mt-2 text-justify">
                            <p >By providing my mobile phone number, I agree that HelpHunger and its affiliates may contact me via phone call or text message. Message and data rates may apply. Text STOP to 88888 to stop receiving messages, and HELP to 88888 for more information. Terms and Conditions apply.
                            <br><br>
                            Donations made through this page support the entire mission of HelpHunger and are not designated to a specific program or location.
                            <br><br>
                            HelpHunger respects your privacy. Please review our privacy policy and contact us if you have any questions.</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    @endif

    <script>
        const COST_PER_MEAL = 15000; // Example: IDR 15,000 per meal

        // Function to update the hidden donation amount and calculate meals
        function updateSelectedAmount(amount, clickedButton = null) {
            const donationAmountInput = document.getElementById('donation_amount_input');
            const estimatedMealsSpan = document.getElementById('estimated_meals');
            const amountButtons = document.querySelectorAll('.amount-button');
            const customAmountInput = document.getElementById('custom_amount');

            let numericAmount = parseFloat(amount);

            if (isNaN(numericAmount) || numericAmount < 1000) {
                numericAmount = 0;
            }

            donationAmountInput.value = numericAmount > 0 ? numericAmount : '';
            const estimatedMeals = Math.floor(numericAmount / COST_PER_MEAL);
            estimatedMealsSpan.textContent = estimatedMeals;

            // --- Handle Button Styles ---
            amountButtons.forEach(btn => btn.classList.remove('selected'));

            if (clickedButton) {
                clickedButton.classList.add('selected');
                customAmountInput.value = '';

                // --- Efek animasi klik: Tambahkan kelas animasi sementara ---
                // Misalnya: scale down sedikit saat aktif, lalu kembali normal
                clickedButton.classList.add('scale-95', 'duration-100'); // Skala 95% dan durasi 100ms
                setTimeout(() => {
                    clickedButton.classList.remove('scale-95', 'duration-100');
                }, 150); // Hapus setelah sedikit waktu agar terlihat transisi
                // Anda juga bisa menambahkan 'active:scale-95' langsung di HTML jika ingin CSS saja
            } else {
                if (numericAmount > 0) {
                    customAmountInput.value = numericAmount;
                }
            }

            checkFormValidity();
        }

        // New function to handle payment method selection
        function updatePaymentMethod(method, clickedButton) {
            const paymentMethodInput = document.getElementById('payment_method_input');
            const paymentMethodButtons = document.querySelectorAll('.payment-method-button');

            paymentMethodButtons.forEach(btn => btn.classList.remove('selected'));
            clickedButton.classList.add('selected');
            paymentMethodInput.value = method;

            // --- Efek animasi klik: Tambahkan kelas animasi sementara ---
            clickedButton.classList.add('scale-95', 'duration-100');
            setTimeout(() => {
                clickedButton.classList.remove('scale-95', 'duration-100');
            }, 150);

            checkFormValidity();
        }

        // Function to check all form validity and enable/disable the submit button
        function checkFormValidity() {
            const donationAmountInput = document.getElementById('donation_amount_input');
            const paymentMethodInput = document.getElementById('payment_method_input');
            const agreeCheckbox = document.getElementById('agree');
            const donateButton = document.getElementById('donateButton');
            const customAmountInput = document.getElementById('custom_amount');

            const isAmountSelected = donationAmountInput.value !== '' && parseFloat(donationAmountInput.value) >= 1000;
            const isPaymentMethodSelected = paymentMethodInput.value !== '';
            const isAgreed = agreeCheckbox.checked;

            if (isAmountSelected && isPaymentMethodSelected && isAgreed) {
                donateButton.removeAttribute('disabled');
            } else {
                donateButton.setAttribute('disabled', 'disabled');
            }
        }

        // Add event listeners when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            const amountButtons = document.querySelectorAll('.amount-button');
            amountButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const amount = event.currentTarget.dataset.amount;
                    updateSelectedAmount(amount, event.currentTarget);
                });
            });

            const paymentMethodButtons = document.querySelectorAll('.payment-method-button');
            paymentMethodButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const method = event.currentTarget.dataset.paymentMethod;
                    updatePaymentMethod(method, event.currentTarget);
                });
            });

            document.getElementById('agree').addEventListener('change', checkFormValidity);

            const defaultSelectedAmountButton = document.querySelector('.amount-button.selected');
            const initialCustomAmount = document.getElementById('custom_amount').value;

            if (defaultSelectedAmountButton) {
                updateSelectedAmount(defaultSelectedAmountButton.dataset.amount, defaultSelectedAmountButton);
            } else if (initialCustomAmount) {
                updateSelectedAmount(initialCustomAmount, null);
            } else {
                checkFormValidity();
            }

            const defaultSelectedPaymentMethodButton = document.querySelector('.payment-method-button.selected');
            if (defaultSelectedPaymentMethodButton) {
                updatePaymentMethod(defaultSelectedPaymentMethodButton.dataset.paymentMethod, defaultSelectedPaymentMethodButton);
            } else {
                checkFormValidity();
            }
        });

    </script>

</x-app-layout>