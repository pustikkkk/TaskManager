<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Welcome')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-cyan-600 to-blue-900 text-cyan-50/85 align-middle">
<header>
    <nav class="h-14 flex items-center px-4 bg-white/10 backdrop-blur-2xl
            border border-white/20
            rounded-3xl shadow-lg
            transition-all duration-300
            hover:bg-white/15 m-3 font-medium">
        <a href="{{route('welcome')}}" class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-2 py-1 rounded-3xl shadow-lg
                border border-white/20 transition-all duration-300
                hover:text-blue-200/85 hover:bg-white/5">Task Manager</a>
        @if (request()->routeIs('welcome'))
            <div class="ml-auto flex gap-4">
                <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-2 py-1 rounded-3xl shadow-lg
                border border-white/20 transition-all duration-300
                hover:text-blue-200/85 hover:bg-white/5" href="{{route('login')}}">Log in</a>
                <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-2 py-1 rounded-3xl shadow-lg
                border border-white/20 transition-all duration-300
                hover:text-blue-200/85 hover:bg-white/5"  href="{{route('register')}}">Register</a>
            </div>
        @endif
        @if(request()->routeIs('login'))
            <div class="ml-auto flex gap-4">
                <a class="text-lg text-cyan-50 hover:text-blue-200/85 hover:transition hover:duration-300" href="{{route('register')}}">Register</a>
            </div>
        @endif
        @if(request()->routeIs('register'))
            <div class="ml-auto flex gap-4">
                <a class="text-lg text-cyan-50 hover:text-blue-200/85 hover:transition hover:duration-300" href="{{route('login')}}">Log in</a>
            </div>
        @endif
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
