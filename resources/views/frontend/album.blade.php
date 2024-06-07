@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

    <style>

        .inner {
            border: 0.05em;
        }

        .outer {
            border: 0.05em;
            width: 100%;
            display: flex;
            justify-content: center;
        }

    </style>

@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ URL::route('frontend.index') }}">Главная</a></li>
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="certificates container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <p class="section-desc certificates__desc">{{ $album->description }}</p>
        <div class="certificates__list">

            @foreach($album->photos as $photo)

                <article class="certificate">
                    <picture class="certificate__img">
                        <img src="{{ url($photo->getOriginUrl()) }}" srcset="{{ url($photo->getOriginUrl()) }} 2x"
                             alt="{{ $photo->alt }}"
                             loading="lazy">
                    </picture>
                    <div class="certificate__info">
                        <h2>{{ $photo->title }}</h2>
                        <p>{{ $photo->description }}</p><br>

                        <div class="outer">
                            <div class="inner">
                                <a target="_blank" class="btn service__download-btn" href="{{ url($photo->getOriginUrl()) }}">
                                    <span class="service__download-icon">
                                        <svg aria-hidden="true">
                                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"></use>
                                        </svg>
                                    </span>
                                    <span class="service__download-title">Скачать</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </article>

            @endforeach

        </div>
    </section>

@endsection

@section('js')


@endsection
