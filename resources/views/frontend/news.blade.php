@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <section class="news">
        <div class="container container--xl">
            <div class="title1 main__title">
                <h1>{!! $h1 !!}</h1>
            </div>

            <div class="news__list">

                @foreach($news as $row)

                <div class="news-item news__item">
                    <div class="news-item__content">

                        <a class="news-item__img" href="{{ route('frontend.open_news', ['slug' => $row->slug]) }}">
                            @if($row->image)
                                <img src="{{ url($row->getImage()) }}" width="351" height="275" title="{{ $row->image_title ? $row->image_title : $row->title }}" alt="{{ $row->image_alt }}">
                            @endif
                        </a>

                        <div class="news-item__main">
                            <div class="news-item__meta">
                                <span class="news-item__date">{{ date('d.m.Y', strtotime($row->created_at)) }}</span>
                                <a class="news-item__more" href="{{ route('frontend.open_news', ['slug' => $row->slug]) }}">
                                    <img src="{{ url('img/icons/arrow-right.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="title2 news-item__title">
                                <h2>
                                    <a href="{{ route('frontend.open_news', ['slug' => $row->slug]) }}">{{ $row->title }}</a>
                                </h2>
                            </div>
                            <p class="text news-item__text">{{ $row->preview }}</p>
                        </div>
                    </div>
                </div>

                @endforeach

                {{ $news->links('vendor.pagination.frontend_pagination') }}

            </div>
        </div>
    </section>

@endsection

@section('js')



@endsection
