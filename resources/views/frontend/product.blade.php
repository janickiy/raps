@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')


@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ URL::route('frontend.index') }}">Главная</a></li>
        <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        <li><a href="{{ URL::route('frontend.catalog') }}">Контроль концентрации газов в технологических процессах</a></li>
    </ul>
    <section class="product">
        <div class="main-title container">
            <h1>{{ $title }}</h1>
        </div>
        <ul class="product__inner-links container">
            <li>
                <a href="#description">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#description') }}"/>
                    </svg>
                    Описание
                </a>
            </li>
            <li>
                <a href="#characteristics">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#border-al') }}l"/>
                    </svg>
                    Характеристики
                </a>
            </li>
            <li>
                <a href="#documents">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#document') }}"/>
                    </svg>
                    Документы
                </a>
            </li>
            <li>
                <a href="#questions">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#question') }}"/>
                    </svg>
                    Вопрос-ответ
                </a>
            </li>
        </ul>
        <div class="product__main container">
            <div class="product__gallery">
                <div class="swiper product__main-slider">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <picture class="product__img-main">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>

                        <div class="swiper-slide">
                            <picture class="product__img-main">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                        <div class="swiper-slide">
                            <picture class="product__img-main">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                        <div class="swiper-slide">
                            <picture class="product__img-main">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="swiper product__thumbs-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <picture class="product__img-thumb">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                        <div class="swiper-slide">
                            <picture class="product__img-thumb">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                        <div class="swiper-slide">
                            <picture class="product__img-thumb">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                        <div class="swiper-slide">
                            <picture class="product__img-thumb">
                                <source
                                    srcset="./images/product.webp, ./images/product@2x.webp 2x"
                                    type="image/webp">
                                <img
                                    src="./images/product.jpg"
                                    srcset="./images/product@2x.jpg 2x"
                                    alt="Газоанализатор SPTr-GAS® ANALYZER: Фотоакустический анализатор">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product__main-info">
                <p>{{ $product->description }}</p>
                <ul class="product__main-list">
                    <li class="product__main-item">
                    <span  class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#developer-guide') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Товар <a href="#">сертифицирован</a> и имеет проверку Узстандарт</span>
                    </li>
                    <li class="product__main-item">
                    <span  class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#verified') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Гарантия завода, соответствие ГОСТ и&nbsp;ТУ</span>
                    </li>
                    <li class="product__main-item">
                    <span  class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#swap-horizontal') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Политика импортозамещения</span>
                    </li>
                    <li class="product__main-item">
                    <span  class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#delivery') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Доставка по всему Узбекистану</span>
                    </li>
                    <li class="product__main-item">
                    <span  class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#directions-run') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Возможен самовывоз по&nbsp;адресу Мукими 178</span>
                    </li>
                    <li class="product__main-item">
                    <span  class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#savings') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Бесплатная доставка до&nbsp;ТК</span>
                    </li>
                </ul>
            </div>
            <div class="product__buy">
                <span class="product__buy-price">от 1 000 000 сўм</span>
                <button type="button" class="btn btn-secondary product__buy-btn" data-modal="requestModal">Рассчитать заказ</button>
                <span class="product__buy-desc">Точные цены уточняйте у менеджера</span>
            </div>
        </div>
        <div class="container">
            <section id="description" class="product__section _part">
                <div class="section-title">
                    <h2>Описание</h2>
                </div>
                <p class="product__text">{{ $product->full_description }}</p>
                <div class="product__subtitle">
                    <h3>Ключевые особенности</h3>
                </div>
                <ul class="product__list">
                    <li>Взрывозащищенное исполнение Ex d II CT6 Gb.</li>
                    <li>Определение содержания нескольких газов, включая CO, CO, SO, NO, NO2, N2O, CXHY, H, O2 и другие промышленные газы.</li>
                    <li>Различные технологии для выполнения измерения, такие как фотоакустический, технология NDIR, технология NDUV, парамагнитная технология для определения содержания кислорода и TCD детектор по теплопроводности.</li>
                    <li>Сенсорный экран 5,6", на котором концентрация газа может отображаться в виде графика, значения и таблицы.</li>
                    <li>Внутреннее программное обеспечение выполняет калибровку по нулевой точке, калибровочной точке и дополнительной точке, что обеспечивает идеальную линейность измеренных значений.</li>
                    <li>Интуитивно понятное меню обеспечивает удобство использования для полевого персонала.</li>
                    <li>Большое разнообразие выходных сигналов позволяет использовать анализатор для различных целей.</li>
                </ul>
            </section>

            <section id="characteristics" class="product__section _part">
                <div class="section-title">
                    <h2>Характеристики</h2>
                </div>
                <div class="product__table-title">
                    <h3>Основные</h3>
                </div>
                <dl class="product__table">

                    @foreach($product->parameterByCategoryId(0) as $row)

                        <div class="product__table-row">
                            <dt>{{ $row->name }}</dt>
                            <dd>{{ $row->value }}</dd>
                        </div>

                    @endforeach

                </dl>

                @foreach($productParametersCategory as $categoryRow)

                    <div class="product__table-title">
                        <h3>{{ $categoryRow->name }}</h3>
                    </div>
                    <dl class="product__table">

                        @foreach($product->parameterByCategoryId($categoryRow->id) as $row)

                        <div class="product__table-row">
                            <dt>{{ $row->name }}</dt>
                            <dd>{{ $row->value }}</dd>
                        </div>

                        @endforeach

                    </dl>

                @endforeach

            </section>

            <section id="documents" class="product__section _part">
                <div class="section-title">
                    <h2>Документы</h2>
                    <div class="product__download-btns">
                        <a href="./images/certificate-img.jpg" class="btn product__download-btn" download>
                        <span class="product__download-icon">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#download"/>
                            </svg>
                        </span>
                            <span class="product__download-info">
                            <span class="product__download-title">SIGAS.pdf</span>
                            <span class="product__download-desc">Подробная документация с таблицами и чертежами</span>
                        </span>
                        </a>
                        <a href="./images/certificate-img.jpg" class="btn product__download-btn" download>
                        <span class="product__download-icon">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#download"/>
                            </svg>
                        </span>
                            <span class="product__download-info">
                            <span class="product__download-title">SIGAS.pdf</span>
                            <span class="product__download-desc">Подробная документация с таблицами и чертежами</span>
                        </span>
                        </a>
                    </div>
                </div>
            </section>
            <section id="questions" class="product__section">
                <div class="section-title">
                    <h2>Вопрос-ответ</h2>
                </div>
                <p class="product__accordions-desc">Если вы не нашли ответа на свой вопрос, вы можете <a href="./contacts.html">связаться с нами</a> удобным для вас способом.</p>
                <div class="product__accordions">
                    <div class="product__accordions-item">
                        <input id="ac-1" name="accordion-1" type="checkbox">
                        <label for="ac-1">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#plus"/>
                            </svg>
                            Как часто необходимо проводить калибровку (градуировку) газоанализаторов ГАНК-4 при ежедневной работе этого прибора?
                        </label>
                        <div class="product__accordions-content">
                            <div class="product__accordions-content-wrap">
                                <p>При работе с ГАНК-4 нет такой необходимости ежедневно проводить градуировку. Согласно методики МВИ-4215-002-56591409-2009, раздел 10 п.4, указано, что проверка стабильности градуировочной характеристики выполняется 1 раз в 6 месяцев. В новой редакции документа МВИ рекомендованный интервал между градуировками 1 раз в год при положительных результатах контроля качества (актуальность новой методики можно проверить на сайте ФГИС «АРШИН»).</p>
                            </div>
                        </div>
                    </div>
                    <div class="product__accordions-item">
                        <input id="ac-2" name="accordion-2" type="checkbox">
                        <label for="ac-2">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#plus"/>
                            </svg>
                            Как часто необходимо проводить калибровку (градуировку) газоанализаторов ГАНК-4 при ежедневной работе этого прибора?
                        </label>
                        <div class="product__accordions-content">
                            <div class="product__accordions-content-wrap">
                                <p>При работе с ГАНК-4 нет такой необходимости ежедневно проводить градуировку. Согласно методики МВИ-4215-002-56591409-2009, раздел 10 п.4, указано, что проверка стабильности градуировочной характеристики выполняется 1 раз в 6 месяцев. В новой редакции документа МВИ рекомендованный интервал между градуировками 1 раз в год при положительных результатах контроля качества (актуальность новой методики можно проверить на сайте ФГИС «АРШИН»).</p>
                            </div>
                        </div>
                    </div>
                    <div class="product__accordions-item">
                        <input id="ac-3" name="accordion-3" type="checkbox">
                        <label for="ac-3">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#plus"/>
                            </svg>
                            Как часто необходимо проводить калибровку (градуировку) газоанализаторов ГАНК-4 при ежедневной работе этого прибора?
                        </label>
                        <div class="product__accordions-content">
                            <div class="product__accordions-content-wrap">
                                <p>При работе с ГАНК-4 нет такой необходимости ежедневно проводить градуировку. Согласно методики МВИ-4215-002-56591409-2009, раздел 10 п.4, указано, что проверка стабильности градуировочной характеристики выполняется 1 раз в 6 месяцев. В новой редакции документа МВИ рекомендованный интервал между градуировками 1 раз в год при положительных результатах контроля качества (актуальность новой методики можно проверить на сайте ФГИС «АРШИН»).</p>
                            </div>
                        </div>
                    </div>
                    <div class="product__accordions-item">
                        <input id="ac-4" name="accordion-4" type="checkbox">
                        <label for="ac-4">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#plus"/>
                            </svg>
                            Как часто необходимо проводить калибровку (градуировку) газоанализаторов ГАНК-4 при ежедневной работе этого прибора?
                        </label>
                        <div class="product__accordions-content">
                            <div class="product__accordions-content-wrap">
                                <p>При работе с ГАНК-4 нет такой необходимости ежедневно проводить градуировку. Согласно методики МВИ-4215-002-56591409-2009, раздел 10 п.4, указано, что проверка стабильности градуировочной характеристики выполняется 1 раз в 6 месяцев. В новой редакции документа МВИ рекомендованный интервал между градуировками 1 раз в год при положительных результатах контроля качества (актуальность новой методики можно проверить на сайте ФГИС «АРШИН»).</p>
                            </div>
                        </div>
                    </div>
                    <div class="product__accordions-item">
                        <input id="ac-5" name="accordion-5" type="checkbox">
                        <label for="ac-5">
                            <svg aria-hidden="true">
                                <use xlink:href="./images/sprite.svg#plus"/>
                            </svg>
                            Как часто необходимо проводить калибровку (градуировку) газоанализаторов ГАНК-4 при ежедневной работе этого прибора?
                        </label>
                        <div class="product__accordions-content">
                            <div class="product__accordions-content-wrap">
                                <p>При работе с ГАНК-4 нет такой необходимости ежедневно проводить градуировку. Согласно методики МВИ-4215-002-56591409-2009, раздел 10 п.4, указано, что проверка стабильности градуировочной характеристики выполняется 1 раз в 6 месяцев. В новой редакции документа МВИ рекомендованный интервал между градуировками 1 раз в год при положительных результатах контроля качества (актуальность новой методики можно проверить на сайте ФГИС «АРШИН»).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
                    <a href="#" class="btn btn-primary card__btn">
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
                    <a href="#" class="btn btn-primary card__btn">
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
