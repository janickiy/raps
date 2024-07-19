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
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="request container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <div class="request__content">
            <div class="request__content-item">
                <p>1. Скачайте и заполните нужный вам опросный лист, чтобы помочь нам подобрать оборудование для вашего
                    производства</p>
                <div class="request__download-btns">
                    <a href="{{ SettingsHelper::getSetting('BLANK_1') }}" class="btn request__download-btn" download>
                    <span class="request__download-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"/>
                        </svg>
                    </span>
                        <span class="request__download-title">Для заказа газоанализатора</span>
                    </a>
                    <a href="{{ SettingsHelper::getSetting('BLANK_2') }}" class="btn request__download-btn" download>
                    <span class="request__download-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"/>
                        </svg>
                    </span>
                        <span class="request__download-title">Для заказа системы жидкостного анализа</span>
                    </a>
                    <a href="{{ SettingsHelper::getSetting('BLANK_3') }}" class="btn request__download-btn" download>
                    <span class="request__download-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"/>
                        </svg>
                    </span>
                        <span class="request__download-title">Для заказа системы газового анализа</span>
                    </a>
                </div>
            </div>
            <div class="request__content-item">
                <p>2. После заполнения опросного листа, вам необходимо загрузить его и отправить нам. Мы изучим его и
                    свяжемся с вами в ближайшее время с ответом</p>
                <h2 class="sr-only">Форма загрузки опросного листа</h2>

                {!! Form::open(['method' => 'post', 'url' => route('frontend.send.application'), 'files' => true, 'id' => "requestForm", 'class' => "request-form", "autocomplete" => "off"]) !!}

                {!! Form::hidden('type', 1) !!}

                    <div class="request-form__input-file">
                        <input id="requestFile" type="file" name="attachment">
                        <label for="requestFile">
                            <span
                                class="request-form__label-title js-request-label-title">Загрузить опросный лист</span>
                            <span
                                class="request-form__label-desc">Перетащите документ сюда, либо выберите вручную</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary request-form__btn">Отправить заявку</button>

                {!! Form::close() !!}

            </div>
        </div>
    </section>

@endsection

@section('js')


@endsection
