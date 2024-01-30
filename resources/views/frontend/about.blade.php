@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ URL::route('frontend.index') }}">Главная</a></li>
        <li><span>{{ $h1 }}</span></li>
    </ul>

    <section class="about-hero container">
        <div class="about-hero__info">
            <div class="main-title about-hero__title">
                <h1>Мы рады представить вам нашу компанию!</h1>
            </div>
            <p class="section-desc about-hero__desc">Наши основные ценности и цель — предоставлять передовые, надежные и инновационные решения в области газоанализа. Мы стремимся помочь нашим клиентам эффективно контролировать и оптимизировать процессы, снижая риски и обеспечивая безопасность в различных отраслях.</p>
        </div>
        <picture class="about-hero__img">
            <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
            <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
        </picture>
        <ul class="about-hero__list">
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-1') }}"/>
                </svg>
                <h2>Первый производитель в Узбекистане</h2>
                <p>Мы гордимся тем, что мы первые производители аналитического оборудования в стране, предлагая инновационные решения.</p>
            </li>
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-2') }}"/>
                </svg>
                <h2>Эксклюзивные представители SIGAS</h2>
                <p>Мы являемся эксклюзивными представителями SIGAS Measurement Engineering Corp в Узбекистане, обеспечивая доступ к их передовым технологиям.</p>
            </li>
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-3') }}"/>
                </svg>
                <h2>Комплексные аналитические решения «под ключ»</h2>
                <p>Мы гордимся тем, что мы первые производители аналитического оборудования в стране, предлагая инновационные решения.</p>
            </li>
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-4') }}"/>
                </svg>
                <h2>Собственное производство аналитических систем</h2>
                <p>Наше собственное производство под брендом RAPS гарантирует высокое качество и индивидуальный подход к каждому клиенту.</p>
            </li>
        </ul>
    </section>
    <section class="about-info container">
        <div class="about-info__content">
            <div class="section-title">
                <h2>{{ $h1 }}</h2>
            </div>
            <div class="about-info__text">
                <p class="section-desc">Мы — компания, занимающаяся продажей газоаналитического оборудования в Узбекистане. На нашем сайте представлена продукция от трех производителей: SIGAS, Protea, МЕТРАН, а также оборудование, которое мы производим сами под брендом RAPS.</p>
                <p class="section-desc">Мы гордимся тем, что являемся первым производителем газоаналитического оборудования в Узбекистане. Кроме того, мы являемся эксклюзивными представителями компании SIGAS Measurement Engineering Corp и предоставляем комплексные аналитические решения «под ключ».</p>
            </div>
            <div class="about-info__images">
                <picture class="about-info__img _two-columns">
                    <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
                    <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
                </picture>
                <picture class="about-info__img">
                    <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
                    <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
                </picture>
                <picture class="about-info__img">
                    <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
                    <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
                </picture>
            </div>
            <a href="{{ URL::route('frontend.application') }}" class="btn btn-primary about-info__btn">Оформить заявку</a>
        </div>
        <div class="about-info__images">
            <picture class="about-info__img _two-columns">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
            </picture>
            <picture class="about-info__img">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
            </picture>
            <picture class="about-info__img">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
            </picture>
        </div>
    </section>
    <section class="partners">
        <div class="container">
            <div class="section-title _center">
                <h2>Наши партнеры</h2>
            </div>
            <div class="partners__brands">
                <div class="swiper partners__slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="partners__brand">
                                <picture>
                                    <source srcset="{{ url('/images/brands/sigas.webp') }}, {{ url('/images/brands/sigas@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/sigas.png') }}" srcset="{{ url('/images/brands/sigas@2x.png') }} 2x" alt="Sigas" loading="lazy">
                                </picture>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="partners__brand _metran">
                                <picture>
                                    <source srcset="{{ url('/images/brands/metran.webp') }}, {{ url('/images/brands/metran@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/metran.png') }}" srcset="{{ url('/images/brands/metran@2x.png') }} 2x" alt="Метран" loading="lazy">
                                </picture>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="partners__brand _protea">
                                <picture>
                                    <source srcset="{{ url('/images/brands/protea.webp') }}, {{ url('/images/brands/protea@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/protea.png') }}" srcset="{{ url('/images/brands/protea@2x.png') }} 2x" alt="Protea" loading="lazy">
                                </picture>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="partners__brand">
                                <picture>
                                    <source srcset="{{ url('/images/brands/raps.webp') }}, {{ url('/images/brands/raps@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/raps.png') }}" srcset="{{ url('/images/brands/raps@2x.png') }} 2x" alt="Protea" loading="lazy">
                                </picture>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-left') }}"/>
                    </svg>
                </div>
                <div class="swiper-button-next">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


@endsection
