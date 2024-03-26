@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')


@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ URL::route('frontend.index') }}">Главная</a></li>
        <li><span>{{ $title }}</span></li>
    </ul>

    <section class="contacts container">
        <div class="main-title">
            <h1>{{ $h1 }}</h1>
        </div>
        <dl class="contacts__list">
            <div class="contacts__item">
                <dt>Адрес</dt>
                <dd>{{ SettingsHelper::getSetting('ADRESS') }}</dd>
            </div>
            <div class="contacts__item">
                <dt>Телефон</dt>
                <dd>
                    <a href="tel:{{ SettingsHelper::getSetting('PHONE') }}">{{ SettingsHelper::getSetting('PHONE') }}</a>
                </dd>
            </div>
            <div class="contacts__item">
                <dt>E-mail</dt>
                <dd>{{ SettingsHelper::getSetting('EMAIL') }}</dd>
            </div>
            <div class="contacts__item">
                <dt>ИНН</dt>
                <dd>{{ SettingsHelper::getSetting('INN') }}</dd>
            </div>
            <div class="contacts__item">
                <dt>КПП</dt>
                <dd>{{ SettingsHelper::getSetting('KPP') }}</dd>
            </div>
            <div class="contacts__item">
                <dt>ОГРН</dt>
                <dd>{{ SettingsHelper::getSetting('OGRN') }}</dd>
            </div>
        </dl>
        <div class="contacts__map">
            <div class="sr-only">
                <h2>Карта</h2>
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1497.0227790972829!2d69.2416803!3d41.3730949!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8da28d84b6ed%3A0xe50e2b8ce7d5bb53!2z0J7QntCeIMKrUkFQU1lTVEVNwrs!5e0!3m2!1sru!2sru!4v1711363938521!5m2!1sru!2sru"
                width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

@endsection

@section('js')



@endsection
