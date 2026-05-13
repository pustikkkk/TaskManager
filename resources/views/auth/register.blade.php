{{-- Registration form; all validation errors are collected and displayed as a bulleted list below the inputs --}}
@extends('layouts.guest')

@section('title', 'Register')
@section('content')
    <div class="flex items-center justify-center">
    <form action="{{ route('register') }}" method="POST" class="w-3/5 mt-52 border-2  rounded-3xl backdrop-blur-sm bg-white/2 border-white/10 shadow-lg hover:shadow-xl transition-all duration-300">
        @csrf
        <div class="m-10 text-center">
            <div class="mb-5">
                <label for="username" class="mr-6">Username</label>
                <input id="username" type="text" name="username" class="appearance-none outline-none ring-0 focus:ring-0
                text-lg text-cyan-50/85  bg-white/5 backdrop-blur-3xl px-2 py-1 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
            </div>
            <div class="mb-5">
                <label for="email" class="mr-14">Email</label>
                <input id="email" type="email" name="email" class="appearance-none outline-none ring-0 focus:ring-0
                text-lg text-cyan-50/85  bg-white/5 backdrop-blur-3xl px-2 py-1 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
            </div>
            <div class="mb-5">
                <label for="password" class="mr-5">Password</label>
                <input id="password" type="password" name="password" class="appearance-none outline-none ring-0 focus:ring-0
                text-lg text-cyan-50/85  bg-white/5 backdrop-blur-3xl px-2 py-1 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
            </div>
            <div class="mb-5">
                <label for="password_confirmation" class="mr-8">Confirm</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="appearance-none outline-none ring-0 focus:ring-0
                text-lg text-cyan-50/85  bg-white/5 backdrop-blur-3xl px-2 py-1 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
            </div>
            @if($errors->any())
                <div class="mb-5 border border-white/10 shadow-lg backdrop-blur-3xl rounded-3xl text-center
                hover:shadow-xl transition-all duration-300">
                    <ul class="text-cyan-50/85 list-inside list-disc p-5">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-5">
                <button type="submit" class="text-lg text-cyan-50/85  bg-white/5 px-2 py-1 rounded-3xl shadow-md
                            border border-white/20 transition-all duration-300 hover:text-indigo-200/85
                            hover:bg-white/5 ml-60">Register</button>
            </div>
        </div>

    </form>
    </div>
@endsection
