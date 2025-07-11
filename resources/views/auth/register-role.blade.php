<x-auth-layout>
    @section('title', 'Register Account')
    <div class="flex flex-row justify-between items-center">
        <a href="#" onclick="history.back(); return false;" class="flex justify-end m-6">
                <img src="{{ asset('/assets/back-button.svg') }}" onmouseover="this.src='/assets/back-hover.svg'" 
                        onmouseout="this.src='/assets/back-button.svg'" alt="" class="w-10 h-10">
            </a>
    
        <a href="{{ route('guest.welcome') }}" onclick="resetFormsAndNavigate(event);" class="flex justify-end m-6">
            <img src="{{ asset('/assets/close-button.svg') }}" onmouseover="this.src='/assets/close-hover.svg'" 
                        onmouseout="this.src='/assets/close-button.svg'" alt="" class="w-8 h-8">
        </a>
    </div>

    <x-authentication-card>
        
        <form method="POST" action="{{ route('register.role') }}">
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>
    
            <x-validation-errors class="mb-4" />
            @csrf

            <div class="flex flex-row justify-center gap-4">

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="volunteer" class="hidden peer" required>         
                    <div class="peer-checked:shadow-quadrupleHover peer-checked:text-greenpastel border p-4 rounded-lg bg-creamcard shadow-quadrupleNonHover transition duration-300 ease-in-out text-redb font-bold text-center">
                        Volunteer
                        <img src="{{ asset('/assets/volunteer-mahjong.svg') }}" alt="Volunteer" class="mt-2 h-40" />
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="role" value="donatur" class="hidden peer" required>
                    <div class="peer-checked:shadow-quadrupleHover peer-checked:text-greenpastel border p-4 rounded-lg bg-creamcard shadow-quadrupleNonHover transition duration-300 ease-in-out text-redb font-bold text-center">
                        Donatur
                        <img src="{{ asset('/assets/donatur-mahjong.svg') }}" alt="Donatur" class="mt-2 h-40" />
                    </div>
                </label>

            </div>


            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex flex-col items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Continue') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        function resetFormsAndNavigate(event) {
            // Mencegah navigasi default terlebih dahulu
            event.preventDefault(); 
        
            // Temukan semua form di halaman dan reset
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.reset(); // Mereset semua input di dalam form
            });
        
            // Setelah mereset form, arahkan ke halaman guest.welcome
            window.location.href = "{{ route('guest.welcome') }}";
        }
    </script>
</x-auth-layout>
