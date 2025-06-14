<x-app-layout>
    @section('title', 'Notification Page')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Notifications') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-greenbg shadow-xl sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Notifications</h3>

                @if($notifications->isEmpty())
                    <p class="text-gray-500">No new notifications.</p>
                @else
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="p-4 rounded-lg shadow-sm {{ $notification->is_read ? 'bg-gray-100 text-gray-600' : 'bg-white text-gray-800 border border-redb' }}">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                            ({{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }})
                                        </p>
                                    </div>
                                    @unless($notification->is_read)
                                        <form action="{{ route('admin.notification.mark-read', $notification->id) }}" method="POST">
                                            @csrf
                                            <x-secondary-button type="submit" class="text-xs py-1 px-2">
                                                Mark as Read
                                            </x-secondary-button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">Read</span>
                                    @endunless
                                </div>
                                @if($notification->type == 'event_submission_volunteer' || $notification->type == 'event_submission_donation')
                                    <div class="mt-2 text-sm">
                                        <a href="{{ route('admin.dashboard') }}" class="text-redb hover:underline font-medium">
                                            View Pending Events
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $notifications->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>