@extends('layouts.frontend')

@section('title', 'not found 404')

@section('description', '')

@section('keywords', '')

@section('css')


@endsection

@section('content')

    <section class="error">
        <div class="error__wrapper container">
            <div class="error__info">
                <div class="error__title">
                    <h1>404</h1>
                </div>
                <p class="section-desc error__desc">Мы не можем найти запрашиваемую&nbsp;страницу.<br>Пожалуйста, проверьте URL страницы или вернитесь на Главную.</p>
                <a href="{{ URL::route('frontend.index') }}" class="btn btn-primary error__btn">
                    Перейти на Главную страницу
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                    </svg>
                </a>
            </div>
            <picture class="error__img">
                <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
                <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps">
            </picture>
        </div>
    </section>


@endsection

@section('js')



@endsection
