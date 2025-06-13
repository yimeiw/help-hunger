<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }} - Peran: {{ ucfirst($role ?? 'Semua') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-greenbg overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Notifikasi Sukses/Error --}}
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

                {{-- Filter Berdasarkan Peran --}}
                <div class="mb-4">
                    <form method="GET" action="{{ route('admin.manage-user') }}">
                        <div class="flex justify-between items-center mb-4">
                            <label class="flex items-center block text-[24px] font-bold text-creamcard">List Of User</label>
                            <x-dropdown-register align="left">
                                <x-slot name="trigger">
                                    <div class="relative">
                                        <button id="role-trigger" type="button"
                                                class="relative w-48 inline-flex items-center px-4 py-2 bg-creamcard shadow-quadrupleNonHover rounded-md text-base font-bold text-redb leading-5 text-blackAuth pr-10">
                                            <span id="role-text">{{ ucfirst(old('role', $role ?? 'Select Role')) }}</span>
                                            <img src="{{ asset('/assets/arrow-down.svg') }}" alt=""
                                                class="absolute right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 pointer-events-none">
                                        </button>
                                    </div>
                                </x-slot>
    
                                <x-slot name="content">
                                    <input type="hidden" name="role" id="role-input">
                                    <div class="w-48 max-h-48 overflow-y-auto flex flex-col space-y-1 text-xs text-redb font-bold bg-creamcard shadow-quadrupleNonHover rounded-lg" id="role-list">
                                        <button type="button" class="px-4 py-2 text-left role-btn" data-role="">All User</button>
                                        <button type="button" class="px-4 py-2 text-left role-btn" data-role="volunteer">Volunteer</button>
                                        <button type="button" class="px-4 py-2 text-left role-btn" data-role="donatur">Donatur</button>
                                        <button type="button" class="px-4 py-2 text-left role-btn" data-role="partner">Partner</button>
                                        <button type="button" class="px-4 py-2 text-left role-btn" data-role="admin">Admin</button>
                                    </div>
                                </x-slot>
                            </x-dropdown-register>
                        </div>
                    </form>
                </div>


                {{-- Tabel Pengguna --}}
                <div class="overflow-x-auto bg-creadmcard rounded-lg shadow-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-creamhh">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-bold text-redb uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-redb uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-redb uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-redb uppercase tracking-wider">Registration Date</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-redb uppercase tracking-wider">Total Activity</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-redb uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-creamcard divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blackAuth">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-blackAuth">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-blackAuth">{{ ucfirst($user->role) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-blackAuth">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-blackAuth">
                                        @if($user->isVolunteer())
                                            {{ $user->total_volunteered_activities }} (Event)
                                        @elseif($user->isDonatur())
                                            {{ $user->total_donated_activities }} (Donation)
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @php
                                            $deleteRoute = match($user->role) {
                                                'volunteer' => route('admin.manage.user.volunteer.delete', $user->id),
                                                'donatur' => route('admin.manage.user.donatur.delete', $user->id),
                                                'partner' => route('admin.manage.user.partner.delete', $user->id),
                                                default => null
                                            };
                                        @endphp

                                        @if ($deleteRoute)
                                            <form method="POST" action="{{ $deleteRoute }}" class="inline-block" onsubmit="return confirm('Are you sure to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">Can't Delete</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No users found for this role.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleButtons = document.querySelectorAll('.role-btn');
        const roleText = document.getElementById('role-text');
        const roleInput = document.getElementById('role-input');
        const form = roleInput.closest('form');

        roleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedRole = button.getAttribute('data-role');
                roleText.textContent = selectedRole ? selectedRole.charAt(0).toUpperCase() + selectedRole.slice(1) : 'All User';
                roleInput.value = selectedRole;
                form.submit();
            });
        });
    });
</script>

</x-app-layout>