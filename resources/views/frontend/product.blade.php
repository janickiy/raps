@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')


@endsection

@section('content')

    <div class="product">
        <div class="container container--xl">
            <div class="product__content">

                <div class="product__header">
                    <div class="breadcrumbs product__breadcrumbs">
                        <div class="breadcrumbs__list">

                            <div class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('frontend.catalog') }}">Оборудование</a>
                            </div>
                            <div class="breadcrumbs__item">
                                <a class="breadcrumbs__link"
                                   href="{{ route('frontend.catalog', ['slug' => $product->catalog->slug ]) }}">{{ $product->catalog->name }}</a>
                            </div>
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">{{ $product->title }}</span>
                            </div>
                        </div>
                    </div>
                    <a class="btn-back product__mobile-back" href="{{ route('frontend.catalog', ['slug' => $product->catalog->slug ]) }}">Назад</a>
                    <div class="title1 product__title">
                        <h1>{!! $h1 !!}</h1>
                    </div>
                </div>

                <div class="product__main">
                    <div class="product__sliders">
                        <div class="product__nav-wrapper">
                            <div class="product__nav-slider swiper">
                                <div class="swiper-wrapper">

                                    @foreach($product->photos as $photo)
                                        <div class="swiper-slide product__nav-slide">
                                            <picture>
                                                <source title="{{ $photo->title }}" alt="{{ $photo->alt }}" srcset="{{ url($photo->getThumbnailUrl()) }}"
                                                        type="{{ StringHelper::get_mime_type($photo->thumbnail) }}">
                                                <img src="{{ url($photo->getThumbnailUrl()) }}" title="{{ $photo->title }}" alt="{{ $photo->alt }}" width="48"
                                                     height="52">
                                            </picture>
                                        </div>
                                    @endforeach

                                    @foreach($product->videos as $video)
                                        <div class="swiper-slide product__nav-slide product__nav-slide--video">
                                            <picture>
                                                <source srcset="{{ $video->getThumb() }}" type="{{ StringHelper::getMime($video->getThumb()) }}">
                                                <img src="{{ $video->getThumb() }}" alt="{{ $product->title }}" width="62" height="62">
                                            </picture>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="product__big-slider swiper">
                            <div class="swiper-wrapper">

                                @foreach($product->photos as $photo)
                                    <div class="swiper-slide product__big-slide">
                                        <picture>
                                            <source srcset="{{ $photo->getOriginUrl() }}" type="image/png">
                                            <img src="{{ $photo->getOriginUrl() }}" alt="{{ $photo->alt }}" title="{{ $photo->title ? $photo->title : $product->title }}" height="100%">
                                        </picture>
                                    </div>
                                @endforeach

                                @foreach($product->videos as $video)
                                    <div class="swiper-slide product__big-slide product__big-slide--video">
                                        <div class="product__big-slide-video"
                                             data-src="{{ $video->getVideoUrl() }}"></div>
                                    </div>
                                @endforeach

                            </div>
                            <button class="product__slider-prev"></button>
                            <button class="product__slider-next"></button>
                        </div>
                    </div>
                    <div class="text-content text-content--big product__excerpt">
                        <p>{{ $product->description }}</p>
                        <a class="link-more link-more--down product__excerpt-more" href="#product-tabs">Полное
                            описание</a>
                    </div>
                </div>

                <div class="tabs product__tabs" id="product-tabs">
                    <div class="tabs__btns">
                        <button class="tabs__btn tabs__btn--active">Описание</button>
                        <button class="tabs__btn">Характеристики</button>
                        <button class="tabs__btn">Документация</button>
                    </div>
                    <div class="tabs__list">
                        <div class="tabs__item tabs__item--active">
                            <div class="product__column product__column--img">
                                <div class="text-content text-content--big product__column-text">
                                    <p>{{ $product->description }}</p>
                                </div>

                                @if($product->thumbnail)
                                    <div class="product__column-img">
                                        <picture>
                                            <source srcset="{{ $product->getThumbnailUrl() }}" type="{{ StringHelper::get_mime_type($product->origin) }}">
                                            <img src="{{ $product->getThumbnailUrl() }}" alt="{{ $product->image_alt }}" width="705" title="{{ $product->image_title }}" height="348">
                                        </picture>
                                    </div>
                                @endif

                            </div>
                            <div class="product__column">
                                <div class="text-content text-content--big product__column-text">
                                    {!! $product->full_description !!}
                                </div>
                            </div>
                        </div>
                        <div class="tabs__item">
                            <div class="product__models">
                                <div class="product-model product__models-item">
                                    <div class="text-content text-content--big product-model__main">
                                        <h2>Характеристики</h2>
                                        <ul>
                                            @foreach($product->parameters as $parameter)
                                                <li>{{$parameter->name}}: {{$parameter->value}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <a class="link-more product-model__more" href="#">Матрица заказа электронного
                                        блока</a>
                                </div>
                            </div>
                        </div>
                        <div class="tabs__item">

                            <div class="product__docs">

                                @foreach($product->documents as $document)

                                    <a class="link-doc product__doc" href="{{ url($document->getDocument()) }}">
                                        <div class="link-doc__info">
                                            {{ $document->path }}
                                            <span class="text link-doc__text">{{ $document->description }}</span>
                                        </div>
                                    </a>

                                @endforeach

                            </div>
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
                        <a class="btn btn--black callback__btn" href="{{ route('frontend.application') }}">Оформить
                            заявку на расчет проекта</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('js')


@endsection
