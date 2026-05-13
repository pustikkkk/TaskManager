{{-- Guest (unauthenticated) layout: nav shows Login+Register on welcome, Register-only on login page, Login-only on register page --}}
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Welcome')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-blue-500 via-blue-600 to-blue-800 text-cyan-50/85 align-middle">
<header>
    <nav class="h-14 flex items-center px-4 bg-white/10 backdrop-blur-sm
            border border-white/20
            rounded-3xl shadow-lg
            transition-all duration-300
            hover:bg-white/10 m-3
             hover:backdrop-blur-md
             hover:shadow-xl font-medium">
        <a href="{{route('welcome')}}" class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2xl px-3 py-1.5 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5">Task Manager</a>
        @if (request()->routeIs('welcome'))
            <div class="ml-auto flex gap-4 items-center">
                <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-3 py-1.5 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5" href="{{route('login')}}">Log in</a>
                <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-3 py-1.5 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5"  href="{{route('register')}}">Register</a>
            </div>
        @endif
        @if(request()->routeIs('login'))
            <div class="ml-auto flex gap-4 items-center">
                <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-3 py-1.5 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5" href="{{route('register')}}">Register</a>
            </div>
        @endif
        @if(request()->routeIs('register'))
            <div class="ml-auto flex gap-4 items-center">
                <a class="text-lg text-cyan-50/85  bg-white/5 backdrop-blur-2 px-3 py-1.5 rounded-3xl shadow-md
                border border-white/20 transition-all duration-300
                hover:text-indigo-200/85 hover:bg-white/5" href="{{route('login')}}">Log in</a>
            </div>
        @endif
    </nav>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
