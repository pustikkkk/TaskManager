<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Task Manager')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="bg-blue-700">
        <a class="bg-red-400">Log out</a>
        <a class="bg-red-400">Create a Task</a>
    </header>
    <main>
        @yield('content')
    </main>

</body>
</html>
