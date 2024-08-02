@if ($paginator->hasPages())
    <!-- Pagination -->
    <div class="pagination__numbers">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a><i class="fas fa-caret-left"></i></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"><i class="fas fa-caret-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span>{{ $page }}</span>
                    @elseif ((($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() - 1) || $page == $paginator->lastPage()) && !isMobile())
                        <a href="{{ $url }}">{{ $page }}</a>
                    @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                        <a href="{{ $url }}">{{ $page }}</a>
                    @elseif ($page == $paginator->lastPage() - 1)
                        <a>...</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                <i class="fas fa-caret-right"></i>
            </a>
        @else
            <a>
                <i class="fas fa-caret-right"></i>
            </a>
        @endif
    </div>
    <!-- Pagination -->
@endif
