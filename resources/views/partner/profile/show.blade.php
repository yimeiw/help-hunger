<x-app-layout>

    <div class="p-12 m-6">
        <form method="POST" action="#" class="md:grid md:grid-cols-3 md:gap-8">
         @csrf
            <!-- Left Column: Profile Information Text -->
            <div class="md:col-span-1 mb-6 md:mb-0">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Profile Information</h2>
                <p class="text-gray-600">Update your account's profile information and email address.</p>
            </div>

            <!-- Right Column: Form Fields and Actions -->
            <div class="md:col-span-2 space-y-6 bg-greenbg p-6 rounded-lg shadow-md">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-bold text-creamcard">Name</label>
                    <input id="name" type="text" class="mt-1 block w-full bg-creamcard text-blackAuth border-none rounded-md shadow-sm focus:border-indigo-500 focus:ring-redb sm:text-sm p-2" placeholder="Enter you new name" required autocomplete="name">
                    <!-- Error message placeholder -->
                    <!-- <p class="mt-2 text-sm text-red-600">Error message for name</p> -->
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-bold text-creamcard">Email</label>
                    <input id="email" type="email" class="mt-1 block w-full bg-creamcard text-blackAuth border-none rounded-md shadow-sm focus:border-indigo-500 focus:ring-redb sm:text-sm p-2" placeholder="Enter your email" required autocomplete="username">
                    <!-- Error message placeholder -->
                    <!-- <p class="mt-2 text-sm text-red-600">Error message for email</p> -->
                </div>

                <!-- Action Buttons & Status -->
                <div class="flex justify-end mt-6">
                    <!-- Save Button -->
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-md text-redb bg-creamcard shadow-quadrupleNonHover hover:shadow-quadrupleHover focus:outline-none transition ease-in-out duration-300">
                        Save
                    </button>
                </div>
            </div>
        </form>

        <hr class="my-8 border-t border-redb">

        <!-- Logout Section -->
        <div class="flex justify-end">
            <button class="inline-flex items-center px-6 py-3 border border-transparent text-xl font-bold rounded-md text-redb bg-creamcard shadow-quadrupleNonHover hover:shadow-quadrupleHover focus:outline-none transition ease-in-out duration-300">
                Logout
            </button>
        </div>
    </div>

</x-app-layout>