@extends('layout')
@section('title', 'Register')
@section('content')
    <div class="auth-form-reg">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <label>Name: </label>
            <input type="text" name="name" autocomplete="off" value="{{ old('name') }}">
            <div class="errors">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
            <label>Email: </label>
            <input type="email" name="email" autocomplete="off" value="{{ old('email') }}">
            <div class="errors">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
            <label>
                Password:
                <span>
                    must contain a single digit from 1 to 9, and one lowercase letter, and one uppercase letter,
                    and one special character. must be 8-16 characters long.
                </span>
            </label>
            <input type="password" name="password" autocomplete="off">
            <div class="errors">
                @error('password')
                    {{ $message }}
                @enderror
            </div>
            <label>Password Confirm: </label>
            <input type="password" name="password_confirmation" autocomplete="off">
            <div class="errors">
                @error('password_confirmation')
                    {{ $message }}
                @enderror
            </div>
            <button>Register</button>
        </form>
    </div>
@endsection
