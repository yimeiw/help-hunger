<x-app-layout>

    <form method="POST" action="{{ route('partner.logout') }}">
        @csrf
        <button type="submit" class="">
            Logout
        </button>
    </form>
    
</x-app-layout>