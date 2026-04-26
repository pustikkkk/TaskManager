@extends('layouts.guest')

@section('title', 'Login')
@section('content')
<form action="{{ route('login') }}" method="POST" class="mt-52 border-2  border-black">
    @csrf
    <div class="m-10 text-center">
        <label for="username">Username</label>
        <input id="username" type="text" name="username" class="ml-10">
    </div>
    <div class="m-10 text-center">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" class="ml-10">
    </div>
    <div class="m-10 text-center">
        <button type="submit" class="bg-green-950 text-white p-2">Login</button>
    </div>

</form>
@endsection
