@if ($paginator->hasPages())
<div class="pagination">
    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span class="pg-btn pg-disabled">←</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pg-btn">←</a>
    @endif

    {{-- Page Numbers --}}
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
    @endphp

    @if ($start > 1)
        <a href="{{ $paginator->url(1) }}" class="pg-btn">1</a>
        @if ($start > 2)
            <span class="pg-btn pg-dots">…</span>
        @endif
    @endif

    @for ($i = $start; $i <= $end; $i++)
        @if ($i == $current)
            <span class="pg-btn pg-active">{{ $i }}</span>
        @else
            <a href="{{ $paginator->url($i) }}" class="pg-btn">{{ $i }}</a>
        @endif
    @endfor

    @if ($end < $last)
        @if ($end < $last - 1)
            <span class="pg-btn pg-dots">…</span>
        @endif
        <a href="{{ $paginator->url($last) }}" class="pg-btn">{{ $last }}</a>
    @endif

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pg-btn">→</a>
    @else
        <span class="pg-btn pg-disabled">→</span>
    @endif
</div>
@endif
