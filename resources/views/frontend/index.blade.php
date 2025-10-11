@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <section class="banner banner--index">
        <div class="container">
            <div class="banner__content">
                <div class="breadcrumbs breadcrumbs--white banner__breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Промышленные аналитические системы</span>
                        </div>
                    </div>
                </div>
                <div class="title1 title1--white title1--lh-120 banner__title">
                    <h1>Проектируем, производим и поставляем
                        газоаналитические системы,
                        предназначенные для контроля технологических процессов</h1>
                </div>
                <div class="banner__features banner__features--indent">
                    <div class="banner__features-list">
                        <div class="banner__feature banner__feature--vertical">
                            <p class="text banner__feature-text">Эксклюзивные представители компании SIGAS Measurement Engineering
                                Corp</p>
                        </div>
                        <div class="banner__feature banner__feature--vertical">
                            <p class="text banner__feature-text">Предоставление комплексных аналитических решений “под&nbsp;ключ”
                            </p>
                        </div>
                        <div class="banner__feature banner__feature--vertical">
                            <p class="text banner__feature-text">Собственное производство аналитических систем</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="partners">
        <div class="container container--xl">
            <div class="partners__content">
                <div class="partners__info">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Наши партнеры</span>
                            </div>
                        </div>
                    </div>
                    <div class="title1 partners__title">
                        <h2>Мы являемся <b>дистрибьюторами и эксклюзивными
                                представителями</b> на территории РФ следующих заводов-производителей поточных газовых анализаторов
                        </h2>
                    </div>
                </div>
                <div class="partners__list">
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/artgaz.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/artgaz.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/artgaz.png') }}" width="200" height="70" alt="">
                        </picture>
                    </div>
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/metran.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/metran.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/metran.png') }}" width="200" height="34" alt="">
                        </picture>
                    </div>
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/sigas.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/sigas.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/sigas.png') }}" width="200" height="48" alt="">
                        </picture>
                    </div>
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/protea.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/protea.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/protea.png') }}" width="200" height="64" alt="">
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container container--xl">
            <div class="services__content">
                <div class="breadcrumbs breadcrumbs--white services__breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Наши услуги</span>
                        </div>
                    </div>
                </div>
                <div class="services__main">
                    <div class="title1 title1--white services__title">
                        <h2>комплексный и системный подход к поставке оборудования для
                            реализации проектов и задач, стоящих <b>перед нашими заказчиками</b></h2>
                    </div>
                    <a class="btn services__btn" href="services.html">Подробнее о производстве</a>
                    <div class="services__list-box">
                        <div class="services__list">
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Проектирование и разработка систем газового и жидкостного
                                        анализа
                                    </p>
                                </div>
                            </div>
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Пусконаладочные работы</p>
                                </div>
                            </div>
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Ремонт и техническое обслуживание газоанализаторов и
                                        газоаналитических систем</p>
                                </div>
                            </div>
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Аудит аналитических систем</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products">
        <div class="container container--xl">
            <div class="products__content">
                <div class="products__info">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Популярное оборудование</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="products__list">

                    @foreach($products as $product)

                    <div class="product-card products__item">
                        <div class="product-card__img">
                            <picture>
                                <source srcset="{{ url($product->getThumbnailUrl()) }}" type="{{ StringHelper::get_mime_type($product->thumbnail) }}">
                                <img src="{{ url($product->getThumbnailUrl()) }}" width="234" height="218" alt="{{ $product->image_alt }}" title="{{ $product->image_title }}">
                            </picture>
                        </div>
                        <div class="product-card__info">
                            <h3 class="product-card__name">
                                <a href="{{ route('frontend.product', ['slug' => $product->slug]) }}">
                                    <span>{{ $product->title }}</span>
                                </a>
                            </h3>
                        </div>
                    </div>

                    @endforeach

                    <div class="product-card products__item">
                        <a class="product-card__more" href="{{ route('frontend.catalog') }}">
                            <div class="product-card__more-img">
                                <img src="{{ url('img/arrows-right.svg') }}" width="152" height="76" alt="">
                            </div>
                            <span class="product-card__more-text">Смотреть все оборудование</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="callback">
        <div class="container container--xl">
            <div class="callback__content">
                <div class="callback__main">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Заявка на расчет проекта</span>
                            </div>
                        </div>
                    </div>
                    <div class="callback__info">
                        <div class="title1 callback__title">
                            <h2>Нужна помощь с подбором? Оформите заявку</h2>
                        </div>
                        <a class="btn btn--black callback__btn" href="{{ route('frontend.application') }}">Оформить заявку на расчет проекта</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')



@endsection
