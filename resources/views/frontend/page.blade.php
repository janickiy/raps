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
        <li><span>{{ $page->title }}</span></li>
    </ul>

    <section class="request container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <div class="content_text">
            <div class="content_text">

                {!! $page->text !!}

                @if (Auth::check())
                    <a href="{{ route('cp.pages.edit', ['id' => $page->id]) }}" class="editbutton"> Редактировать</a>
                @endif

            </div>
        </div>
    </section>

@endsection

@section('js')


@endsection
