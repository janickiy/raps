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
            {!! $page->text !!}
        </div>
        <picture class="hero__img">
            <source srcset="{{ url('/images/hero-img.webp') }}, {{ url('/images/hero-img@2x.webp') }} 2x" type="image/webp">
            <img src="{{ url('/images/hero-img.png') }}" srcset="{{ url('/images/hero-img@2x.png') }} 2x" alt="Raps" loading="lazy">
        </picture>
    </section>

    <section class="equipment">
        <div class="container">
            <div class="section-title _center">
                <h2>Оборудование</h2>
            </div>
            <p class="section-desc equipment__desc">Наше оборудование отвечает самым строгим стандартам и обладает долговечностью и надежностью, гарантируя точность и надежность каждого измерения.</p>
            <div class="equipment__cards">

                @foreach($catalogs as $catalog)

                <article class="card">
                    <picture class="card__img ">
                        <img src="{{ url($catalog->getImage()) }}" srcset="{{ url($catalog->getImage('2x_')) }}" alt="{{ $catalog->image_alt }}" title="{{ $catalog->image_title ?? $catalog->name }}" loading="lazy">
                    </picture>
                    <div class="card__info">
                        <div>
                            <div>
                                <h3>{{ $catalog->name }}</h3>
                                <span class="card__count">{{ $catalog->getProductCount() }}</span>
                            </div>
                            <p class="card__desc">{{ $catalog->description }}</p>
                        </div>
                        <a href="{{ URL::route('frontend.product_listing',['slug' => $catalog->slug]) }}" class="btn btn-primary card__btn">
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
                        <p class="how-work__item-desc">Мы поможем вам выбрать наиболее подходящее оборудование из нашего широкого ассортимента.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Консультация и предложение</h3>
                        <p class="how-work__item-desc">Мы предоставим вам подробную консультацию и разработаем индивидуальное предложение, учитывая ваши требования и бюджет.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Соглашение и оформление</h3>
                        <p class="how-work__item-desc">После согласования всех деталей мы заключаем с вами соглашение и оформляем заказ.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Поставка и наладка</h3>
                        <p class="how-work__item-desc">Мы обеспечим поставку оборудования в срок и произведем его наладку на объекте.</p>
                    </div>
                </li>
                <li class="how-work__item">
                    <div>
                        <h3>Обучение и поддержка</h3>
                        <p class="how-work__item-desc">После наладки и сдачи оборудования в эксплуатацию мы обеспечим обучение вашего персонала и предоставим дальнейшую техническую поддержку.</p>
                    </div>
                </li>
                <li class="how-work__item _questions">
                    <div>
                        <h3>Остались вопросы?</h3>
                        <p class="how-work__item-desc">Возможно, мы&nbsp;уже отвечали на&nbsp;них в&nbsp;разделе <a href="#">FAQ</a>. Либо вы можете <a href="#">связаться с&nbsp;нами</a> удобным способом&nbsp;связи.</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <section class="partners">
        <div class="container">
            <div class="section-title _center">
                <h2>Наши партнеры</h2>
            </div>
            <div class="partners__brands">
                <div class="swiper partners__slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="partners__brand">
                                <picture>
                                    <source srcset="{{ url('/images/brands/sigas.webp') }}, {{ url('/images/brands/sigas@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/sigas.png') }}" srcset="{{ url('/images/brands/sigas@2x.png') }} 2x" alt="Sigas" loading="lazy">
                                </picture>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="partners__brand _metran">
                                <picture>
                                    <source srcset="{{ url('/images/brands/metran.webp') }}, {{ url('/images/brands/metran@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/metran.png') }}" srcset="{{ url('/images/brands/metran@2x.png') }} 2x" alt="Метран" loading="lazy">
                                </picture>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="partners__brand _protea">
                                <picture>
                                    <source srcset="{{ url('/images/brands/protea.webp') }}, {{ url('/images/brands/protea@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/protea.png') }}" srcset="{{ url('/images/brands/protea@2x.png') }} 2x" alt="Protea" loading="lazy">
                                </picture>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="partners__brand">
                                <picture>
                                    <source srcset="{{ url('/images/brands/raps.webp') }}, {{ url('/images/brands/raps@2x.webp') }} 2x" type="image/webp">
                                    <img src="{{ url('/images/brands/raps.png') }}" srcset="{{ url('/images/brands/raps@2x.png') }} 2x" alt="Protea" loading="lazy">
                                </picture>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-left') }}"/>
                    </svg>
                </div>
                <div class="swiper-button-next">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')



@endsection
