@extends('layouts.frontend')

@section('title', 'not found 404')

@section('description', '')

@section('keywords', '')

@section('css')


@endsection

@section('content')

    <section class="not-found">
        <div class="container container--xl">
            <div class="not-found__content">
                <div class="breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Ошибка 404</span>
                        </div>
                    </div>
                </div>

                <div class="not-found__main">
                    <img class="not-found__img" src="{{ url('img/arrows-right.svg') }}" width="334" height="167" alt="">
                    <div class="title1 title1--big title1--lh-120 not-found__title">Страница не найдена</div>
                    <div class="text not-found__text">Похоже, такой страницы не существует. Вы можете воспользоваться меню сверху, либо
                        перейти на главную страницу сайта</div>
                    <a class="not-found__btn" href="{{ url('/') }}">Вернуться на главную</a>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('js')



@endsection
