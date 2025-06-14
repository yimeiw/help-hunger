<x-auth-layout>
    @section('title', 'Add New Volunteer Event')

    <div class="flex justify-between items-center">
        <a href="{{ route('admin.manage-event') }}" onclick="resetFormsAndNavigate(event);" class="flex justify-end m-6">
            <img src="{{ asset('/assets/close-button.svg') }}" 
                 onmouseover="this.src='/assets/close-hover.svg'" 
                 onmouseout="this.src='/assets/close-button.svg'" 
                 alt="Close" class="w-8 h-8">
        </a>
    </div>

    <x-authentication-card>
        <x-slot name="logo">
            <h2 class="text-xl font-bold text-creamcard">Add New Volunteer Event</h2>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form action="{{ route('admin.manage.event.volunteer.add') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <x-label for="event_name" value="Event Name" />
                <x-input id="event_name" type="text" name="event_name" class="block w-full mt-1" :value="old('event_name')" required autofocus />
            </div>

            <div class="mb-4">
                <x-label for="description" value="Description" class="mb-1" />
                <textarea id="description" name="description" rows="4" class="w-full text-xs [box-shadow:4px_5px_0px_rgb(144,43,41,1)] focus:outline-none focus:ring-2 focus:ring-redb textarea:text-greyAuth textarea:text-xs bg-creamcard rounded-lg">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-row gap-4">
                <div class="mb-4 w-1/2">
                    <x-label for="start_date" value="Start Date" />
                    <x-input id="start_date" type="date" name="start_date" class="block w-full mt-1" :value="old('start_date')" required />
                </div>

                <div class="mb-4 w-1/2">
                    <x-label for="end_date" value="End Date" />
                    <x-input id="end_date" type="date" name="end_date" class="block w-full mt-1" :value="old('end_date')" required />
                </div>
            </div>

            <div class="mb-4">
                <x-label for="current_needs" value="Current Needs" />
                <x-input id="current_needs" type="text" name="current_needs" class="block w-full mt-1" :value="old('current_needs')" required />
            </div>

            <div class="mb-4">
                <x-label for="max_volunteers" value="Max Volunteers" />
                <x-input id="max_volunteers" type="number" name="max_volunteers" class="block w-full mt-1" :value="old('max_volunteers')" required min="1" />
            </div>

            <div class="mb-4">
                <x-label for="partner_id" value="Partner" class="mb-1" />
                <x-dropdown-register align="left">
                    <x-slot name="trigger">
                        <div class="relative">
                            <button id="partner-trigger" type="button"
                                class="relative w-full inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb leading-5 pr-10">
                                <span id="partner-text">
                                    {{ old('partner_name') ?? 'Select a partner' }}
                                </span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <input type="hidden" name="partner_id" id="partner_id" value="{{ old('partner_id') }}" class="mb-1">
                        <div class="w-full max-h-48 overflow-y-auto flex flex-col space-y-1 text-base text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg"
                            id="partner-list">
                            @foreach($partners as $partner)
                                <button type="button" class="px-4 py-2 text-left partner-option" data-id="{{ $partner->id }}" data-name="{{ $partner->partner_name }}">
                                    {{ $partner->partner_name }}
                                </button>
                            @endforeach
                        </div>
                    </x-slot>
                </x-dropdown-register>
            </div>

            <div class="mb-4">
                <x-label for="location_id" value="Location" class="mb-1" />
                <x-dropdown-register align="left">
                    <x-slot name="trigger">
                        <div class="relative">
                            <button id="location-trigger" type="button"
                                class="relative w-full inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb leading-5 pr-10">
                                <span id="location-text">
                                    {{ old('location_name') ?? 'Select a location' }}
                                </span>
                                <img src="{{ asset('/assets/arrow-down.svg') }}"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                            </button>
                        </div>
                    </x-slot>
                    <x-slot name="content">
                        <input type="hidden" name="location_id" id="location_id" value="{{ old('location_id') }}">
                        <div class="w-full max-h-48 overflow-y-auto flex flex-col space-y-1 text-base text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg"
                            id="location-list">
                            @foreach($locations as $location)
                                <button type="button" class="px-4 py-2 text-left location-option" data-id="{{ $location->id }}" data-name="{{ $location->name }}">
                                    {{ $location->name }}
                                </button>
                            @endforeach
                        </div>
                    </x-slot>
                </x-dropdown-register>
            </div>

            <div class="mb-4">
                <x-label for="image" value="Event Image"/>

                <div class="flex items-center mt-1">
                    <label for="image" class="cursor-pointer">
                        <button type="button" class="flex items-start bg-creamcard shadow-quadrupleNonHover px-6 py-2 text-redb font-semibold text-sm rounded-3xl">
                            Upload Photo
                        </button>
                    </label>
                    <span id="file-chosen" class="text-sm text-creamdb px-4">No file chosen</span>
                </div>

                <input 
                    id="image" 
                    type="file" 
                    name="image" 
                    accept=".jpg, .jpeg, .png" 
                    class="hidden" 
                    onchange="updateFileName(this)" 
                    required
                />

                <x-input-error for="image" class="mt-2" />
            </div>

            <div class="flex flex-col items-center justify-end mt-4">
                <x-button class="w-full">
                    {{ __('Add Event') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        function resetFormsAndNavigate(event) {
            event.preventDefault();
            document.querySelectorAll('form').forEach(form => form.reset());
            window.location.href = "{{ route('admin.manage-event') }}";
        }

        function updateFileName(input) {
            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/png'];

            if (file && allowedTypes.includes(file.type)) {
                document.getElementById('file-chosen').textContent = file.name;
            } else {
                input.value = '';
                document.getElementById('file-chosen').textContent = 'Invalid file type. Only JPG/PNG allowed.';
            }
        }
    </script>
</x-auth-layout>
