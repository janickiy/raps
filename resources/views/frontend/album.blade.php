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

    <section class="certificates container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <p class="section-desc certificates__desc">{{ $album->description }}</p>
        <div class="certificates__list">

            @foreach($album->photos as $photo)

                <article class="certificate">
                    <picture class="certificate__img">
                        <img src="{{ url($photo->getOriginUrl()) }}" srcset="{{ url($photo->getOriginUrl()) }} 2x" alt="{{ $photo->alt }}"
                             loading="lazy">
                    </picture>
                    <div class="certificate__info">
                        <h2>{{ $photo->title }}</h2>
                        <p>{{ $photo->description }}</p>
                    </div>
                </article>

            @endforeach

        </div>
    </section>

@endsection

@section('js')


@endsection
