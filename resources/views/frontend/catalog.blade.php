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
        <li><span>Каталог</span></li>
    </ul>

    <section class="catalog container">
        <div class="main-title">
            <h1>{{ $title }}</h1>
        </div>
        <div class="sr-only">
            <h2>Категории товаров</h2>
        </div>
        <div class="catalog__cards">

            @foreach($catalogs as $row)

            <article class="card">
                <picture class="card__img ">
                    <img src="{{ url($row->getImage()) }}" srcset="{{ url($row->getImage('2x_')) }}"
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

                    <a href="{{ URL::route('frontend.product_listing',['slug' => $row->slug]) }}" class="btn btn-primary card__btn">
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
                    <a href="#" class="btn btn-primary card__btn">
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
                    <a href="#" class="btn btn-primary card__btn">
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
