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

        {!! $service->full_description !!}

        @if (Auth::check())
            <a href="{{ URL::route('cp.services.edit', ['id' => $service->id]) }}" class="editbutton"> Редактировать</a>
        @endif

        <p class="service__questions">Остались вопросы? <a href="{{ URL::route('frontend.contact') }}">Свяжитесь с
                нами</a> любым удобным способом</p>

    </section>

    @if($productIds)

        <section class="watched">
            <div class="container">
                <div class="section-title">
                    <h2>Вы смотрели</h2>
                </div>
            </div>
            <div class="watched__cards container">

                @foreach(\App\Models\Products::productsListByIds($productIds) as $row)

                    <article class="card">
                        <picture class="card__img ">
                            <img
                                src="{{ url($row->getThumbnailUrl()) }}"
                                srcset="{{ url($row->getOriginUrl()) }} 2x"
                                alt="{{ $row->image_alt }}"
                                title="{{ $row->image_title ?? $row->title }}"
                                loading="lazy">
                        </picture>
                        <div class="card__info">
                            <div>
                                <div>
                                    <h3>{{ $row->title }}</h3>
                                </div>
                                <p class="card__desc">{{ $row->description }}</p>
                            </div>

                            <a href="{{ URL::route('frontend.product',['slug' => $row->slug]) }}"
                               class="btn btn-primary card__btn">
                                от {{ $row->price }} сўм
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                                </svg>
                            </a>

                        </div>
                    </article>

                @endforeach

            </div>
        </section>

    @endif

@endsection

@section('js')


@endsection
