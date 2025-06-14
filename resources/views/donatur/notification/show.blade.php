<x-app-layout>
    @section('title', 'Notifications')

    @if($notifications->isEmpty())
            <div class="flex justify-center items-center text-center m-12 mb-52">
                <p class="text-redb font-bold text-lg">There is no notifcation for you.</p>
            </div>

        @else
            @foreach($notifications as $notification)
                <div class="text-redb m-24">
                    <p class="font-bold text-lg mb-2">{{ $notification->title }}</p>
                    <p class="font-reguler text-sm mb-2">{{ $notification->message }}</p>
                    <p class="font-reguler text-xs text-blackAuth mb-2">{{ $notification->created_at->diffForHumans()  }}</p>
                    <hr class="border-t-2 border-redb w-full">
                </div>
            @endforeach
    @endif
</x-app-layout>