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
        @if($slug)
            <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        @endif
        {!! $pathway !!}
        <li><span>{{ $title }}</span></li>
    </ul>

    @if($slug)

        <section class="products">
            <div class="main-title container">
                <h1>{{ $title }}</h1>
                @if($catalog)
                    <span class="main-title__count">{{ $catalog->getTotalProductCount() }}</span>
                @endif

                @if(!empty($catalog->description))
                    <p style="margin-top: 1.6rem">{{ $catalog->description }}</p>
                @endif

            </div>

            <ul class="products__badges container">

                @foreach(\App\Models\Catalog::orderBy('name')->where('parent_id', $catalog->id)->get() as $row)

                    <li class="products__badges-item" style="margin-top: 1.6rem">
                        <a href="{{ URL::route('frontend.catalog',['slug' => $row->slug]) }}">
                            <button>{{ $row->name }}<span>{{ $row->getTotalProductCount() }}</span></button>
                        </a>

                        @if (Auth::check())
                            <a href="{{ URL::route('cp.catalog.edit', ['id' => $row->id]) }}" class="editbutton">
                                Редактировать</a>
                        @endif

                    </li>

                @endforeach

            </ul>

            <div class="products__list container">

                @if($catalog->getTotalProductCount() === 0)
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
    @else
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
                                 alt="{{ $row->image_alt }}" title="{{ $row->image_title ?? $row->name }}"
                                 loading="lazy">
                        </picture>
                        <div class="card__info">
                            <div>
                                <div>
                                    <h3>{{ $row->name }}</h3>
                                    <span class="card__count">{{ $row->getTotalProductCount() }}</span>
                                </div>
                                <p class="card__desc">{{ $row->description }}</p>
                            </div>
                            <a href="{{ URL::route('frontend.catalog',['slug' => $row->slug]) }}"
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
    @endif

    @if($productIds)

        @include('frontend._watched_cards')

    @endif

@endsection

@section('js')


@endsection
