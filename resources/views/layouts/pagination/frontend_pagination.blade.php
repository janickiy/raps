@if ($paginator->hasPages())

    <div class="products__pagination container">
        <div class="pagination">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())

            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-left') }}"/>
                    </svg>
                </a>
            @endif

            @if($paginator->currentPage() > 4)
                <a class="btn pagination__page-numb" href="{{ $paginator->url(1) }}">...</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <a  class="btn pagination__page-numb active">{{ $i }}</a>
                    @else
                        <a class="btn pagination__page-numb" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                @endif
            @endforeach

            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <a class="btn pagination__page-numb" href="{{ $paginator->url($paginator->lastPage()) }}">...</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn">
                    <svg aria-hidden="true">
                        <use xlink:href="{{ url('/images/sprite.svg#arrow-right') }}"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>

@endif
