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
        <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="products">
        <div class="main-title container">
            <h1>{{ $title }}</h1>
            <span class="main-title__count">{{ $catalog->getProductCount() }}</span>
        </div>
        <div class="products__list container">

            @if(isset($catalog->products) && $catalog->products)

                @foreach($catalog->products as $product)

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
                                        <dd>Ex d II CT6 Gb</dd>
                                    </div>
                                    <div class="product-card__points-item">
                                        <dt>Измеряемые газы:</dt>
                                        <dd>CO, CO, SO, NO, NO2, N2O, CXHY, H, O2</dd>
                                    </div>
                                    <div class="product-card__points-item">
                                        <dt>Степень пылевлагозащиты:</dt>
                                        <dd>IP65</dd>
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

                @endforeach

            @endif

        </div>
    </section>

    @if($productId)

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
                            <picture class="card__img ">
                                <img
                                    src="{{ url($product->getThumbnailUrl()) }}"
                                    srcset="{{ url($product->getOriginUrl()) }} 2x"
                                    alt="{{ $product->image_alt }}"
                                    title="{{ $product->image_title ?? $product->title }}"
                                    loading="lazy">
                            </picture>
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
