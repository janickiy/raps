@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')


@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ route('frontend.index') }}">Главная</a></li>
        <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        {!! $pathway !!}
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="product">
        <div class="main-title container">
            <h1>{{ $h1 }}</h1>
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

                        @foreach($product->photos as $photo)
                            <div class="swiper-slide">
                                <picture class="product__img-main">
                                    <img src="{{ url($photo->getOriginUrl()) }}"
                                         srcset="{{ url($photo->getOriginUrl()) }} 2x" alt="{{ $photo->alt }}"
                                         title="{{ $photo->title ?? $product->title }}" loading="lazy">
                                </picture>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="swiper product__thumbs-slider">
                    <div class="swiper-wrapper">

                        @foreach($product->photos as $photo)
                            <div class="swiper-slide">
                                <picture class="product__img-thumb">
                                    <img
                                        src="{{ url($photo->getOriginUrl()) }}"
                                        srcset="{{ url($photo->getOriginUrl()) }} 2x"
                                        alt="{{ $photo->alt }}"
                                        title="{{ $photo->title ?? $product->title }}"
                                        loading="lazy"
                                    >
                                </picture>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="product__main-info">
                <p>{{ $product->description }}</p>
                <ul class="product__main-list">
                    <li class="product__main-item">
                    <span class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#developer-guide') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Товар сертифицирован и имеет поверку Узстандарт</span>
                    </li>
                    <li class="product__main-item">
                    <span class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#verified') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Гарантия завода, соответствие ГОСТ и&nbsp;ТУ</span>
                    </li>
                    <li class="product__main-item">
                    <span class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#swap-horizontal') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Политика импортозамещения</span>
                    </li>
                    <li class="product__main-item">
                    <span class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#delivery') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Доставка по всему Узбекистану</span>
                    </li>
                    <li class="product__main-item">
                    <span class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#directions-run') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Возможен самовывоз в г. Ташкент</span>
                    </li>
                    <li class="product__main-item">
                    <span class="product__main-item-icon">
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#savings') }}"/>
                        </svg>
                    </span>
                        <span class="product__main-item-text">Бесплатная доставка до&nbsp;ТК</span>
                    </li>
                </ul>
            </div>
            <div class="product__buy">
                @if($product->price > 0)
                    <span class="product__buy-price">от {{ $product->price }} сўм</span>
                @endif
                <button type="button" class="btn btn-secondary product__buy-btn" data-modal="requestModal">Рассчитать
                    заказ
                </button>
                <span class="product__buy-desc">Точные цены уточняйте у менеджера</span>
            </div>
        </div>
        <div class="container">
            <section id="description" class="product__section _part product__text">
                <div class="section-title">
                    <h2>Описание</h2>
                </div>
                <div class="content_text">
                    {!!  $product->full_description !!}

                    @if (Auth::check())
                        <br>
                        <a href="{{ URL::route('cp.products.edit', ['id' => $product->id]) }}" class="editbutton">
                            Редактировать</a>
                    @endif

                </div>
            </section>

            <section id="characteristics" class="product__section _part">
                <div class="section-title">
                    <h2>Характеристики</h2>
                </div>

                @if($product->parameterByCategoryId(0))

                    <div class="product__table-title">
                        <h3>Основные</h3>
                    </div>
                    <dl class="product__table">

                        <div class="product__table-row">
                            <dt><p class="product__accordions-desc">Определяемые газы</p></dt>
                            <dd><p class="product__accordions-desc"><a href="{{ route('frontend.product.detected_gases',['slug' => $product->slug]) }}">Список измеряемых компонентов</a></p></dd>
                        </div>

                        @if (Auth::check())
                            <a href="{{ route('cp.detected_gases.index', ['product_id' => $product->id]) }}"
                               class="editbutton"> Редактировать</a>
                        @endif

                        @foreach($product->parameterByCategoryId(0) as $row)
                            <div class="product__table-row">
                                <dt>{{ $row->name }}</dt>
                                <dd>{{ $row->value }}</dd>
                            </div>

                            @if (Auth::check())
                                <a href="{{ URL::route('cp.product_parameters.edit', ['id' => $row->id]) }}"
                                   class="editbutton"> Редактировать</a>
                            @endif

                        @endforeach

                    </dl>

                @endif

                @foreach($productParametersCategory as $categoryRow)

                    @if($product->parameterByCategoryId($categoryRow->id))

                        <div class="product__table-title">
                            <h3>{{ $categoryRow->name }}</h3>
                        </div>
                        <dl class="product__table">

                            @foreach($product->parameterByCategoryId($categoryRow->id) as $row)

                                <div class="product__table-row">
                                    <dt>{{ $row->name }}</dt>
                                    <dd>{{ $row->value }}</dd>
                                </div>

                                @if (Auth::check())
                                    <a href="{{ URL::route('cp.product_parameters.edit', ['id' => $row->id]) }}"
                                       class="editbutton"> Редактировать</a>
                                @endif

                            @endforeach

                        </dl>

                    @endif

                @endforeach

            </section>

            <section id="documents" class="product__section _part">
                <div class="section-title">
                    <h2>Документы</h2>

                    <div class="product__download-btns">

                        @if($product->documents)

                            @foreach($product->documents as $document)

                                <a href="{{ url($document->getDocument()) }}" class="btn product__download-btn"
                                   download>
                                    <span class="product__download-icon">
                                        <svg aria-hidden="true">
                                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"/>
                            </svg>
                        </span>
                                    <span class="product__download-info">
                            <span class="product__download-title">{{ $document->path }}</span>
                            <span class="product__download-desc">{{ $document->description }}</span>
                       </span>
                                </a>

                                @if (Auth::check())
                                    <a href="{{ URL::route('cp.product_documents.edit', ['id' => $document->id]) }}"
                                       class="editbutton"> Редактировать</a>
                                @endif

                            @endforeach
                        @else
                            <p>нет документов</p>
                        @endif

                    </div>
                </div>
            </section>

            <section id="documents" class="product__section _part">
                <div class="section-title">
                    <h2>Программное обеспечение для скачивания</h2>

                    <div class="product__download-btns">

                        @if($product->soft)

                            @foreach($product->soft as $soft)

                                <a href="{{ url($soft->getSoft()) }}" class="btn product__download-btn"
                                   download>
                                    <span class="product__download-icon">
                                        <svg aria-hidden="true">
                                            <use xlink:href="{{ url('/images/sprite.svg#download') }}"/>
                            </svg>
                        </span>
                                    <span class="product__download-info">
                            <span class="product__download-title">{{ $soft->path }}</span>
                            <span class="product__download-desc">{{ $soft->description }}</span>
                       </span>
                                </a>

                                @if (Auth::check())
                                    <a href="{{ URL::route('cp.product_documents.edit', ['id' => $soft->id]) }}"
                                       class="editbutton"> Редактировать</a>
                                @endif

                            @endforeach
                        @else
                            <p>нет файлов для скачивания</p>
                        @endif

                    </div>
                </div>
            </section>

            <section id="questions" class="product__section">
                <div class="section-title">
                    <h2>Вопрос-ответ</h2>
                </div>
                <p class="product__accordions-desc">Если вы не нашли ответа на свой вопрос, вы можете <a
                        href="{{ URL::route('frontend.contact') }}">связаться с нами</a> удобным для вас способом.</p>
                <div class="product__accordions">

                    @foreach($faq as $row)
                        <div class="product__accordions-item">
                            <input id="ac-{{ $row->id }}" name="accordion-{{ $row->id }}" type="checkbox">
                            <label for="ac-{{ $row->id }}">
                                <svg aria-hidden="true">
                                    <use xlink:href="{{ url('/images/sprite.svg#plus') }}"/>
                                </svg>
                                {{ $row->question }}
                            </label>
                            <div class="product__accordions-content">
                                <div class="product__accordions-content-wrap">
                                    <p>{{ $row->answer }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </section>
        </div>
    </section>

    @if($productIds)

        @include('frontend._watched_cards')

    @endif

@endsection

@section('js')


@endsection
