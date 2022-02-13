
<div>
    @if ($paginator->hasPages())
        <div class="paginating-container pagination-default">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li  class="prev"><a >قبلی</a></li>
                @else
                    <li  class="prev"><a href="" class="cursor-pointer" id="prev" wire:click.prevent="previousPage" wire:loading.attr="disabled" rel="prev">قبلی</a></li>
                @endif

                @foreach ($elements as $element)
                    @if(is_array($element))
                        @foreach ($element as $page => $url)
                            @if($paginator->currentPage() -1 == $page || $paginator->currentPage() +1 == $page || $paginator->currentPage() == $page)
                            <li class="{{$paginator->currentPage() == $page? 'active':'' }}"><a wire:click.prevent="gotoPage({{$page}})" href="">{{$page}}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li  class="next"><a class="cursor-pointer" href="" wire:click.prevent="nextPage" wire:loading.attr="disabled" rel="next">بعدی</a></li>
                @else
                    <li id="next"  class="next"><a >بعدی</a></li>
                @endif
            </ul>
        </div>
    @endif
</div>