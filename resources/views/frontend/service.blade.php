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
        <li><a href="{{ URL::route('frontend.services_listing') }}">Услуги</a></li>
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="service container">
        <div class="main-title">
            <h1>{{ $title }}</h1>
        </div>

        <div class="content_text">

            {!! $service->full_description !!}

            @if (Auth::check())
                <a href="{{ URL::route('cp.services.edit', ['id' => $service->id]) }}" class="editbutton">
                    Редактировать</a>
            @endif

            <p class="service__questions">Остались вопросы? <a href="{{ URL::route('frontend.contact') }}">Свяжитесь с
                    нами</a> любым удобным способом</p>
        </div>
    </section>

    @if($productIds)

        @include('frontend._watched_cards')

    @endif

@endsection

@section('js')


@endsection
