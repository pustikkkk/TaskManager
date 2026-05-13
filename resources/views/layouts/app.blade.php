{{-- Authenticated layout: glass nav bar with home link, conditional "Create a task" link (dashboard only), and logout form --}}
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-blue-500 via-blue-600 to-blue-800 text-cyan-50/85 min-h-screen">
<header>
    <nav class="min-h-14 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-0 px-4 py-3 sm:py-0 bg-white/10 backdrop-blur-sm
            border border-white/20
            rounded-3xl shadow-lg
            transition-all duration-300
            hover:bg-white/10 m-3
            hover:backdrop-blur-md
            hover:shadow-xl font-medium">

        <a href="{{route('dashboard')}}"
           class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2xl px-3 py-1.5 rounded-3xl shadow-md
                  border border-white/20 transition-all duration-300
                  hover:text-indigo-200/85 hover:bg-white/5 text-center sm:text-left w-full sm:w-auto">
            Task Manager
        </a>

        <div class="sm:ml-auto flex flex-col sm:flex-row gap-3 sm:gap-4 items-stretch sm:items-center w-full sm:w-auto">

            {{-- "Create a task" link only appears when the user is on the dashboard --}}
            @if (request()->routeIs('dashboard'))
                <a class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2xl px-3 py-1.5 rounded-3xl shadow-md
                    border border-white/20 transition-all duration-300
                    hover:text-indigo-200/85 hover:bg-white/5 text-center"
                   href="{{route('tasks.create')}}">
                    Create a task
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf
                <button class="w-full h-full text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2xl px-3 py-1.5 mt-4 rounded-3xl shadow-md border border-white/20 transition-all duration-300 hover:text-rose-300/85 hover:bg-white/5">
                    Log out
                </button>
            </form>
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
