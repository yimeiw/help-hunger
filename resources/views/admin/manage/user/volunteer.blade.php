@extends('layouts.app')

@section('content')
    <h2>Manage Volunteer</h2>

    @if(session('success'))
        <p class="text-green-500">{{ session('success') }}</p>
    @endif

    <table class="table-auto w-full border mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($volunteers as $v)
                <tr>
                    <td>{{ $v->name }}</td>
                    <td>{{ $v->email }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.manage.user.volunteer.delete', $v->id) }}">
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
