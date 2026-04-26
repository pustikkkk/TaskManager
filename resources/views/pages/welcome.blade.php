@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
    <h1 class="text-4xl font-bold m-4 text-center">Stay Organized. Get Things Done.</h1>
    <h4 class="text-xl font-semibold mt-4 text-center">A simple and powerful task manager that helps you plan your day, prioritize your work, and track progress without the clutter.</h4>
    <h1 class="text-4xl font-bold mt-20 text-left">What is Task Manager?</h1>
    <p class="text-xl mt-5 font-semibold">Task Manager is a lightweight productivity tool designed to help you stay on top of your daily responsibilities. Whether it’s school, work, or personal goals — everything stays organized in one place.</p>
    <h1 class="text-4xl font-bold mt-20 text-left">Everything you need to stay productive</h1>
    <ul class="space-y-2 list-disc pl-6 text-gray-700 mt-5">
        <li class="text-base">
            Create tasks in seconds
        </li>
        <li class="text-base">
            Set priorities to focus on what matters
        </li>
        <li class="text-base">
            Track progress as you complete your work
        </li>
        <li class="text-base">
            Keep your workflow clean and organized
        </li>
        <li class="text-base">
            Access your tasks anytime, anywhere
        </li>
    </ul>
@endsection
