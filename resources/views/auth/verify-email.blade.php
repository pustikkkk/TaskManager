@extends('layouts.guest')

@section('title', 'Verify email')

@section('content')
    <div class="border border-black">
        <p>You have successfully registered!</p>
        <p>A verification link has been sent to: <strong>{{ request()->user()->email }}</strong></p>
    </div>
@endsection
