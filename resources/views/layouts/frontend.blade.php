<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="canonical" href="@yield('seo_url_canonical')"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root{--swiper-theme-color:#007aff}html{line-height:1.15}body{margin:0}main{display:block}h1{font-size:2em;margin:.67em 0}a{background-color:transparent}img{border-style:none}button{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button{overflow:visible}button{text-transform:none}@font-face{font-family:Inter;font-weight:300;font-display:swap;font-style:normal;src:url(fonts/Inter-Light.woff2) format("woff2"),url(fonts/Inter-Light.woff) format("woff")}@font-face{font-family:Inter;font-weight:400;font-display:swap;font-style:normal;src:url(fonts/Inter-Regular.woff2) format("woff2"),url(fonts/Inter-Regular.woff) format("woff")}@font-face{font-family:Inter;font-weight:500;font-display:swap;font-style:normal;src:url(fonts/Inter-Medium.woff2) format("woff2"),url(fonts/Inter-Medium.woff) format("woff")}@font-face{font-family:Inter;font-weight:600;font-display:swap;font-style:normal;src:url(fonts/Inter-SemiBold.woff2) format("woff2"),url(fonts/Inter-SemiBold.woff) format("woff")}@font-face{font-family:Inter;font-weight:700;font-display:swap;font-style:normal;src:url(fonts/Inter-Bold.woff2) format("woff2"),url(fonts/Inter-Bold.woff) format("woff")}@font-face{font-family:SourceCodePro;font-weight:500;font-display:swap;font-style:normal;src:url(fonts/SourceCodePro-Medium.woff2) format("woff2"),url(fonts/SourceCodePro-Medium.woff) format("woff")}:root{--color-primary:#23F3A8;--color-secondary:#ff8800;--color-black:#141519}*{box-sizing:border-box}html{height:100%}body{display:flex;flex-direction:column;min-width:320px;min-height:100%;font-family:Inter,sans-serif;color:var(--color-black)}h1,p,ul{margin:0;padding:0}ul{list-style:none}a{text-decoration:none;color:inherit}img{max-width:100%}button{padding:0;border:none;background:0 0}.container{max-width:1470px;margin:0 auto;padding:0 15px}.title1,.title1 h1{line-height:1.3;font-weight:300;text-transform:uppercase}.title1--white,.title1--white h1{color:#fff}.title1--lh-120,.title1--lh-120 h1{line-height:1.2}.title1,.title1 h1{font-size:32px}.text{font-size:15px;line-height:1.2}.btn{padding:23px 32px;display:inline-block;background-color:var(--color-primary);text-align:center;font-size:15px;font-weight:500;line-height:1.2}.btn--black{background-color:var(--color-black);color:var(--color-primary)}.logo{display:flex;align-items:center}.logo__img{object-fit:contain}.logo__text{font-size:20px;font-weight:700;line-height:1;color:#323d4f}.logo__text:not(:first-child){margin-left:12px}.menu__header{display:none}.menu__list{display:flex;align-items:center}.menu__item{position:relative}.menu__item--mobile{display:none}.menu__link{display:inline-block;min-width:159px;text-align:center;padding:21px 24px;border-left:2px solid var(--color-black);font-size:15px;color:var(--color-black)}.menu__link img{margin-right:8px}.menu__open{height:24px;display:none}.menu__lines{position:relative;z-index:6}.menu__lines,.menu__lines:after,.menu__lines:before{height:2px;background-color:var(--color-black);display:block;transform:rotate(0);width:18px}.menu__lines:after,.menu__lines:before{content:"";position:absolute;right:0}.menu__lines:before{transform:translateY(-5px)}.menu__lines:after{transform:translateY(5px)}.menu__lines--close{height:0}.menu__lines--close:before{transform:rotate(-45deg);background-color:var(--color-black)}.menu__lines--close:after{transform:rotate(45deg);background-color:var(--color-black)}.menu__lang-box{display:none}.menu__btn{display:none}.dropdown{position:relative}.dropdown__main{position:absolute;top:100%;left:0;z-index:1;display:none}.lang__toggle{display:flex;align-items:center;padding:12px 20px 12px 25px;color:var(--color-black);border-left:2px solid var(--color-black);font-size:14px}.lang__toggle:after{content:"";border:4px solid transparent;border-top:4px solid var(--color-black);display:inline-block;top:17px;margin-left:8px;transform:translateY(2px)}.lang__dropdown{right:0;left:unset}.lang__btns{border:2px solid var(--color-black);border-right:none;display:flex}.lang__btn{padding:21px 41px;min-width:138px}.lang__btn:not(:first-child){border-left:2px solid var(--color-black)}.lang--menu .lang__dropdown{right:-4px}.lang--menu .lang__btns{border:2px solid #fff}.lang--menu .lang__toggle{color:var(--color-black);border-left:none}.lang--menu .lang__toggle:after{border-top-color:var(--color-black)}.lang--menu .lang__btn{border-color:#fff}.header{position:absolute;left:0;top:0;z-index:20;width:100%;background:#fff}.header__top{border-bottom:2px solid var(--color-black)}.header__container{display: flex;}.header__top-links{margin-left:auto;min-width: 278px;display:flex;justify-content:flex-end}.header__top-link{display:flex;align-items:center;flex: 1 1 auto;padding:12px 20px 12px 25px;color:var(--color-black);border-left:2px solid var(--color-black);font-size:14px}.header__top-link svg{margin-right:8px}.header__top-link svg{fill:var(--color-black)}.header__lang{width:82.5px}.header__bottom{border-bottom:2px solid var(--color-black)}.header__bottom-content{padding-left:16px;width: 100%;display:flex;align-items:center}.header__mobile-links{display:none}.header__mobile-link{font-size:14px;color:var(--color-black)}.header__menu{margin-left:auto}.header__btn{padding:21px 41px;min-width: 278px;border-left:2px solid var(--color-black)}.header--index:not(.header--fixed){background:0 0}.header--index:not(.header--fixed) .header__top{border-color:#fff}.header--index:not(.header--fixed) .header__top-link{color:#fff;border-color:#fff}.header--index:not(.header--fixed) .header__top-link svg{fill:#fff}.header--index:not(.header--fixed) .header__lang .lang__toggle{color:#fff;border-color:#fff}.header--index:not(.header--fixed) .header__lang .lang__toggle:after{border-top-color:#fff}.header--index:not(.header--fixed) .header__lang .lang__btns{border-color:#fff}.header--index:not(.header--fixed) .header__lang .lang__btn:not(:first-child){border-color:#fff}.header--index:not(.header--fixed) .header__menu .menu__link{color:#fff;border-color:#fff}.header--index:not(.header--fixed) .header__bottom{border-color:#fff}.header--index:not(.header--fixed) .header__btn{border-color:#fff}.breadcrumbs{padding-bottom:88px}.breadcrumbs__list{display:flex;align-items:center;font-family:SourceCodePro,sans-serif;line-height:1.27;font-size:15px;font-weight:500;letter-spacing:.04em;overflow-x:auto}.breadcrumbs__item{flex:0 0 auto;display:flex;align-items:center}.breadcrumbs__current{color:inherit;text-transform:uppercase}.breadcrumbs__current{flex:0 0 auto}.breadcrumbs--white{color:#fff}.main{padding-top:120px;overflow:hidden}.main__title{margin-bottom: 80px;padding: 0 16px;}.main__title h1,.main__title h2{text-transform: none;}.banner{position:relative;margin-top:-120px;padding-top:120px;padding-bottom:60px;min-height:max(900px,100vh)}.webp .banner{background: url(../img/banner.webp) center/cover no-repeat;background-position-y: 44%;}.no-webp .banner{background: url(../img/banner.jpg) center/cover no-repeat;background-position-y: 44%;}.banner:before{content:"";position:absolute;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.25)}.banner__content{position:relative;z-index:1;padding:0 16px}.banner__title{max-width:600px;color:#fff;text-transform:uppercase}.banner__features{margin-top:64px}.banner__features-list{margin:-16px -8px;display:flex;flex-wrap:wrap}.banner__features--indent{margin-top:290px;padding-top:14px;border-top:2px solid #fff}.banner__feature{display:flex;align-items:center;width:calc(25% - 18px);margin:16px 8px}.banner__feature:before{content:"";margin-right:24px;flex:0 0 auto;background-color:var(--color-primary);width:54px;height:54px;border-radius:50%}.banner__feature-text{max-width:250px;color:#fff}.banner__feature--vertical{flex-direction:column;align-items:flex-start}.banner__feature--vertical:before{margin-bottom:16px;margin-right:0;width:40px;height:40px}.banner__feature--vertical .banner__feature-text{max-width:240px;font-weight:500}.contacts__item:first-child{grid-area:A}.contacts__item:nth-child(2){grid-area:B}.contacts__item:nth-child(3){grid-area:C}.contacts__item:nth-child(4){grid-area:D}.contacts__item:nth-child(5){grid-area:E}.contacts__item:nth-child(6){grid-area:F;border-right-color:transparent}.contacts__item:nth-child(7){grid-area:G}.contacts__item:nth-child(8){grid-area:H;border-right-color:transparent}@media (max-width:1480px){.header__container{padding-right:0}}@media (max-width:1320px){.menu__link{min-width:142px;padding:16px}.lang__toggle{padding-right:17px;padding-left:21px}.lang__btn{padding-top:16px;padding-bottom:16px;min-width:130.5px}.header__top-links{min-width: 263px;}.header__top-link{padding-right:17px;padding-left:21px}.header__lang{width:auto}.header__bottom-content{padding-left:0}.header__btn{padding:16px 34px;min-width: 263px;}.banner{min-height:max(700px,100vh)}.banner__content{padding:0}.banner__features--indent{margin-top:226px}.breadcrumbs{padding-bottom:70px}}@media (max-width:1140px){.title1,.title1 h1{font-size:30px}.menu__link{min-width:auto;padding:14px 16px}.lang__toggle{padding:11px 7px 11px 15px}.lang__btn{padding-top:13.5px;padding-bottom:13px;min-width:114.5px}.header__top-links{min-width: 231px;}.header__top-link{padding:11px 7px 11px 15px}.header__btn{padding:14px 24px;min-width: 231px;font-size:14px}.breadcrumbs{padding-bottom:54px}.banner__feature{width:calc(50% - 18px)}.banner__feature--vertical{width:calc(25% - 18px)}}@media (max-width:991px){.title1,.title1 h1{font-size:28px}.text{font-size:14px}.logo__img{max-height:36px;max-width:41px}.logo__text{font-size:18px}.logo__text:not(:first-child){margin-left:10px}.btn{padding:19px 28px}.menu{position:relative}.menu__header{display:flex;justify-content:space-between}.menu__title{padding:21px 8px 19px 8px;font-size:18px;line-height:1.2;text-transform:uppercase}.menu__open{display:block;position:relative;z-index:0}.menu__close{padding:0 22px;background:#fff;border-left:2px solid var(--color-black)}.menu__content{position:fixed;left:0;top:0;z-index:3;transform:translateX(100%);display:flex;flex-direction:column;width:100%;height:100%;background-color:var(--color-primary);opacity:0;visibility:hidden;overflow-y:auto}.menu__list{justify-content:flex-start;align-items:center;flex-direction:column}.menu__item{width:100%}.menu__item--mobile{display:flex}.menu__link{display:flex;align-items:center;justify-content:center;padding-top:20px;padding-bottom:20px;width:100%;border-top:2px solid var(--color-black);border-left:none;font-size:14px;color:var(--color-black)}.menu__lang-box{padding-top:15px;padding-left:8px;padding-right:12px;display:flex;align-items:center;justify-content:space-between;border-top:2px solid var(--color-black);font-size:14px}.menu__lang-box:not(:last-child){margin-bottom:30px}.menu__btn{display:inline-block;margin:auto 8px 8px;padding-top:24px;padding-bottom:24px;font-size:14px}.header__container{padding-left:0}.header__top{display:none}.header__bottom-content{flex-wrap:wrap}.header__logo{padding:10px 0;width:100%;justify-content:center;border-bottom:2px solid var(--color-black)}.header__mobile-links{display:flex;width:calc(100% - 48px)}.header__mobile-link{padding:14px;border-right:2px solid var(--color-black);flex:1 1 100%;max-width:170px;text-align:center}.header__menu{margin-right:15px}.header__btn{padding-top:15px;padding-bottom:15px;border-left:none;border-top:2px solid var(--color-black);width:100%}.header--index:not(.header--fixed) .header__btn,.header--index:not(.header--fixed) .header__logo,.header--index:not(.header--fixed) .header__mobile-link{border-color:#fff}.header--index:not(.header--fixed) .header__mobile-link{color:#fff}.header--index:not(.header--fixed) .header__menu .menu__link{color:var(--color-black);border-color:var(--color-black)}.header--index:not(.header--fixed) .header__menu .menu__open .menu__lines,.header--index:not(.header--fixed) .header__menu .menu__open .menu__lines:after,.header--index:not(.header--fixed) .header__menu .menu__open .menu__lines:before{background-color:#fff}.main{padding-top:170px}.banner{margin-top:-170px;padding-top:170px}.banner__title{max-width:620px}.banner__feature{width:calc(50% - 16px)}.breadcrumbs{padding-bottom:40px}}@media (max-width:767px){.container{padding:0 8px}.title1,.title1 h1{font-size:22px;font-weight:400}.text{font-size:13px}.logo__img{max-height:28px;max-width:32px}.logo__text{font-size:16px}.logo__text:not(:first-child){margin-left:8px}.btn{font-size:14px;padding:16px 24px}.header__container{padding:0}.main{padding-top:155px}.banner{margin-top:-155px;padding-top:155px;padding-bottom:32px}.banner__title{max-width:480px}.banner__features--indent{padding-top:24px}.banner__feature{flex-direction:column;align-items:flex-start}.banner__feature:before{margin-bottom:12px;width:32px;height:32px}.banner__feature-text{font-size:13px;font-weight:500}.breadcrumbs{padding-bottom:32px}.breadcrumbs__list{font-size:14px}}@media (max-width:480px){.title1,.title1 h1{font-size:18px}.banner__title{max-width:390px}}
    </style>

    <!-- #CSS Links -->
    <!-- Basic Styles -->
{!! Html::style('css/swiper.min.css') !!}
{!! Html::style('css/overlayscrollbars.min.css') !!}
{!! Html::style('css/normalize.css') !!}
{!! Html::style('css/fonts.css') !!}
{!! Html::style('css/main.css') !!}
{!! Html::style('css/media.css') !!}
{!! Html::style('css/yatranslate.css') !!}

@yield('css')

<!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

</head>

<body class="body">
<header class="header">
    <div class="header__top">
        <div class="container header__container">
            <div class="header__top-links">
                <a class="link header__top-link" href="{{ route('frontend.converter') }}">
                    <svg width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0 11.3333V9.91667L4.60417 5.66667L0 1.41667V0H8.5V2.125H3.38229L7.18958 5.66667L3.38229 9.20833H8.5V11.3333H0Z"/>
                    </svg>
                    Конвертер ед. изм.
                </a>
                <div class="lang dropdown header__lang">
                    <button class="link lang__toggle dropdown__btn">RU</button>
                    <div class="lang__dropdown dropdown__main">
                        <div class="lang lang_fixed">
                            <div id="ytWidget" style="display: none;"></div>
                            <div class="lang__link lang__link_select" data-lang-active="">
                                <img class="lang__img lang__img_select" src="{{ url('img/lang/lang__ru.png') }}" alt="Ru">
                            </div>
                            <div class="lang__list" data-lang-list="">
                                <a class="lang__link lang__link_sub" data-ya-lang="ru">
                                    <img class="lang__img" src="{{ url('img/lang/lang__ru.png') }}" alt="ru">
                                </a>
                                <a class="lang__link lang__link_sub" data-ya-lang="en">
                                    <img class="lang__img" src="{{ url('img/lang/lang__en.png') }}" alt="en">
                                </a>
                                <a class="lang__link lang__link_sub" data-ya-lang="de">
                                    <img class="lang__img" src="{{ url('img/lang/lang__de.png') }}" alt="de">
                                </a>
                                <a class="lang__link lang__link_sub" data-ya-lang="zh">
                                    <img class="lang__img" src="{{ url('img/lang/lang__zh.png') }}" alt="zh">
                                </a>
                                <a class="lang__link lang__link_sub" data-ya-lang="fr">
                                    <img class="lang__img" src="{{ url('img/lang/lang__fr.png') }}" alt="fr">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container header__container">
            <div class="header__bottom-content">
                <a class="logo header__logo" href="{{ url('/') }}">
                    <img class="logo__img" src="{{ url('img/logo.png') }}" width="45" height="40" alt="">
                    <span class="logo__text">РИАС</span>
                </a>
                <div class="header__mobile-links">
                    <a class="link header__mobile-link" href="{{ URL::route('frontend.catalog') }}">Оборудование</a>
                    <a class="link header__mobile-link" href="{{ URL::route('frontend.contact') }}">Контакты</a>
                </div>
                <nav class="menu header__menu">
                    <div class="menu__content">
                        <div class="menu__header">
                            <div class="menu__title">Меню сайта</div>
                            <button class="menu__close">
                                <span class="menu__lines menu__lines--close"></span>
                            </button>
                        </div>

                        @if(isset($top_menu) && $top_menu)
                            <ul class="menu__list">

                                @foreach( $top_menu as $menu )
                                    <li class="menu__item">
                                        <a class="menu__link {{ Request::getRequestUri() == $menu['link'] ? 'menu__active' : '' }}"
                                           href="{{ $menu['link'] }}">
                                            {{ $menu['label'] }}
                                        </a>
                                    </li>
                                @endforeach

                                <li class="menu__item menu__item--mobile">
                                    <a class="menu__link" href="{{ URL::route('frontend.converter') }}">
                                        <img src="{{ url('img/icons/converter-black.svg') }}" width="10" height="12"
                                             alt="">
                                        Конвертер ед. изм.
                                    </a>
                                </li>
                            </ul>
                        @endif

                        <div class="menu__lang-box">
                            <span>Язык на сайте:</span>
                            <div class="lang lang--menu dropdown">
                                <button class="link lang__toggle dropdown__btn">RU</button>
                                <div class="lang__dropdown dropdown__main">
                                    <div class="lang lang_fixed">
                                        <div id="ytWidget" style="display: none;"></div>
                                        <div class="lang__link lang__link_select" data-lang-active="">
                                            <img class="lang__img lang__img_select" src="{{ url('img/lang/lang__ru.png') }}" alt="Ru">
                                        </div>
                                        <div class="lang__list" data-lang-list="">
                                            <a class="lang__link lang__link_sub" data-ya-lang="ru">
                                                <img class="lang__img" src="{{ url('img/lang/lang__ru.png') }}" alt="ru">
                                            </a>
                                            <a class="lang__link lang__link_sub" data-ya-lang="en">
                                                <img class="lang__img" src="{{ url('img/lang/lang__en.png') }}" alt="en">
                                            </a>
                                            <a class="lang__link lang__link_sub" data-ya-lang="de">
                                                <img class="lang__img" src="{{ url('img/lang/lang__de.png') }}" alt="de">
                                            </a>
                                            <a class="lang__link lang__link_sub" data-ya-lang="zh">
                                                <img class="lang__img" src="{{ url('img/lang/lang__zh.png') }}" alt="zh">
                                            </a>
                                            <a class="lang__link lang__link_sub" data-ya-lang="fr">
                                                <img class="lang__img" src="{{ url('img/lang/lang__fr.png') }}" alt="fr">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn--black menu__btn" href="{{ URL::route('frontend.application') }}">Заявка на
                            расчет проекта</a>
                    </div>
                    <button class="menu__open">
                        <span class="menu__lines"></span>
                    </button>
                </nav>
                <a class="btn header__btn" href="{{ URL::route('frontend.application') }}">Заявка на расчет проекта</a>
            </div>
        </div>
    </div>
</header>

<main class="main">

    @yield('content')

</main>

<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__copyright">© {{ date("Y") }} Все права
                защищены. {{ SettingsHelper::getSetting('SITE_NAME') }}</div>
            <ul class="footer__menu">
                <li class="footer__menu-item">
                    <a class="link footer__menu-link"
                       href="mailto:{{ SettingsHelper::getSetting('EMAIL') }}">{{ SettingsHelper::getSetting('EMAIL') }}</a>
                </li>
                <li class="footer__menu-item">
                    <a class="link footer__menu-link"
                       href="tel:{{ SettingsHelper::getSetting('PHONE') }}">{{ SettingsHelper::getSetting('PHONE') }}</a>
                </li>
            </ul>
        </div>
    </div>
</footer>


{!! Html::script('js/modernizr.min.js') !!}
{!! Html::script('js/overlayscrollbars.min.js') !!}
{!! Html::script('js/swiper-bundle.min.js') !!}
{!! Html::script('js/main.js?v=12') !!}
{!! Html::script('js/yatranslate.js') !!}

@yield('js')

</body>
</html>
