<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Welcome')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav class="h-12 bg-black flex items-center px-6">
        <a class="text-lg text-white">Task Manager</a>
        <div class="ml-auto flex gap-4">
            <a class="text-lg text-white" href="{{route('login')}}">Log in</a>
            <a class="text-lg text-white" href="{{route('register')}}">Register</a>
        </div>
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
