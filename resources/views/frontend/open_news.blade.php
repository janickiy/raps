@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <section class="news-about">
        <div class="container container--xl">
            <div class="news-about__date">{{ date('d.m.Y', strtotime($news->created_at)) }}</div>
            <div class="news-about__header">
                <div class="news-about__info">
                    <div class="title1 news-about__title">
                        <h1>{{ $news->seo_h1 ?? $title }}</h1>
                    </div>
                </div>
                <div class="news-about__img">
                    <img src="{{ url($news->getImage()) }}" width="706" height="354" title="{{ $news->image_title ? $news->image_title : $news->title }}" alt="{{ $news->image_alt }}">
                </div>
            </div>
            <div class="news-about__main">
                {!! $news->text !!}
            </div>
        </div>
    </section>

@endsection

@section('js')



@endsection
