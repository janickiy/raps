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
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="about-hero container">
        <div class="about-hero__info">
            <div class="main-title about-hero__title">
                <h1>Мы рады представить вам нашу компанию!</h1>
            </div>
            <p class="section-desc about-hero__desc">Наши основные ценности и цель — предоставлять передовые, надежные и
                инновационные решения в области газоанализа. Мы стремимся помочь нашим клиентам эффективно
                контролировать и оптимизировать процессы, снижая риски и обеспечивая безопасность в различных
                отраслях.</p>
        </div>
        <picture class="about-hero__img">
            <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                    type="image/webp">
            <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps"
                 loading="lazy">
        </picture>
        <ul class="about-hero__list">
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-1') }}"/>
                </svg>
                <h2>Первый производитель в Узбекистане</h2>
                <p>Мы гордимся тем, что мы первые производители аналитического оборудования в стране, предлагая
                    инновационные решения.</p>
            </li>
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-2') }}"/>
                </svg>
                <h2>Эксклюзивные представители SIGAS</h2>
                <p>Мы являемся эксклюзивными представителями SIGAS Measurement Engineering Corp в Узбекистане,
                    обеспечивая доступ к их передовым технологиям.</p>
            </li>
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-3') }}"/>
                </svg>
                <h2>Комплексные аналитические решения «под ключ»</h2>
                <p>Мы гордимся тем, что мы первые производители аналитического оборудования в стране, предлагая
                    инновационные решения.</p>
            </li>
            <li class="about-hero__item">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#about-4') }}"/>
                </svg>
                <h2>Собственное производство аналитических систем</h2>
                <p>Наше собственное производство под брендом RAPS гарантирует высокое качество и индивидуальный подход к
                    каждому клиенту.</p>
            </li>
        </ul>
    </section>
    <section class="about-info container">
        <div class="about-info__content">
            <div class="section-title">
                <h2>{{ $h1 }}</h2>
            </div>
            <div class="about-info__text">
                {!! $page->text !!}

                @if (Auth::check())
                    <br>
                    <a href="{{ URL::route('cp.pages.edit', ['id' => $page->id]) }}" class="editbutton">
                        Редактировать</a>
                @endif

            </div>
            <div class="about-info__images">
                <picture class="about-info__img _two-columns">
                    <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                            type="image/webp">
                    <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x"
                         alt="Raps" loading="lazy">
                </picture>
                <picture class="about-info__img">
                    <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                            type="image/webp">
                    <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x"
                         alt="Raps" loading="lazy">
                </picture>
                <picture class="about-info__img">
                    <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                            type="image/webp">
                    <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x"
                         alt="Raps" loading="lazy">
                </picture>
            </div>

            <a href="{{ URL::route('frontend.application') }}" class="btn btn-primary about-info__btn">Оформить
                заявку</a>

        </div>
        <div class="about-info__images">
            <picture class="about-info__img _two-columns">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                        type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps"
                     loading="lazy">
            </picture>
            <picture class="about-info__img">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                        type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps"
                     loading="lazy">
            </picture>
            <picture class="about-info__img">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x"
                        type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps"
                     loading="lazy">
            </picture>
        </div>
    </section>

    @include('frontend._partners')

@endsection

@section('js')


@endsection
