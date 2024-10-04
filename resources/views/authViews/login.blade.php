@extends('layout')
@section('title', 'Login')
@section('content')
    <div class="auth-form-reg">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <label>Email: </label>
            <input type="email" name="email" autocomplete="off" value="{{ old('email') }}">
            <div class="errors">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
            <label>Password: </label>
            <input type="password" name="password" autocomplete="off" value="{{ old('password') }}">
            <div class="errors">
                @error('password')
                    {{ $message }}
                @enderror
            </div>
            <p>Don't have an account?
                <a class="to-register" href="{{ route('registerForm') }}">Register</a>
            </p>
            <button>Login</button>
        </form>
    </div>
@endsection
