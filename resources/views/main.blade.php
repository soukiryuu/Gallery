<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel='stylesheet' href="{{ asset('unitegallery/css/unite-gallery.css') }}" type='text/css' />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/destyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type='text/javascript' src="{{ asset('unitegallery/js/jquery-11.0.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('unitegallery/js/unitegallery.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('unitegallery/themes/tiles/ug-theme-tiles.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
</head>
<body>
    <header id="header">
        <h1 class="site-title">
            <a href="index.html">りな写真集</a>
        </h1>

        <nav id="navi">
            <ul class="nav-menu">
                <li><a href="#pickup">PICK UP</a></li>
                <li><a href="#feature">FEATURE</a></li>
                <li><a href="#contact">CONTACT</a></li>
            </ul>
            <ul class="nav-sns">
                <li><a href="https://twitter.com/" target="_blank">Twitter</a></li>
                <li><a href="https://www.facebook.com/" target="_blank">facebook</a></li>
                <li><a href="https://www.instagram.com/" target="_blank">instagram</a></li>
            </ul>
        </nav>

        <div class="toggle_btn">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div id="mask"></div>
    </header>
    <div class="main">
        <section id="main-gallery">
            <h2 class="sec-title">写真集</h2>
            <div id="gallery">
                @foreach ($paths as $path)
                    <img alt="{{ $path['text'] }}"
                     src="{{ asset('/storage/images/lina/' . $path['path']) }}"
                     data-image="{{ asset('/storage/images/lina/' . $path['path']) }}"
                     data-image-mobile="{{ asset('/storage/images/lina/' . $path['path']) }}"
                     data-thumb-mobile="{{ asset('/storage/images/lina/' . $path['path']) }}"
                     data-description="{{ $path['text'] }}"
                     style="display:none">
                @endforeach
            </div>
        </section>
    </div>

    <footer id="footer">
        <p>&copy; LinaGallery</p>
    </footer>
</body>
</html>