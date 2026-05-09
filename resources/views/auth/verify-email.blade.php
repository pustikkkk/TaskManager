@extends('layouts.guest')

@section('title', 'Verify email')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-2/5 border border-white/10 shadow-lg
        backdrop-blur-xl hover:shadow-xl
        hover:backdrop-blur-2xl rounded-3xl p-6 text-center">

            <p class="mb-2">You have successfully registered!</p>
            <p class="mb-2">Once you've confirmed your email address, you can start creating your tasks.</p>
            <p class="mb-2"> Check your inbox or spam folder for the email.</p>
            <p class="mb-2">
                A verification link has been sent to:
                <strong><i>{{ request()->user()->email }}</i></strong>
            </p>
        </div>
    </div>
@endsection
