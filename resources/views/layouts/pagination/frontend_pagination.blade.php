@if ($paginator->hasPages())

    <div class="pagination pagination--desktop news__pagination">
        <div class="pagination__list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())

            @else
                <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}">@lang('pagination.previous')</a>
            @endif

            @if($paginator->currentPage() > 4)
                <a class="pagination__link" href="{{ $paginator->url(1) }}">...</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <span class="pagination__active">{{ $i }}</span>
                    @else
                        <a class="pagination__link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                @endif
            @endforeach

            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <a class="pagination__link" href="{{ $paginator->url($paginator->lastPage()) }}">...</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}">@lang('pagination.next')</a>
            @endif
        </div>
    </div>



@endif
