@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ route('frontend.index') }}">Главная</a></li>
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="services container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <p class="section-desc services__desc">Одним из приоритетных направлений нашего предприятия является разработка
            и поставка полнофункциональных газоаналитических комплексов (шкафов) для контроля технологических процессов
            и параметров, мониторинга промышленных выбросов, контроля пространства воздуха рабочей зоны с проведением
            пусконаладочных работ.</p>
        <div class="services__cards">
            @foreach($services as $service)

                <article class="card">
                    <picture class="card__img ">
                        <img src="{{ url($service->getImage()) }}" srcset="{{ url($service->getImage('2x_')) }} 2x"
                             title="{{ $service->image_title ?? $service->title }}" alt="{{ $service->image_alt }}"
                             loading="lazy">
                    </picture>
                    <div class="card__info">
                        <div>
                            <div>
                                <h3>{{ $service->title }}</h3>
                            </div>
                            <p class="card__desc">{{ $service->description }}</p>
                        </div>
                        <a href="{{ URL::route('frontend.service', ['slug' => $service->slug]) }}"
                           class="btn btn-primary card__btn">
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

    @if($productIds)

        @include('frontend._watched_cards')

    @endif

@endsection

@section('js')


@endsection
