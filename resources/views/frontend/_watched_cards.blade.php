<section class="watched">
    <div class="container">
        <div class="section-title">
            <h2>Вы смотрели</h2>
        </div>
    </div>
    <div class="watched__cards container">

        @foreach(\App\Models\Products::productsListByIds($productIds) ?? [] as $product)

            <article class="card">
                <picture class="card__img ">
                    <img
                        src="{{ url($product->getThumbnailUrl()) }}"
                        srcset="{{ url($product->getOriginUrl()) }} 2x"
                        alt="{{ $product->image_alt }}"
                        title="{{ $product->image_title ?? $product->title }}"
                        loading="lazy">
                </picture>
                <div class="card__info">
                    <div>
                        <div>
                            <h3>{{ $product->title }}</h3>
                        </div>
                        <p class="card__desc">{{ $product->description }}</p>
                    </div>

                    <a href="{{ URL::route('frontend.product',['slug' => $product->slug]) }}"
                       class="btn btn-primary card__btn">
                        от {{ $product->price }} сўм
                        <svg aria-hidden="true">
                            <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                        </svg>
                    </a>

                </div>
            </article>

        @endforeach

    </div>
</section>
