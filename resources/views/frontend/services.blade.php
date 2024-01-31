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
        <li><span>Услуги</span></li>
    </ul>

    <section class="services container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <p class="section-desc services__desc">Одним из приоритетных направлений нашего предприятия является разработка и поставка полнофункциональных газоаналитических комплексов (шкафов) для контроля технологических процессов и параметров, мониторинга промышленных выбросов, контроля пространства воздуха рабочей зоны с проведением пусконаладочных работ.</p>
        <div class="services__cards">
            <article class="card">
                <picture class="card__img ">
                    <source srcset="{{ url('/images/services/service-1.webp') }}, ./images/services/service-1@2x.webp 2x" type="image/webp">
                    <img src="./images/services/service-1.jpg" srcset="./images/services/service-1@2x.jpg 2x" alt="Разработка и производство газоаналитических систем" loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Разработка и производство газоаналитических систем</h3>

                        </div>
                        <p class="card__desc">Наша компания предлагает комплексное проектирование и разработку газоаналитических систем и газоанализаторов в соответствии с нормативами</p>
                    </div>
                    <a href="./service-development.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-2.webp, ./images/services/service-2@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-2.jpg"
                        srcset="./images/services/service-2@2x.jpg 2x"
                        alt="Проектирование газоаналитических систем"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Проектирование газоаналитических систем</h3>

                        </div>
                        <p class="card__desc">RAPSystem  осуществляет проектирование и комплектацию газоаналитических систем предприятий на основе промышленных стационарных газоанализаторов.</p>
                    </div>
                    <a href="./service-design.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-3.webp, ./images/services/service-3@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-3.jpg"
                        srcset="./images/services/service-3@2x.jpg 2x"
                        alt="Ремонт газоаналитического оборудования"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Ремонт газоаналитического оборудования</h3>

                        </div>
                        <p class="card__desc">Мы оказываем услуги по диагностике, техническому обслуживанию и ремонту газоаналитического оборудования отечественных и импортных производителей.</p>
                    </div>
                    <a href="./service-repair.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-4.webp, ./images/services/service-4@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-4.jpg"
                        srcset="./images/services/service-4@2x.jpg 2x"
                        alt="Аудит газоаналитических систем"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Аудит газоаналитических систем</h3>

                        </div>
                        <p class="card__desc">Наша компания проводит для предприятий технический аудит существующих систем обеспечения техническими газами.</p>
                    </div>
                    <a href="./service-audit.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-5.webp, ./images/services/service-5@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-5.jpg"
                        srcset="./images/services/service-5@2x.jpg 2x"
                        alt="Модернизация систем подготовки пробы"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Модернизация систем подготовки пробы</h3>

                        </div>
                        <p class="card__desc">RAPSystem предоставляет услуги для модернизации и оптимизации систем подготовки проб для предприятий.</p>
                    </div>
                    <a href="./service-modernization.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-6.webp, ./images/services/service-6@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-6.jpg"
                        srcset="./images/services/service-6@2x.jpg 2x"
                        alt="Подготовка к поверке средств измерений"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Подготовка к поверке средств измерений</h3>

                        </div>
                        <p class="card__desc">Мы оказываем услуги по подготовке средств измерений к поверке согласно методик поверок.</p>
                    </div>
                    <a href="./service-preparation.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article>
        </div>
    </section>
    <section class="watched">
        <div class="container">
            <div class="section-title">
                <h2>Вы смотрели</h2>
            </div>
        </div>
        <div class="watched__cards container">
            <article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/services/service-2.webp, ./images/services/service-2@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/services/service-2.jpg"
                        srcset="./images/services/service-2@2x.jpg 2x"
                        alt="Проектирование газоаналитических систем"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Проектирование газоаналитических систем</h3>

                        </div>
                        <p class="card__desc">RAPSystem  осуществляет проектирование и комплектацию газоаналитических систем предприятий на основе промышленных стационарных газоанализаторов.</p>
                    </div>
                    <a href="./service-design.html" class="btn btn-primary card__btn">
                        Узнать больше
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/category/category-3.webp, ./images/category/category-3@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/category/category-3.jpg"
                        srcset="./images/category/category-3@2x.jpg 2x"
                        alt="Анализатор SIGAS S200"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Анализатор SIGAS S200</h3>

                        </div>
                        <p class="card__desc">Cтандартный 19-дюймовый анализатор, используемый для определения содержания нескольких газов.</p>
                    </div>
                    <a href="./product.html" class="btn btn-primary card__btn">
                        от 1 000 000 сўм
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article><article class="card">
                <picture class="card__img ">
                    <source
                        srcset="./images/category/category-3.webp, ./images/category/category-3@2x.webp 2x"
                        type="image/webp">
                    <img
                        src="./images/category/category-3.jpg"
                        srcset="./images/category/category-3@2x.jpg 2x"
                        alt="Анализатор SIGAS S200"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>

                        <div>
                            <h3>Анализатор SIGAS S200</h3>

                        </div>
                        <p class="card__desc">Cтандартный 19-дюймовый анализатор, используемый для определения содержания нескольких газов.</p>
                    </div>
                    <a href="./product.html" class="btn btn-primary card__btn">
                        от 1 000 000 сўм
                        <svg aria-hidden="true">
                            <use xlink:href="./images/sprite.svg#arrow-right"/>
                        </svg>
                    </a>
                </div>
            </article>
        </div>
    </section>

@endsection

@section('js')


@endsection
