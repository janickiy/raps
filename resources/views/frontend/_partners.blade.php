<section class="partners">
    <div class="container">
        <div class="section-title _center">
            <h2>Наши партнеры</h2>
        </div>
        <div class="partners__brands">
            <div class="swiper partners__slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="partners__brand">
                            <picture>
                                <source srcset="{{ url('/images/brands/sigas.webp') }}, {{ url('/images/brands/sigas@2x.webp') }} 2x" type="image/webp">
                                <img src="{{ url('/images/brands/sigas.png') }}" srcset="{{ url('/images/brands/sigas@2x.png') }} 2x" alt="Sigas" loading="lazy">
                            </picture>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="partners__brand _metran">
                            <picture>
                                <source srcset="{{ url('/images/brands/metran.webp') }}, {{ url('/images/brands/metran@2x.webp') }} 2x" type="image/webp">
                                <img src="{{ url('/images/brands/metran.png') }}" srcset="{{ url('/images/brands/metran@2x.png') }} 2x" alt="Метран" loading="lazy">
                            </picture>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="partners__brand _protea">
                            <picture>
                                <source srcset="{{ url('/images/brands/protea.webp') }}, {{ url('/images/brands/protea@2x.webp') }} 2x" type="image/webp">
                                <img src="{{ url('/images/brands/protea.png') }}" srcset="{{ url('/images/brands/protea@2x.png') }} 2x" alt="Protea" loading="lazy">
                            </picture>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="partners__brand">
                            <picture>
                                <source srcset="{{ url('/images/brands/raps.webp') }}, {{ url('/images/brands/raps@2x.webp') }} 2x" type="image/webp">
                                <img src="{{ url('/images/brands/raps.png') }}" srcset="{{ url('/images/brands/raps@2x.png') }} 2x" alt="Protea" loading="lazy">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-prev">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#arrow-left') }}"/>
                </svg>
            </div>
            <div class="swiper-button-next">
                <svg aria-hidden="true">
                    <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                </svg>
            </div>
        </div>
    </div>
</section>
