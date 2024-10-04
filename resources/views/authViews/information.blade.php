@extends('layout')
@section('title', 'Information')
@section('content')
    <div class="auth-form-reg">
        <form action="{{ route('updateInformation') }}" method="POST">
            @csrf
            <label>Your username:</label>
            <input type="text" name="name" autocomplete="off" value="{{ $user->name }}" disabled>
            @error('name')
                {{ $message }}
            @enderror
            <label>Your email:</label>
            <input type="text" name="email" autocomplete="off" value="{{ $user->email }}" readonly>
            <span class="warning">You can't change your email.</span>
            <label>Current password:</label>
            <input type="text" name="currentPassword" autocomplete="off">
            @error('currentPassword')
                {{ $message }}
            @enderror
            <label>
                New password:
                <span>
                    must contain a single digit from 1 to 9, and one lowercase letter, and one uppercase letter,
                    and one special character. must be 8-16 characters long.
                </span>
            </label>
            <input type="text" name="newPassword" autocomplete="off">
            @error('newPassword')
                {{ $message }}
            @enderror
            <button>Update</button>
        </form>
    </div>
@endsection
