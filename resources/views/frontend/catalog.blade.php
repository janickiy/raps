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
        @if($slug)
            <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        @endif
        {!! $pathway !!}
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="catalog container">
        <div class="main-title">
            <h1>{{ $title }}</h1>
            <span class="main-title__count">{{ $products->count() }}</span>
        </div>
        <div class="sr-only">
            <h2>Категории товаров</h2>
        </div>
        <div class="catalog__cards">

            @foreach($catalogs as $catalog)

                <article class="card">
                    <picture class="card__img ">
                        <img src="{{ url($catalog->getImage()) }}" srcset="{{ url($catalog->getImage('2x_')) }} 2x"
                             alt="{{ $catalog->image_alt }}"
                             title="{{ $catalog->image_title ?? $catalog->name }}"
                             loading="lazy">
                    </picture>
                    <div class="card__info">
                        <div>
                            <div>
                                <h3>{{ $catalog->name }}</h3>
                                <span class="card__count">{{ $catalog->getProductCount() }}</span>
                            </div>
                            <p class="card__desc">{{ $catalog->description }}</p>
                        </div>

                        <a href="@if($catalog->hasChildren() == true){{ URL::route('frontend.catalog',['slug' => $catalog->slug]) }}@else{{ URL::route('frontend.product_listing',['slug' => $catalog->slug]) }}@endif"
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

    @if($slug)

        <section class="products">

            <div class="products__list container">

                @foreach($products->get() as $product)

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

            </div>
        </section>

    @endif

    @if($productIds)

        <section class="watched">
            <div class="container">
                <div class="section-title">
                    <h2>Вы смотрели</h2>
                </div>
            </div>
            <div class="watched__cards container">

                @foreach(\App\Models\Products::productsListByIds($productIds) as $product)

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
