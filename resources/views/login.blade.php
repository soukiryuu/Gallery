<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gallery</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/destyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/style.css') }}">
</head>
<body>
    <header id="header">
        <h1 class="site-title">
            <a href="index.html">りな写真集</a>
        </h1>
    </header>

    <div class="wrapper">
        <div class="login-wrapper">
            @if (session('error')) 
            <div class="alert">{{ session('error') }}</div>
        @endif
            <form action="{{ route('login.authcode') }}" method="post">
                @csrf
                <dl>
                    <dt>
                        <label for="auth-code">認証コード</label>
                    </dt>
                    <dd>
                        <input type="text" id="code" name="auth-code">
                    </dd>
                </dl>

                <div class="button">
                    <input type="submit" value="送信">
                </div>
            </form>
        </div>

        <footer id="footer">
            <p>&copy; LinaGallery</p>
        </footer>
    </div>
</body>
</html>