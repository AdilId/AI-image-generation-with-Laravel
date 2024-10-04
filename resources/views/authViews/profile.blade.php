@extends('layout')
@section('title', 'Profile')
@section('content')
    <div class="auth-form-reg">
        <form action="{{ route('changeInformation') }}">
            <div class="name">
                Your username: {{ $user->name }}
            </div>
            <div class="email">
                Your email: {{ $user->email }}
            </div>
            <div class="password">
                Your password: **************
                <button>Update</button>
            </div>
        </form>
    </div>
@endsection
