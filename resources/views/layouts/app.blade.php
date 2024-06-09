<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css'])
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content">
        <header>
            <h2>Welcome {{ Auth::user()->name }}</h2>
        </header>
        <br>

        <section>
            {{ $slot }}
        </section>
    </div>
</body>
</html>
