@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <section class="hero container">
        <div class="hero__info section-desc content__hero-desc">
            <div class="main-title">
                <h1>{{ $h1 }}</h1>
            </div>
            <div class="content_text">
                {!! $page->text !!}
                @if (Auth::check())
                    <br>
                    <a href="{{ URL::route('cp.pages.edit', ['id' => $page->id]) }}" class="editbutton">
                        Редактировать</a>
                @endif
            </div>
        </div>
        <picture class="hero__img">
            <img src="{{ url($page->getImage()) }}" srcset="{{ url($page->getImage('2x_')) }} 2x" alt="Raps"
                 loading="lazy">
        </picture>
    </section>

    <section class="equipment">
        <div class="container">
            <div class="section-title _center">
                <h2>Оборудование</h2>
            </div>
            <p class="section-desc equipment__desc">Наше оборудование отвечает самым строгим стандартам и обладает
                долговечностью и надежностью, гарантируя точность и надежность каждого измерения.</p>
            <div class="equipment__cards">

                @foreach($catalogs as $catalog)

                        <article class="card">
                            <picture class="card__img ">
                                <img src="{{ url($catalog->getImage()) }}" srcset="{{ url($catalog->getImage('2x_')) }}"
                                     alt="{{ $catalog->image_alt }}"
                                     title="{{ $catalog->image_title ?? $catalog->name }}" loading="lazy">
                            </picture>
                            <div class="card__info">
                                <div>
                                    <div>
                                        <h3>{{ $catalog->name }}</h3>
                                        <span class="card__count">{{ $catalog->getProductCount() }}</span>
                                    </div>
                                    <p class="card__desc">{{ $catalog->description }}</p>
                                </div>
                                <a href="@if($catalog->hasChildren() == true){{ URL::route('frontend.catalog',['slug' => $catalog->slug]) }}@else{{ URL::route('frontend.product_listing',['slug' => $catalog->slug]) }}@endif"
                                   class="btn btn-primary card__btn">
                                    К товарам
                                    <svg aria-hidden="true">
                                        <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                                    </svg>
                                </a>
                            </div>
                        </article>

                @endforeach

            </div>
        </div>

    </section>

    <section class="how-work">
        <div class="container">
            <div class="section-title">
                <h2>Как мы работаем</h2>
            </div>
            <ul class="how-work__list">
                <li class="how-work__item">
                    <div>
                        <h3>Выбор оборудования</h3>
                        <p class="how-work__item-desc">Мы поможем вам выбрать наиболее подходящее оборудование из нашего
                            широкого ассортимента.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Консультация и предложение</h3>
                        <p class="how-work__item-desc">Мы предоставим вам подробную консультацию и разработаем
                            индивидуальное предложение, учитывая ваши требования и бюджет.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Соглашение и оформление</h3>
                        <p class="how-work__item-desc">После согласования всех деталей мы заключаем с вами соглашение и
                            оформляем заказ.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Поставка и наладка</h3>
                        <p class="how-work__item-desc">Мы обеспечим поставку оборудования в срок и произведем его
                            наладку на объекте.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Обучение и поддержка</h3>
                        <p class="how-work__item-desc">После наладки и сдачи оборудования в эксплуатацию мы обеспечим
                            обучение вашего персонала и предоставим дальнейшую техническую поддержку.</p>
                    </div>
                </li>
                <li class="how-work__item _questions">
                    <div>
                        <h3>Остались вопросы?</h3>
                        <p class="how-work__item-desc">Возможно, мы&nbsp;уже отвечали на&nbsp;них в&nbsp;разделе <a
                                href="#">FAQ</a>. Либо вы можете <a href="#">связаться с&nbsp;нами</a> удобным способом&nbsp;связи.
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    @include('frontend._partners')

@endsection

@section('js')


@endsection
