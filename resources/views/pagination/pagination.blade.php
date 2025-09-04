@if ($paginator->hasPages())
    <ul class="custom-pagination">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">&laquo;</li>
        @else
            <li><button wire:click="gotoPage({{ $paginator->currentPage() - 1 }})">&laquo;</button></li>
        @endif

        {{-- Pagination Elements --}}
        @php
            $total = $paginator->lastPage();
            $current = $paginator->currentPage();
            $adjacent = 2; // number of pages before/after current
            $start = max($current - $adjacent, 1);
            $end = min($current + $adjacent, $total);
        @endphp

        {{-- First Page --}}
        @if ($start > 1)
            <li><button wire:click="gotoPage(1)">1</button></li>
            @if ($start > 2)
                <li class="disabled">...</li>
            @endif
        @endif

        {{-- Page Links --}}
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current)
                <li class="active">{{ $i }}</li>
            @else
                <li><button wire:click="gotoPage({{ $i }})">{{ $i }}</button></li>
            @endif
        @endfor

        {{-- Last Page --}}
        @if ($end < $total)
            @if ($end < $total - 1)
                <li class="disabled">...</li>
            @endif
            <li><button wire:click="gotoPage({{ $total }})">{{ $total }}</button></li>
        @endif

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <li><button wire:click="gotoPage({{ $paginator->currentPage() + 1 }})">&raquo;</button></li>
        @else
            <li class="disabled">&raquo;</li>
        @endif
    </ul>
@endif
