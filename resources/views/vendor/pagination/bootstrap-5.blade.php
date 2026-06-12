@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <span class="pg-btn pg-disabled">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pg-btn">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pg-btn pg-dots">···</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pg-btn pg-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pg-btn">→</a>
        @else
            <span class="pg-btn pg-disabled">→</span>
        @endif
    </div>
@endif