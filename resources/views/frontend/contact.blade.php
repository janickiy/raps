@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('css')


@endsection

@section('content')

    <ul class="container breadcrumbs">
        <li><a href="{{ route('frontend.index') }}">Главная</a></li>
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
                    @foreach($phones as $phone)
                        <a href="tel:{{ trim($phone) }}">{{ trim($phone) }}</a>,&nbsp;
                    @endforeach
                </dd>
            </div>
            <div class="contacts__item">
                <dt>GPS координаты</dt>
                <dd> {!! StringHelper::gooleMap(SettingsHelper::getSetting('GPS')) !!}</a></dd>
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
            {!! SettingsHelper::getSetting('MAPS_CODE') !!}
        </div>
    </section>

@endsection

@section('js')



@endsection
