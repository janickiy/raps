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
                <dd><a href="tel:{{ SettingsHelper::getSetting('PHONE') }}">{{ SettingsHelper::getSetting('PHONE') }}</a></dd>
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
                title="Карта с местоположением офиса RAPSystem"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2997.5346202561846!2d69.21327497624732!3d41.297231901582144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8bca872d740f%3A0xe23a9be4023e2841!2zMTc4INGD0LvQuNGG0LAg0JzRg9C60LjQvNC4LCDQotCw0YjQutC10L3Rgiwg0KPQt9Cx0LXQutC40YHRgtCw0L0!5e0!3m2!1sru!2sru!4v1701696828556!5m2!1sru!2sru"
                style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

@endsection

@section('js')



@endsection
