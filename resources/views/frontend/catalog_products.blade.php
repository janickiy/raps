@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <div class="model">
        <div class="container container--xl">
            <div class="model__content">
                <div class="model__main">
                    <div class="breadcrumbs model__breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <a class="breadcrumbs__link" href="{{ URL::route('frontend.catalog') }}">Оборудование</a>
                            </div>
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">{{ $catalog->name }}</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn-back model__mobile-back" href="{{ URL::route('frontend.catalog') }}">Назад</a>
                    <div class="title1 model__title">
                        {!! $catalog->description !!}
                    </div>
                    <div class="model__info">
                        <img class="model__img" src="{{ url('img/arrows.svg') }}" alt="">
                        <div class="text-content model__text">
                            <p><b>Основные области применения:</b> {{ $catalog->scope }}</p>
                        </div>
                    </div>
                </div>
                <div class="products model__products">
                    <div class="products__content">
                        <div class="products__info">
                            <div class="breadcrumbs">
                                <div class="breadcrumbs__list">
                                    <div class="breadcrumbs__item">
                                        <span class="breadcrumbs__current">Продукция {{ $catalog->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="products__list">

                            @foreach($products as $product)

                            <div class="product-card product-card--sm-column products__item products__item--col-4">
                                <a class="product-card__img" href="{{ URL::route('frontend.product', ['slug' => $product->slug]) }}">

                                    @if($product->thumbnail)

                                    <picture>
                                        <source title="{{ $product->title }}" srcset="{{ url($product->getThumbnailUrl()) }}" alt="{{ $product->image_alt }}" type="{{ StringHelper::get_mime_type($product->thumbnail) }}">
                                        <img src="{{ url($product->getThumbnailUrl()) }}" title="{{ $product->image_title ?  $product->image_title : $product->title }}" width="390" height="175" alt="{{ $product->image_alt }}">
                                    </picture>

                                    @endif

                                </a>
                                <div class="product-card__info">
                                    <h3 class="product-card__name">
                                        <a href="{{ URL::route('frontend.product', ['slug' => $product->slug]) }}">
                                            <span>{{ $product->title }}</span>
                                        </a>
                                    </h3>
                                    <p class="text product-card__text">{{ $product->description }}</p>
                                </div>
                            </div>

                            @endforeach

                            {{ $products->links('vendor.pagination.frontend_pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <a class="btn btn--black callback__btn" href="{{ URL::route('frontend.application') }}">Оформить заявку на расчет проекта</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')


@endsection
