@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

    {!! Html::style('/css/pagination.css') !!}

@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ URL::route('frontend.index') }}">Главная</a></li>
        <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        {!! $pathway !!}
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="products">
        <div class="main-title container">
            <h1>{{ $title }}</h1>
            <span class="main-title__count">{{ $catalog->getProductCount() }}</span>
        </div>
        <div class="products__list container">

            @if($catalog->getProductCount() === 0)
                <p>нет товаров</p>
            @endif

            @foreach($products as $product)

                <article class="product-card">
                    <picture class="product-card__img">
                        <img src="{{ url($product->getThumbnailUrl()) }}"
                             srcset="{{ url($product->getOriginUrl()) }} 2x" alt="{{ $product->image_alt }}"
                             title="{{ $product->title }}" loading="lazy">
                    </picture>
                    <div class="product-card__info">
                        <div>
                            <h2>{{ $product->title }}</h2>
                            <p class="product-card__desc">{{ $product->description }}</p>

                            <dl class="product-card__points">
                                <div class="product-card__points-item">
                                    <dt>Взрывозащита:</dt>
                                    <dd>{{ $product->explosion_protection }}</dd>
                                </div>
                                <div class="product-card__points-item">
                                    <dt>Измеряемые газы:</dt>
                                    <dd>{{ $product->gases }}</dd>
                                </div>
                                <div class="product-card__points-item">
                                    <dt>Степень пылевлагозащиты:</dt>
                                    <dd>{{ $product->dust_protection }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="product-card__footer">
                            @if($product->price > 0)
                                <span class="product-card__price">от {{ $product->price }} сўм</span>
                            @endif
                            <a href="{{ URL::route('frontend.product',['slug' => $product->slug]) }}"
                               class="btn btn-primary product-card__btn">
                                К товарy
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                                </svg>
                            </a>
                        </div>

                    </div>
                </article>

                @if (Auth::check())
                    <a href="{{ URL::route('cp.products.edit', ['id' => $product->id]) }}" class="editbutton">
                        Редактировать</a>
                @endif

            @endforeach

            {{ $products->links('layouts.pagination.frontend_pagination') }}

        </div>
    </section>

    @if($productIds)

        @include('frontend._watched_cards')

    @endif

@endsection

@section('js')



@endsection
