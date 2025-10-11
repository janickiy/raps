@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')

    <style>
        /* Table style */
        table,th,td {
            border: 1px solid #eaeaea;
            /*! border: 1px solid rgba(51,51,51,0.1); */
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            border-width: 1px 0 0 1px;
            margin: 0 0 1.75em;
            width: 100%;
        }

        .sub {
            font-style: normal; /* Нормальное начертание */
            font-size: 0.6em; /* Размер индекса */
            vertical-align: -0.5em;

        }

    </style>

@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ route('frontend.index') }}">Главная</a></li>
        <li><a href="{{ URL::route('frontend.catalog') }}">Каталог</a></li>
        {!! $pathway !!}
        <li><a href="{{ URL::route('frontend.product', ['slug' => $product->slug]) }}">{{ $title }}</a></li>
        <li><span>Определяемые газы</span></li>
    </ul>

    <section class="product">
        <div class="main-title container">
            <h1>Определяемые газы: {{ $h1 }}</h1>
        </div>

        <div class="container">

            <table width="100%" style="margin-top:0.3cm;">
                <tbody>
                <tr>
                    <td style="padding: 35px"><strong>Наименование вещества</strong></td>
                    <td style="padding: 35px"><strong>Химическая формула</strong></td>
                    <td style="padding: 35px"><strong>Диапазон измерения</strong></td>
                </tr>

                @if($product->detected_gases)

                    @foreach($product->detected_gases ?? [] as $detected_gases)
                        <tr>
                            <td style="padding: 10px"><strong>{{ $detected_gases->name }}</strong></td>
                            <td style="padding: 10px">{!! StringHelper::subFormula($detected_gases->formula) !!}</td>
                            <td  style="padding: 10px">{{ $detected_gases->volume_fraction }}</td>
                        </tr>
                    @endforeach

                @endif

                </tbody>
            </table>

            <section id="questions" class="product__section">
                <div class="section-title">
                    <h2>Вопрос-ответ</h2>
                </div>
                <p class="product__accordions-desc">Если вы не нашли ответа на свой вопрос, вы можете <a
                        href="{{ URL::route('frontend.contact') }}">связаться с нами</a> удобным для вас способом.</p>
                <div class="product__accordions">

                    @foreach($faq ?? [] as $row)
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
