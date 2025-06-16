<x-app-layout>
    @section('title', 'Notification Page')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Notifications') }}
        </h2>
    </x-slot>
<!-- 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-greenbg shadow-xl sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="bg-greenbg border border-redb text-creamcard px-4 py-3 rounded-lg relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-redb border border-creamcard text-creamcard px-4 py-3 rounded-lg relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <h3 class="text-lg font-semibold text-creamcard mb-4 px-4 py-2">Your Notifications</h3>

            </div>
        </div>
    </div> -->
    @if($notifications->isEmpty())
           <div class="flex justify-center items-center text-center m-12 mb-52">
               <p class="text-redb font-bold text-lg">There is no notifcation for you.</p>
           </div>

       @else
           @foreach($notifications as $notification)
               <div class="text-redb mx-24 my-12">
                   <p class="font-bold text-lg mb-2">{{ $notification->title }}</p>
                   <p class="font-reguler text-sm mb-2">{{ $notification->message }}</p>
                   <p class="font-reguler text-xs text-blackAuth mb-2">{{ $notification->created_at->diffForHumans()  }}</p>
                   <hr class="border-t-2 border-redb w-full">
               </div>
           @endforeach
   @endif
</x-app-layout>