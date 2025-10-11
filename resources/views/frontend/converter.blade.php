@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    <section class="converter">
        <div class="container container--xl">
            <div class="converter__content">

                <div class="converter__header">
                    <div class="breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Конвертер единиц измерения концентрации</span>
                            </div>
                        </div>
                    </div>
                    <div class="title1 converter__title">
                        <h1>{!! $h1 !!}</h1>
                    </div>
                </div>

                @include('layouts.notifications')

                {!! Form::open(['method' => 'post', 'url' => route('frontend.gaz_convert'), 'class' => "convert-form converter__form", "id" => "convert-form", "autocomplete" => "off"]) !!}

                <div class="convert-form__main">
                    <div class="convert-form__item">
                        <span class="convert-form__label">Наименование вещества</span>
                        <div class="select convert-form__select">

                            {!!Form::select('gaz_id', $options, null, ['placeholder' => 'Выберите вещество...', 'class' => 'select-field', 'id' => 'gaz_id'])!!}

                        </div>
                    </div>
                    <div class="convert-form__item">
                        <span class="convert-form__label">единица измерения</span>
                        <div class="convert-form__checkboxes">
                            <label class="checkbox convert-form__checkbox">
                                <input class="checkbox__input" type="radio" value="covertFromPpm" name="convertType"
                                       checked>
                                <span class="checkbox__switch"></span>
                                <span class="checkbox__text">ppm</span>
                            </label>
                            <label class="checkbox convert-form__checkbox">
                                <input class="checkbox__input" type="radio" value="covertFromMg" name="convertType">
                                <span class="checkbox__switch"></span>
                                <span class="checkbox__text">мг/м3</span>
                            </label>
                            <label class="checkbox convert-form__checkbox">
                                <input class="checkbox__input" type="radio" value="covertFromObd" name="convertType">
                                <span class="checkbox__switch"></span>
                                <span class="checkbox__text">% об. д.</span>
                            </label>
                            <label class="checkbox convert-form__checkbox">
                                <input class="checkbox__input" type="radio" value="covertFromNkpr" name="convertType">
                                <span class="checkbox__switch"></span>
                                <span class="checkbox__text">% НКПР</span>
                            </label>
                        </div>
                    </div>
                    <div class="convert-form__item">
                        <span class="convert-form__label">Значение</span>
                        <input id="value" class="input input--num convert-form__input" type="text" name="value"
                               placeholder="0">
                    </div>
                    <div class="convert-form__footer">
                        <button type="submit" class="submit-btn btn btn--border convert-form__footer-btn">Конвертировать</button>
                        <button type="button"
                                class="reset-btn btn btn--white btn--border convert-form__footer-btn">
                            Сбросить
                        </button>
                    </div>
                </div>

                {!! Form::close() !!}

                <div class="convert-result converter__result">
                    <div class="breadcrumbs convert-result__breadcrumbs">
                        <div class="breadcrumbs__list">
                            <div class="breadcrumbs__item">
                                <span class="breadcrumbs__current">Результаты конвертации</span>
                            </div>
                        </div>
                    </div>
                    <div class="convert-result__main">
                        <div class="convert-result__item">
                            <span class="convert-result__name">ppm</span>
                            <span id="ppm" class="convert-result__value">-</span>
                        </div>
                        <div class="convert-result__item">
                            <span class="convert-result__name">мг/м3</span>
                            <span id="mmg" class="convert-result__value">-</span>
                        </div>
                        <div class="convert-result__item">
                            <span class="convert-result__name">% об. д.</span>
                            <span id="obd" class="convert-result__value">-</span>
                        </div>
                        <div class="convert-result__item">
                            <span class="convert-result__name">% НКПР</span>
                            <span id="nkpr" class="convert-result__value">-</span>
                        </div>
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
                        <a class="btn btn--black callback__btn" href="{{ route('frontend.application') }}">Оформить
                            заявку на расчет
                            проекта</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        if (!window.jQuery) {
            document.write('<script src="{!! asset('js/libs/jquery-3.2.1.min.js') !!}"><\/script>');
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        if (!window.jQuery.ui) {
            document.write('<script src="{!! asset('js/libs/jquery-ui.min.js') !!}"><\/script>');
        }
    </script>

    <script>
        $(document).ready(function () {
            $("#convert-form").on("submit", function () {

                $('.submit-btn').prop("disabled",true);

                $.ajax({
                    url: '{{ route('frontend.gaz_convert') }}',
                    method: 'post',
                    dataType: 'json',
                    data: $(this).serialize(),
                })
                .done(function (data) {
                    $('.submit-btn').prop("disabled",false);
                    $('#mmg').text(data.mg);
                    $('#ppm').text(data.ppm);
                    $('#obd').text(data.obd);
                    $('#nkpr').text(data.nkpr);
                })
                .fail(function () {
                    $('.submit-btn').prop("disabled",false);
                    alert('Произошла ошибка при отправке данных!');
                })

                return false;
            })

            $(".reset-btn").click(function () {
                $('#mmg').text('-');
                $('#ppm').text('-');
                $('#obd').text('-');
                $('#nkpr').text('-');
                $('#value').val(0);
                $('input:radio[name="convertType"][value="covertFromPpm"]').prop('checked', true);
            });
        });

    </script>

@endsection
