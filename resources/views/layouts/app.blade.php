<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav class="h-12 bg-black flex items-center px-6">
        <a href="{{route('dashboard')}}" class="text-lg text-white">Task Manager</a>
        @if (request()->routeIs('dashboard'))
            <div class="ml-auto flex gap-4">
                <a class="text-lg text-white">Create a task</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-lg text-red-200 bg-transparent">Log out</button>
                </form>
            </div>
        @endif
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
