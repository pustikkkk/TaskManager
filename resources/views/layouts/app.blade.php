<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-blue-500 via-blue-600 to-blue-800 text-cyan-50/85 min-h-screen">
<header>
    <nav class="h-14 flex items-center px-4 bg-white/10 backdrop-blur-sm
            border border-white/20
            rounded-3xl shadow-lg
            transition-all duration-300
            hover:bg-white/10 m-3
             hover:backdrop-blur-md
             hover:shadow-xl font-medium">
        <a href="{{route('dashboard')}}" class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2xl px-2 py-1 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5">Task Manager</a>
        <div class="ml-auto flex gap-4">
            @if (request()->routeIs('dashboard'))
            <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2xl px-2 py-1 mt-5 mr-1 h-9 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5" href="{{route('tasks.create')}}">Create a task</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-1 py-1 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5 m-2 mt-5">Log out</button>
            </form>
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
