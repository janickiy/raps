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
        <li><a href="{{ URL::route('frontend.services_listing') }}">Услуги</a></li>
        <li><span>{{ $title }}</span></li>
    </ul>


    <section class="service container">

        {!! $service->full_description !!}

        <p class="service__questions">Остались вопросы? <a href="{{ URL::route('frontend.contact') }}">Свяжитесь с нами</a> любым удобным способом</p>

    </section>

    <section class="watched">
        <div class="container">
            <div class="section-title">
                <h2>Вы смотрели</h2>
            </div>
        </div>
        <div class="watched__cards container">
            <article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-2.webp, ./images/services/service-2@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-2.jpg"
                        srcset="./images/services/service-2@2x.jpg 2x"
                        alt="Проектирование газоаналитических систем"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Проектирование газоаналитических систем</h3>

                        </div>
                        <p class="card__desc">RAPSystem осуществляет проектирование и комплектацию газоаналитических
                            систем предприятий на основе промышленных стационарных газоанализаторов.</p>
                    </div>
                    <a href="./service-design.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article>
            <article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/category/category-3.webp, ./images/category/category-3@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/category/category-3.jpg"
                        srcset="./images/category/category-3@2x.jpg 2x"
                        alt="Анализатор SIGAS S200"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Анализатор SIGAS S200</h3>

                        </div>
                        <p class="card__desc">Cтандартный 19-дюймовый анализатор, используемый для определения
                            содержания нескольких газов.</p>
                    </div>
                    <a href="./product.html" class="btn btn-primary card__btn">
                        от 1 000 000 сўм
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article>
            <article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/category/category-3.webp, ./images/category/category-3@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/category/category-3.jpg"
                        srcset="./images/category/category-3@2x.jpg 2x"
                        alt="Анализатор SIGAS S200"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Анализатор SIGAS S200</h3>

                        </div>
                        <p class="card__desc">Cтандартный 19-дюймовый анализатор, используемый для определения
                            содержания нескольких газов.</p>
                    </div>
                    <a href="./product.html" class="btn btn-primary card__btn">
                        от 1 000 000 сўм
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article>
        </div>
    </section>

@endsection

@section('js')


@endsection
