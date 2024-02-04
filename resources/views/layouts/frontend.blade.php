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
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:site_name" content="raps.uz">
    <meta property="og:title" content="RAPSystem | @yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ url('/favicon/android-chrome-512x512.png') }}">
    <meta property="og:image:alt" content="RAPSystem logo">
    <meta property="og:url" content="@yield('seo_url_canonical')">
    <meta property="og:locale" content="ru_RU">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="prefetch" href="{{ url('/images/hero-img.jpg') }}">
    <link rel="preload" href="{{ url('/fonts/Inter-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ url('/fonts/Inter-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ url('/fonts/Inter-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

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
                        <a href="{{ URL::route('frontend.services_listing') }}" class="header__nav-item">
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
                        <use xlink:href="{{ url('/images/sprite.svg#search') }}"/>
                    </svg>
                </button>
                <div class="header__input-hints js-header-input-hints">
                    <ul>

                        @foreach($catalogs as $row)

                        <li class="header__input-hint">
                            <a href="{{ URL::route('frontend.product_listing',['slug' => $row->slug]) }}">
                                <picture>
                                    <img src="{{ url($row->getImage()) }}" srcset="{{ url($row->getImage('2x_')) }}" alt="{{ $row->image_title ?? $row->name }}">
                                </picture>
                                <span class="header__input-hint-info">
                                    <span class="header__input-hint-category">{{ $row->name }}</span>
                                    <span class="header__input-hint-title">{{ $row->description }}</span>
                                </span>
                            </a>
                        </li>

                        @endforeach

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

                    <li><a href="{{ URL::route('frontend.catalog') }}" class="header__mobile-menu-link js-mobile-menu-link">Каталог</a></li>
                    <li class="header__mobile-submenu">
                        <input id="mobile-submenu-about" name="mobile-menu" type="checkbox">
                        <label for="mobile-submenu-about">
                            О компании
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#chevron-down') }}"/>
                            </svg>
                        </label>
                        <div class="header__mobile-submenu-body">

                            @if(isset($menu['about']) and $menu['about'])

                                <ul class="header__mobile-submenu-list">

                                    @foreach($menu['about'] as $item)
                                        <li><a href="{{ $item['link'] }}" class="js-mobile-menu-link">{{ $item['label'] }}</a></li>
                                    @endforeach

                                </ul>

                            @endif

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

                    @foreach($catalogs as $row)

                    <li>
                        <a href="{{ URL::route('frontend.product_listing',['slug' => $row->slug]) }}" class="header__product-menu-link">
                            <picture class="header__product-menu-img">
                                <img src="{{ url($row->getImage()) }}" srcset="{{ url($row->getImage('2x_')) }} 2x" alt="{{ $row->image_title ?? $row->name }}">
                            </picture>
                            <span class="header__product-menu-title">{{ $row->name }}</span>
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                            </svg>
                        </a>
                    </li>

                    @endforeach

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


<div aria-label="Опросный лист для заказа" role="dialog" aria-modal="true" data-name="requestModal" class="js-modal request-modal">
    <div class="js-modal-content request-modal__content">
        <div class="request-modal__header">
            <button type="button" class="js-close-modal-btn request-modal__close-btn">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#close') }}"/>
                </svg>
            </button>
        </div>
        <div class="request-modal__body">
            <div class="request-modal__title">
                <h3><span>Опросный лист для заказа</span> «Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор»</h3>
            </div>
            <a href="{{ url('/images/certificate-img.jpg') }}" class="btn request-modal__download-btn" download>
                <span class="request-modal__download-icon">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#download') }}"/>
                    </svg>
                </span>
                <span class="request-modal__download-title">Скачать опросный лист</span>
            </a>
            <p class="request-modal__text">После заполнения опросного листа, вам необходимо загрузить его и отправить нам. Мы изучим его и свяжемся с вами в ближайшее время с ответом.</p>
            <div class="request-modal__form">

                <form action="#" method="post" id="requestForm" class="request-form">
                    <div class="request-form__input-file">
                        <input id="requestFile" type="file" name="file">
                        <label for="requestFile">
                            <span class="request-form__label-title js-request-label-title">Загрузить опросный лист</span>
                            <span class="request-form__label-desc">Перетащите документ сюда, либо выберите вручную</span>
                        </label>
                    </div>
                    <p class="request-form__text">Если у вас возникли какие-либо вопросы, <a href="{{ URL::route('frontend.contact') }}">свяжитесь с нами</a>  любым удобным способом.</p>
                    <button type="submit" class="btn btn-primary request-form__btn">Отправить заявку</button>
                </form>

            </div>
        </div>
    </div>
</div>

@yield('js')

</body>
</html>
