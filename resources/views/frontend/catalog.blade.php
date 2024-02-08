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

    <section class="catalog container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <div class="sr-only">
            <h2>Категории товаров</h2>
        </div>
        <div class="catalog__cards">

            @foreach($catalogs as $row)

                <article class="card">
                    <picture class="card__img ">
                        <img src="{{ url($row->getImage()) }}" srcset="{{ url($row->getImage('2x_')) }} 2x"
                             alt="{{ $row->image_alt }}"
                             title="{{ $row->image_title ?? $row->name }}"
                             loading="lazy">
                    </picture>
                    <div class="card__info">
                        <div>

                            <div>
                                <h3>{{ $row->name }}</h3>
                                <span class="card__count">{{ $row->getProductCount() }}</span>
                            </div>
                            <p class="card__desc">{{ $row->description }}</p>
                        </div>

                        <a href="{{ URL::route('frontend.product_listing',['slug' => $row->slug]) }}"
                           class="btn btn-primary card__btn">
                            К товарам
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

        <section class="watched">
            <div class="container">
                <div class="section-title">
                    <h2>Вы смотрели</h2>
                </div>
            </div>
            <div class="watched__cards container">

                @foreach($product->productsListByIds($productIds) as $product)

                    <article class="card">
                        <picture class="card__img ">
                            <img
                                src="{{ url($product->getThumbnailUrl()) }}"
                                srcset="{{ url($product->getOriginUrl()) }} 2x"
                                alt="{{ $product->image_alt }}"
                                title="{{ $product->image_title ?? $product->title }}"
                                loading="lazy">
                        </picture>
                        <div class="card__info">
                            <div>
                                <div>
                                    <h3>{{ $product->title }}</h3>
                                </div>
                                <p class="card__desc">{{ $product->description }}</p>
                            </div>

                            <a href="{{ URL::route('frontend.product',['slug' => $product->slug]) }}"
                               class="btn btn-primary card__btn">
                                от {{ $product->price }} сўм
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                                </svg>
                            </a>

                        </div>
                    </article>

                @endforeach

            </div>
        </section>

    @endif

@endsection

@section('js')


@endsection
