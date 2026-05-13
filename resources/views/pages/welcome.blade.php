{{-- Redesigned: replaced plain text sections with glass-morphism hero, about card, feature grid, and bottom CTA --}}
@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
    {{-- Hero: new — large headline, subtitle, two CTA buttons (Start for free → register, Log in → login) --}}
    <div class="flex flex-col items-center justify-center text-center px-6 pt-24 pb-16">
        <h1 class="text-6xl font-bold tracking-tight leading-tight max-w-2xl">
            Stay Organized.<br>Get Things Done.
        </h1>
        <p class="text-lg font-medium mt-5 max-w-xl text-cyan-50/70">
            A lightweight task manager that helps you plan your day, prioritize what matters,
            and track progress — without the clutter.
        </p>
        <div class="flex gap-4 mt-10">
            <a href="{{ route('register') }}"
               class="text-lg font-semibold text-cyan-50/90 bg-white/15 backdrop-blur-md px-7 py-2.5 rounded-3xl shadow-lg
                      border border-white/30 transition-all duration-300
                      hover:bg-white/25 hover:shadow-xl hover:text-white">
                Start for free &rarr;
            </a>
            <a href="{{ route('login') }}"
               class="text-lg font-semibold text-cyan-50/90 bg-white/15 backdrop-blur-md px-7 py-2.5 rounded-3xl shadow-lg
                      border border-white/30 transition-all duration-300
                      hover:bg-white/25 hover:shadow-xl hover:text-white">
                Log in
            </a>
        </div>
    </div>

    {{-- About: new — "What is Task Manager?" moved into a glass card --}}
    <div class="flex justify-center px-6 pb-12">
        <div class="max-w-2xl w-full bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-10
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300 text-center">
            <h2 class="text-3xl font-bold mb-4">What is Task Manager?</h2>
            <p class="text-base font-medium text-cyan-50/70 leading-relaxed">
                Task Manager is your personal productivity companion. Whether it's school assignments,
                work deadlines, or personal goals — everything stays organized in one clean,
                distraction-free space. Built for people who want simplicity without sacrificing power.
            </p>
        </div>
    </div>

    {{-- Feature cards: new — responsive 3-column glass grid replacing the plain bullet list --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 max-w-4xl mx-auto px-6 pb-24">
        <div class="bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-7
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2">Create in seconds</h3>
            <p class="text-sm text-cyan-50/65 font-medium leading-relaxed">
                Add tasks instantly with a title, priority, and due date. No friction, no fuss.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-7
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2">Set priorities</h3>
            <p class="text-sm text-cyan-50/65 font-medium leading-relaxed">
                Mark tasks as low, medium, or high priority so you always know what to tackle first.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-7
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2">Track progress</h3>
            <p class="text-sm text-cyan-50/65 font-medium leading-relaxed">
                Watch tasks move from pending to complete. Stay motivated as your list shrinks.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-7
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2">Due date filtering</h3>
            <p class="text-sm text-cyan-50/65 font-medium leading-relaxed">
                Filter by today, this week, or this month to stay ahead of every deadline.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-7
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2">Clean archive</h3>
            <p class="text-sm text-cyan-50/65 font-medium leading-relaxed">
                Completed and expired tasks are archived separately, keeping your active list focused.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm border border-white/20 rounded-3xl shadow-lg p-7
                    hover:bg-white/10 hover:shadow-xl transition-all duration-300">
            <h3 class="text-lg font-semibold mb-2">Private by design</h3>
            <p class="text-sm text-cyan-50/65 font-medium leading-relaxed">
                Every task is tied to your verified account. Your data stays yours, always.
            </p>
        </div>
    </div>

    {{-- Bottom CTA: new — second "Start for free" so users don't scroll back to the top --}}
    <div class="flex flex-col items-center text-center pb-24 px-6">
        <h2 class="text-3xl font-bold mb-4">Ready to get started?</h2>
        <p class="text-base font-medium text-cyan-50/70 mb-8 max-w-md">
            Join in seconds — no credit card, no setup. Just you and your tasks.
        </p>
        <a href="{{ route('register') }}"
           class="text-lg font-semibold text-cyan-50/90 bg-white/15 backdrop-blur-md px-8 py-3 rounded-3xl shadow-lg
                  border border-white/30 transition-all duration-300
                  hover:bg-white/25 hover:shadow-xl hover:text-white">
            Start for free &rarr;
        </a>
    </div>
@endsection
