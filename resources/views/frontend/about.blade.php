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

    <section class="about-hero container">
        <div class="about-hero__info">

            {!! SettingsHelper::getSetting('BLOCK_ABOUT') !!}

            @if (Auth::check())
                <p>
                <a href="{{ route('cp.settings.edit', ['id' =>  SettingsHelper::getId('BLOCK_ABOUT')]) }}" class="editbutton">Редактировать</a>
                </p>
            @endif
        </div>

        {!! SettingsHelper::getSetting('BLOCK_ABOUT_2') !!}

        @if (Auth::check())
            <p>
                <a href="{{ route('cp.settings.edit', ['id' =>  SettingsHelper::getId('BLOCK_ABOUT_2')]) }}" class="editbutton">Редактировать</a>
            </p>
        @endif

    </section>

    <section class="about-info container">
        <div class="about-info__content">
            <div class="section-title">
                <h2>{{ $h1 }}</h2>
            </div>
            <div class="about-info__text">
                {!! $page->text !!}

                @if (Auth::check())
                    <br>
                    <a href="{{ route('cp.pages.edit', ['id' => $page->id]) }}" class="editbutton">Редактировать</a>
                @endif

            </div>

            <div class="about-info__images">

                {!! SettingsHelper::getSetting('BLOCK_ABOUT_IMAGES') !!}

                @if (Auth::check())
                    <p>
                        <a href="{{ route('cp.settings.edit', ['id' =>  SettingsHelper::getId('BLOCK_ABOUT_IMAGES')]) }}" class="editbutton">Редактировать</a>
                    </p>
                @endif
            </div>

            <a href="{{ route('frontend.application') }}" class="btn btn-primary about-info__btn">Оформить заявку</a>

        </div>
        <div class="about-info__images">

            {!! SettingsHelper::getSetting('BLOCK_ABOUT_IMAGES') !!}

            @if (Auth::check())
                <p>
                    <a href="{{ route('cp.settings.edit', ['id' =>  SettingsHelper::getId('BLOCK_ABOUT_IMAGES')]) }}" class="editbutton">Редактировать</a>
                </p>
            @endif
        </div>
    </section>

    @include('frontend._partners')

@endsection

@section('js')


@endsection
