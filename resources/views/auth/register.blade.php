@extends('layouts.guest')

@section('title', 'Login')
@section('content')
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('register') }}" method="POST" class="mt-52 border-2  border-black">
        @csrf
        <div class="m-10 text-center">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" class="ml-10">
        </div>
        <div class="m-10 text-center">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" class="ml-10">
        </div>
        <div class="m-10 text-center">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="ml-10">
        </div>
        <div class="m-10 text-center">
            <label for="password_confirmation">Confirm</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="ml-10">
        </div>
        <div class="m-10 text-center">
            <button type="submit" class="bg-green-950 text-white p-2">Register</button>
        </div>

    </form>
@endsection
