@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')


@endsection

@section('content')

    <div class="contacts">
        <div class="container container--xl">
            <div class="contacts__content">
                <div class="title1 main__title">
                    <h1>{!! $h1 !!}</h1>
                </div>
                <div class="contacts__main">
                    <div class="contacts__item">
                        <p class="contacts__item-text">{{ SettingsHelper::getSetting('ADRESS') }}</p>
                    </div>
                    <div class="contacts__item">
                        <a class="contacts__item-text" href="tel:{{ StringHelper::phone(SettingsHelper::getSetting('PHONE')) }}">{{ SettingsHelper::getSetting('PHONE') }}</a>
                    </div>
                    <div class="contacts__item ">
                        <a class="contacts__item-text" href="mailto:{{ SettingsHelper::getSetting('EMAIL') }}">{{ SettingsHelper::getSetting('EMAIL') }}</a>
                    </div>
                    <div class="contacts__item">
                        <p class="contacts__item-text">{{ SettingsHelper::getSetting('SITE_NAME') }}</p>
                    </div>
                    <div class="contacts__item">
                        <p class="contacts__item-text">ИНН: {{ SettingsHelper::getSetting('INN') }}</p>
                    </div>
                    <div class="contacts__item">
                        <div class="contacts__item-img">
                            <img src="{{ url('img/contacts-img.svg') }}" width="236" height="140" alt="">
                        </div>
                    </div>
                    <div class="contacts__item">
                        <p class="contacts__item-text">КПП: {{ SettingsHelper::getSetting('KPP') }}</p>
                    </div>
                    <div class="contacts__item">
                        <p class="contacts__item-text">ОГРН: {{ SettingsHelper::getSetting('OGRN') }}</p>
                    </div>
                </div>
                <div class="contacts__map">
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ad925cae335e97d055abc6fc86103920423ef139f8c92ccc1ed112b7f5f8e437c&amp;source=constructor"></iframe>
                </div>
            </div>
        </div>
    </div>

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
                        <a class="btn btn--black callback__btn" href="{{ route('frontend.application') }}">Оформить заявку на расчет проекта</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('js')



@endsection
