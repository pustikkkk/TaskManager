<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-cyan-600 to-blue-900 text-cyan-50/85 align-middle">
<header>
    <nav class="h-12 bg-black flex items-center px-6">
        <a href="{{route('dashboard')}}" class="text-lg text-white">Task Manager</a>

            <div class="ml-auto flex gap-4">
                @if (request()->routeIs('dashboard'))
                <a class="text-lg text-white" href="{{route('tasks.create')}}">Create a task</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-lg text-red-200 bg-transparent">Log out</button>
                </form>
            </div>

    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
