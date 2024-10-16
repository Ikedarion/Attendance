<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">Atte</a>
            <div class="header__link">
                @yield('link')
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer__content">
            Atte,inc
        </div>
    </footer>
</body>

</html>