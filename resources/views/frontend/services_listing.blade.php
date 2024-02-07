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

    <section class="services container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <p class="section-desc services__desc">Одним из приоритетных направлений нашего предприятия является разработка и поставка полнофункциональных газоаналитических комплексов (шкафов) для контроля технологических процессов и параметров, мониторинга промышленных выбросов, контроля пространства воздуха рабочей зоны с проведением пусконаладочных работ.</p>
        <div class="services__cards">
            @foreach($services as $service)

                <article class="card">
                    <picture class="card__img ">
                        <img src="{{ url($service->getImage()) }}" srcset="{{ url($service->getImage('2x_')) }} 2x" title="{{ $service->image_title ?? $service->title }}" alt="{{ $service->image_alt }}" loading="lazy">
                    </picture>
                    <div class="card__info">
                        <div>
                            <div>
                                <h3>{{ $service->title }}</h3>
                            </div>
                            <p class="card__desc">{{ $service->description }}</p>
                        </div>
                        <a href="{{ URL::route('frontend.service', ['slug' => $service->slug]) }}" class="btn btn-primary card__btn">
                            Узнать больше
                            <svg aria-hidden="true">
                                <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                            </svg>
                        </a>
                    </div>
                </article>

            @endforeach
        </div>
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
                        <p class="card__desc">RAPSystem  осуществляет проектирование и комплектацию газоаналитических систем предприятий на основе промышленных стационарных газоанализаторов.</p>
                    </div>
                    <a href="./service-design.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
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
                        <p class="card__desc">Cтандартный 19-дюймовый анализатор, используемый для определения содержания нескольких газов.</p>
                    </div>
                    <a href="./product.html" class="btn btn-primary card__btn">
                        от 1 000 000 сўм
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
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
                        <p class="card__desc">Cтандартный 19-дюймовый анализатор, используемый для определения содержания нескольких газов.</p>
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
