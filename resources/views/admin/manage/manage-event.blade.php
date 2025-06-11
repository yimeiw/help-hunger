@extends('layouts.app')

@section('content')
    <h2>Manage Event</h2>
    <ul>
        <li><a href="{{ route('admin.manage.manage-event.volunteer') }}">Volunteer Event</a></li>
        <li><a href="{{ route('admin.manage.manage-event.donation') }}">Donation Event</a></li>
    </ul>
@endsection
