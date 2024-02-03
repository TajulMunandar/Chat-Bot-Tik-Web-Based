<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.head')
    <title>CHAT BOT TIK</title>
</head>
<body class="g-sidenav-show bg-gray-100">
    @include('layout.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        @include('layout.navbar')
        @yield('content')
    </main>
    @include('layout.scirpt')

    @yield('scripts')
</body>
</html>
