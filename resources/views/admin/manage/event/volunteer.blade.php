@extends('layouts.app')

@section('content')
    <h2>Manage Volunteer Event</h2>

    @if(session('success'))
        <p class="text-green-500">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.manage.event.volunteer.store') }}" class="mb-4">
        @csrf
        <input type="text" name="name" placeholder="Event Name" required class="border p-2">
        <input type="text" name="location" placeholder="Location" required class="border p-2">
        <button type="submit" class="bg-green-500 text-white px-4 py-2">Add Event</button>
    </form>

    <table class="table-auto w-full border mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $e)
                <tr>
                    <td>{{ $e->name }}</td>
                    <td>{{ $e->location }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.manage.event.volunteer.delete', $e->id) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
