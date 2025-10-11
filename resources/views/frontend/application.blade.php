@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <section class="app">
        <div class="container container--xl">
            <div class="app__content">
                <div class="app__main">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">{{ $title }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="title1 app__title">
                        <h1>{!! $h1 !!}</h1>
                    </div>
                    <div class="app__links">
                        <a class="app__link" href="{{ SettingsHelper::getSetting('BLANK_1') }}">Для заказа газоанализатора</a>
                        <a class="app__link" href="{{ SettingsHelper::getSetting('BLANK_2') }}">Для заказа системы жидкостного анализа</a>
                        <a class="app__link" href="{{ SettingsHelper::getSetting('BLANK_3') }}">Для заказа системы газового анализа</a>
                    </div>
                </div>
                <br>

                @include('layouts.notifications')

                {!! Form::open(['method' => 'post', 'url' => route('frontend.send.application'), 'files' => true, 'class' => "app-form app__form", "autocomplete" => "off"]) !!}

                    <div class="breadcrumbs app-form__breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Форма отправки</span>
                            </div>
                        </div>
                    </div>
                    <div class="app-form__body">
                        <div class="app-form__main">
                            <p class="text app-form__text">После заполнения опросного листа, вам необходимо загрузить его и
                                отправить нам</p>
                            <label class="file-field app-form__field">
                                <input type="file" name="attachment" class="file-field__input js-file-input" data-file-output="app-file">
                                <span class="file-field__name js-file-value" data-file-output="app-file">Выберите файл</span>
                                <span class="btn btn--black-white file-field__label">Выбрать</span>
                            </label>
                        </div>
                        <img class="app-form__img" src="{{ url('img/arrows.svg') }}" width="309" height="193" alt="">
                    </div>
                    <div class="app-form__footer">
                        <button type="submit" class="btn app-form__submit">Отправить заявку</button>
                    </div>

                {!! Form::close() !!}

            </div>
        </div>
    </section>


@endsection

@section('js')


@endsection
