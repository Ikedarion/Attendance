@if ($paginator->hasPages())
<nav>
    <ul class="pagination_">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page__item disabled" aria-disabled="true">
            <span class="page__link">@lang('<')</span>
        </li>
        @else
        <li class="page__item">
            <a class="page__link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('<')</a>
        </li>
        @endif

        <li class="page__item">
            <span class="attendance__heading" style="border:none">{{ \Carbon\Carbon::now()->toDateString() }}</span>
        </li>


        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page__item">
            <a class="page__link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('>')</a>
        </li>
        @else
        <li class="page__item disabled" aria-disabled="true">
            <span class="page__link">@lang('>')</span>
        </li>
        @endif
    </ul>
</nav>
@endif