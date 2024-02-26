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

                @endforeach

            @endif

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

                @foreach(\App\Models\Products::productsListByIds($productIds) as $row)

                    <article class="card">
                        <picture class="card__img ">
                            <picture class="card__img ">
                                <img
                                    src="{{ url($row->getThumbnailUrl()) }}"
                                    srcset="{{ url($row->getOriginUrl()) }} 2x"
                                    alt="{{ $row->image_alt }}"
                                    title="{{ $row->image_title ?? $row->title }}"
                                    loading="lazy">
                            </picture>
                        </picture>
                        <div class="card__info">
                            <div>
                                <div>
                                    <h3>{{ $row->title }}</h3>
                                </div>
                                <p class="card__desc">{{ $row->description }}</p>
                            </div>

                            <a href="{{ URL::route('frontend.product',['slug' => $row->slug]) }}"
                               class="btn btn-primary card__btn">
                                от {{ $row->price }} сўм
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
