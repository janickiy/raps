<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAPSystem | @yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="format-detection" content="telephone=no">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:site_name" content="raps.uz">
    <meta property="og:title" content="RAPSystem | @yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/favicon/android-chrome-512x512.png">
    <meta property="og:image:alt" content="RAPSystem logo">
    <meta property="og:url" content="@yield('seo_url_canonical')">
    <meta property="og:locale" content="ru_RU">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="prefetch" href="{{ url('/images/hero-img.jpg') }}">
    <link rel="preload" href="/fonts/Inter-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/Inter-Medium.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/Inter-Regular.woff2" as="font" type="font/woff2" crossorigin>


    {!! Html::style('css/styles.min.css') !!}

    @yield('css')

    {!! Html::script('scripts/script.min.js') !!}

</head>
<body>
<header class="header">
    <div class="header__top">
        <div class="container">
            <button type="button" class="header__menu-btn" data-menu-trigger="mobile-menu">
                Главное меню
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#menu') }}"/>
                </svg>
            </button>
            <a href="./" class="header__logo-short" aria-label="Перейти на главную страницу">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#color-logo-short') }}"/>
                </svg>
            </a>
            <nav class="header__nav">
                <ul>
                    <li class="header__submenu">
                        <div class="header__nav-item">
                            О компании
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"/>
                            </svg>
                        </div>

                        @if(isset($menu['about']) and $menu['about'])

                        <ul class="header__submenu-nav">

                            @foreach($menu['about'] as $item)
                                <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                            @endforeach

                        </ul>

                        @endif

                    </li>
                    <li class="header__submenu">
                        <a href="#" class="header__nav-item">
                            Услуги
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"/>
                            </svg>
                        </a>

                        @if(isset($menu['services']) and $menu['services'])

                            <ul class="header__submenu-nav _services">
                                @foreach($menu['services'] as $item)
                                    <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                                @endforeach
                            </ul>

                        @endif

                    </li>
                    <li><a href="{{ URL::route('frontend.contact') }}" class="header__nav-item">Контакты</a></li>
                </ul>
            </nav>
            <div class="header__menu-language">
                <button type="button" class="header__menu-language-btn js-language-btn"
                        data-menu-trigger="language-menu">RU
                </button>
                <div class="header__menu-language-wrap" data-menu-name="language-menu">
                    <ul>
                        <li>
                            <input type="radio" id="language-ru" class="js-language-menu-item" value="RU"
                                   name="language" checked>
                            <label for="language-ru" class="js-close-menu">RU</label>
                        </li>
                        <li>
                            <input type="radio" id="language-en" class="js-language-menu-item" value="EN"
                                   name="language">
                            <label for="language-en" class="js-close-menu">EN</label>
                        </li>
                        <li>
                            <input type="radio" id="language-uz" class="js-language-menu-item" value="UZ"
                                   name="language">
                            <label for="language-uz" class="js-close-menu">UZ</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom container">
        <a href="{{ URL::route('frontend.index') }}" class="header__logo" aria-label="Перейти на главную страницу">
            <svg aria-hidden="true">
                <use xlink:href="{{ url('/images/sprite.svg#color-logo') }}"/>
            </svg>
        </a>
        <div class="header__controls">
            <button type="button" class="btn btn-primary header__controls-btn" data-menu-trigger="product-menu">
                <span class="header__controls-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                Каталог
            </button>
            <div class="header__input">
                <input type="text" placeholder="Поиск по каталогу" class="js-header-input">
                <button type="button" aria-label="Найти">
                    <svg aria-hidden="true">
                        <use xlink:href="/images/sprite.svg#search"/>
                    </svg>
                </button>
                <div class="header__input-hints js-header-input-hints">
                    <ul>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Анализатор AtmosFIR">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль промышленных выбросов</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор AtmosFIR</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="./images/preview@2x.jpg 2x" alt="Анализатор SOLUS">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль промышленных выбросов</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор SOLUS</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="./images/preview@2x.jpg 2x" alt="Анализатор AtmosIR">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль промышленных выбросов</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор AtmosIR</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="NDIR анализатор Р2000">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль промышленных выбросов</span>
                                    <span class="header__input-hint-title">NDIR <b>анализат</b>ор Р2000</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="NDIR анализатор Р5000">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль промышленных выбросов</span>
                                    <span class="header__input-hint-title">NDIR <b>анализат</b>ор Р5000</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Анализатор SIGAS S200">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль концентрации газов в технологических процессах</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор SIGAS S200</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Анализатор SIGAS S200 ATEX">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль концентрации газов в технологических процессах</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор SIGAS S200 ATEX</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Переносной анализатор SPGAS">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль концентрации газов в технологических процессах</span>
                                    <span class="header__input-hint-title">Переносной <b>анализат</b>ор SPGAS</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="NDIR анализатор Р5000">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль промышленных выбросов</span>
                                    <span class="header__input-hint-title">NDIR <b>анализат</b>ор Р5000</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Анализатор SIGAS S200">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль концентрации газов в технологических процессах</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор SIGAS S200</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Анализатор SIGAS S200 ATEX">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль концентрации газов в технологических процессах</span>
                                    <span class="header__input-hint-title"><b>Анализат</b>ор SIGAS S200 ATEX</span>
                                </span>
                            </a>
                        </li>
                        <li class="header__input-hint">
                            <a href="#">
                                <picture>
                                    <source srcset="/images/preview.webp, /images/preview@2x.webp 2x" type="image/webp">
                                    <img src="{{ url('/images/preview.jpg') }}" srcset="/images/preview@2x.jpg 2x" alt="Переносной анализатор SPGAS">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">Контроль концентрации газов в технологических процессах</span>
                                    <span class="header__input-hint-title">Переносной <b>анализат</b>ор SPGAS</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="{{ URL::route('frontend.application') }}" class="btn btn-primary-outline header__controls-btn">Оформить заявку</a>
        </div>
    </div>
    <div class="header__mobile-menu" data-menu-name="mobile-menu">
        <div class="header__mobile-menu-header">
            <span class="header__mobile-menu-title">Меню</span>
            <button type="button" class="header__mobile-menu-close-btn js-close-menu">
                Close
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#close') }}"/>
                </svg>
            </button>
        </div>
        <div class="header__mobile-menu-body">
            <nav class="header__mobile-menu-links">
                <ul>
                    <li><a href="./catalog.html" class="header__mobile-menu-link js-mobile-menu-link">Каталог</a></li>
                    <li class="header__mobile-submenu">
                        <input id="mobile-submenu-about" name="mobile-menu" type="checkbox">
                        <label for="mobile-submenu-about">
                            О компании
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#chevron-down"/>
                            </svg>
                        </label>
                        <div class="header__mobile-submenu-body">
                            <ul class="header__mobile-submenu-list">
                                <li><a href="./about-company.html" class="js-mobile-menu-link">О компании</a></li>
                                <li><a href="./certificates.html" class="js-mobile-menu-link">Сертификаты</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="header__mobile-submenu">
                        <input id="mobile-submenu-services" name="mobile-menu" type="checkbox">
                        <label for="mobile-submenu-services">
                            Услуги
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"/>
                            </svg>
                        </label>
                        <div class="header__mobile-submenu-body">

                            @if(isset($menu['services']) and $menu['services'])

                                <ul class="header__mobile-submenu-list">
                                    @foreach($menu['services'] as $item)
                                        <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                                    @endforeach
                                </ul>

                            @endif

                        </div>
                    </li>
                    <li><a href="{{ URL::route('frontend.contact') }}" class="header__mobile-menu-link js-mobile-menu-link">Контакты</a></li>
                </ul>
            </nav>
            <a href="{{ URL::route('frontend.application') }}" class="btn btn-primary header__mobile-menu-request">Оформить заявку</a>
        </div>
    </div>
    <div class="header__product-menu" data-menu-name="product-menu">
        <div class="header__product-menu-wrap">
            <div class="container">
                <ul class="header__product-menu-item">

                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <picture class="header__product-menu-img">
                                <source
                                    srcset="./images/category/category-3.webp, ./images/category/category-3@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/category/category-3.jpg"
                                    srcset="./images/category/category-3@2x.jpg 2x"
                                    alt="Контроль загазованности рабочей среды">
                            </picture>
                            <span class="header__product-menu-title">Контроль загазованности рабочей&nbsp;среды</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <picture class="header__product-menu-img">
                                <source
                                    srcset="./images/category/category-1.webp, ./images/category/category-1@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/category/category-1.jpg"
                                    srcset="./images/category/category-1@2x.jpg 2x"
                                    alt="Оборудование для контроля промышленных выбросов">
                            </picture>
                            <span class="header__product-menu-title">Продукция для контроля промышленных выбросов</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <picture class="header__product-menu-img">
                                <source
                                    srcset="./images/category/category-2.webp, ./images/category/category-2@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/category/category-2.jpg"
                                    srcset="./images/category/category-2@2x.jpg 2x"
                                    alt="Контроль концентрации газов в технологических процессах">
                            </picture>
                            <span class="header__product-menu-title">Контроль концентрации газов в&nbsp;технологических процессах</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <ul class="header__product-menu-item">
                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <span class="header__product-menu-logo">
                                <picture>
                                    <source
                                        srcset="./images/brands/raps.webp, ./images/brands/raps@2x.webp 2x"
                                        type="image/webp">
                                    <img
                                        src="./images/brands/raps.png"
                                        srcset="./images/brands/raps@2x.png 2x"
                                        alt="Raps">
                                </picture>
                            </span>
                            <span class="header__product-menu-title">RAPS</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <span class="header__product-menu-logo">
                                <picture>
                                    <source
                                        srcset="./images/brands/sigas.webp, ./images/brands/sigas@2x.webp 2x"
                                        type="image/webp">
                                    <img
                                        src="./images/brands/sigas.png"
                                        srcset="./images/brands/sigas@2x.png 2x"
                                        alt="Sigas">
                                </picture>
                            </span>
                            <span class="header__product-menu-title">SIGAS</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <span class="header__product-menu-logo">
                                <picture>
                                    <source
                                        srcset="./images/brands/protea.webp, ./images/brands/protea@2x.webp 2x"
                                        type="image/webp">
                                    <img
                                        src="./images/brands/protea.png"
                                        srcset="./images/brands/protea@2x.png 2x"
                                        alt="Protea">
                                </picture>
                            </span>
                            <span class="header__product-menu-title">PROTEA</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="./product-listing.html" class="header__product-menu-link">
                            <span class="header__product-menu-logo">
                                <picture>
                                    <source
                                        srcset="./images/brands/metran.webp, ./images/brands/metran@2x.webp 2x"
                                        type="image/webp">
                                    <img
                                        src="./images/brands/metran.png"
                                        srcset="./images/brands/metran@2x.png 2x"
                                        alt="Metran">
                                </picture>
                            </span>
                            <span class="header__product-menu-title">METRAN</span>
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#arrow-right"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<main>

    @yield('content')

</main>
<footer class="footer">
    <div class="footer__top">
        <div class="container">
            <div class="footer__top-wrapper">
                <a href="{{ URL::route('frontend.index') }}" class="footer__logo" aria-label="Перейти на главную страницу">
                    <svg aria-hidden="true">
                        <use xlink:href="./images/sprite.svg#logo"/>
                    </svg>
                    <span aria-hidden="true">Raps</span>
                </a>
                <div class="footer__nav-list">
                    <div class="footer__nav">
                        <h3>Мы</h3>

                        @if(isset($menu['about']) and $menu['about'])

                        <ul>
                            @foreach($menu['about'] as $item)
                                <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                            @endforeach
                        </ul>

                        @endif

                    </div>
                    <div class="footer__nav">
                        <h3>Услуги</h3>

                        @if(isset($menu['services']) and $menu['services'])

                            <ul>
                                @foreach($menu['services'] as $item)
                                    <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                                @endforeach
                            </ul>

                        @endif

                    </div>
                </div>
            </div>
            <a href="{{ URL::route('frontend.application') }}" class="btn btn-secondary footer__btn">Оформить заявку</a>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <span class="footer__bottom-copyright">© 2015-{{ date("Y") }} RAPS</span>
            <ul class="footer__bottom-links">
                <li><a href="#">Условия использования</a></li>
                <li><a href="#">Политика конфиденциальности</a></li>
            </ul>
        </div>
    </div>
</footer>

<main>@yield('js')</main>

</body>
</html>
