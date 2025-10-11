@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')


    <section class="banner banner--company banner--white">
        <div class="container">
            <div class="banner__content">
                <div class="breadcrumbs banner__breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Промышленные аналитические системы</span>
                        </div>
                    </div>
                </div>
                <div class="title1 title1--big banner__title">
                    <h1>{!! $h1 !!}</h1>
                </div>
                <div class="banner__features">
                    <div class="banner__features-list">
                        <div class="banner__feature banner__feature--col-4">
                            <p class="text banner__feature-text">Эксклюзивные представители компании <b>SIGAS
                                    Measurement
                                    Engineering Corp</b></p>
                        </div>
                        <div class="banner__feature banner__feature--col-4">
                            <p class="text banner__feature-text">Предоставление комплексных аналитических решений
                                <b>“под ключ”</b>
                            </p>
                        </div>
                        <div class="banner__feature banner__feature--col-4">
                            <p class="text banner__feature-text"><b>Собственное</b> производство аналитических
                                систем</p>
                        </div>
                    </div>
                </div>
                <div class="banner__img">
                    <picture>
                        <source srcset="{{ url('img/company-img.webp') }}" type="image/webp">
                        <source srcset="{{ url('img/company-img.png') }}" type="image/png">
                        <img src="{{ url('img/company-img.png') }}" width="1408" height="482" alt="{{ $title }}" title="{{ $title }}">
                    </picture>
                </div>
            </div>
        </div>
    </section>

    <section class="team">
        <div class="container">
            <div class="team__content">
                <div class="breadcrumbs team__breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Команда</span>
                        </div>
                    </div>
                </div>
                <div class="team__main">
                    <div class="team__img">
                        <img src="{{ url('img/circles.svg') }}" width="263" height="138" alt="">
                    </div>
                    <div class="title1 team__title">
                        <h2>Команда наших специалистов имеет <b>большой опыт внедрения и эксплуатации</b>
                            промышленного
                            измерительного
                            оборудования, а инженеры ООО “РИАС” предлагают наиболее полные решения поставленных
                            задач и обеспечивают
                            поставку аналитических систем как для сложнейших, так и для стандартных применений,
                            отвечающих лучшим
                            мировым образцам</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="direct">
        <div class="container">
            <div class="direct__content">
                <div class="breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Направление</span>
                        </div>
                    </div>
                </div>
                <div class="title1 direct__title">
                    <h2>Одним из направлений нашей компании является <b>поставка оборудования “под ключ”</b> в сфере
                        поточного
                        промышленного газового анализа, включая хроматографию и задачи контроля промышленных
                        выбросов</h2>
                </div>
                <div class="text direct__quote">Для решения данных задач мы используем высокотехнологичное
                    оборудование и
                    имеем штат сотрудников с большим опытом работы
                    в данной области
                </div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="container container--xl">
            <div class="services__content">
                <div class="breadcrumbs breadcrumbs--white services__breadcrumbs">
                    <div class="breadcrumbs__list">
                        <div class="breadcrumbs__item">
                            <span class="breadcrumbs__current">Наши услуги</span>
                        </div>
                    </div>
                </div>
                <div class="services__main">
                    <div class="title1 title1--white services__title">
                        <h2>комплексный и системный подход к поставке оборудования для
                            реализации проектов и задач, стоящих <b>перед нашими заказчиками</b></h2>
                    </div>

                    <div class="services__list-box">
                        <div class="services__list">
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Проектирование и разработка систем газового
                                        и жидкостного
                                        анализа
                                    </p>
                                </div>
                            </div>
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Пусконаладочные работы</p>
                                </div>
                            </div>
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Ремонт и техническое обслуживание
                                        газоанализаторов и
                                        газоаналитических систем</p>
                                </div>
                            </div>
                            <div class="services__item">
                                <div class="services__item-content">
                                    <p class="text services__item-text">Аудит аналитических систем</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="partners">
        <div class="container container--xl">
            <div class="partners__content">
                <div class="partners__info">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Наши партнеры</span>
                            </div>
                        </div>
                    </div>
                    <div class="title1 partners__title">
                        <h2>Мы являемся <b>дистрибьюторами и эксклюзивными
                                представителями</b> на территории РФ следующих заводов-производителей поточных
                            газовых анализаторов
                        </h2>
                    </div>
                </div>
                <div class="partners__list">
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/artgaz.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/artgaz.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/artgaz.png') }}" width="200"
                                 height="70" alt="">
                        </picture>
                    </div>
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/metran.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/metran.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/metran.png') }}" width="200"
                                 height="34" alt="">
                        </picture>
                    </div>
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/sigas.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/sigas.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/sigas.png') }}" width="200"
                                 height="48" alt="">
                        </picture>
                    </div>
                    <div class="partners__item">
                        <picture>
                            <source srcset="{{ url('img/partners/protea.webp') }}" type="image/webp">
                            <source srcset="{{ url('img/partners/protea.png') }}" type="image/png">
                            <img class="partners__item-img" src="{{ url('img/partners/protea.png') }}" width="200"
                                 height="64" alt="">
                        </picture>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="callback">
        <div class="container container--xl">
            <div class="callback__content">
                <div class="callback__main">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Заявка на расчет проекта</span>
                            </div>
                        </div>
                    </div>
                    <div class="callback__info">
                        <div class="title1 callback__title">
                            <h2>Нужна помощь с подбором? Оформите заявку</h2>
                        </div>
                        <a class="btn btn--black callback__btn" href="{{ route('frontend.application') }}">Оформить заявку на расчет
                            проекта</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')



@endsection
