<div class="min-h-screen flex flex-col items-center">
    
    <div class="w-full sm:max-w-lg m-8 shadow-md overflow-hidden sm:rounded-xl border border-2 border-blackAuth">
        <div class="border border-2 border-redb rounded-lg p-0">
            <div class="border border-2 px-11 py-10 border-creamhh bg-greenAuth rounded-lg">
                <div class="w-full flex justify-center items-center mb-4">
                    {{ $logo }}
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
