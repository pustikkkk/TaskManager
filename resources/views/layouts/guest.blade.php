<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>@yield('title', 'Welcome')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="bg-blue-700">
    <a class="bg-green-400">Log in</a>
    <a class="bg-blue-200">Register</a>
</header>
<main>
    @yield('content')
</main>
</body>
</html>
