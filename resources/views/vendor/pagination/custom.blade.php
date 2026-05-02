{{-- Custom SaaS Pagination - Always visible --}}
<div class="dt-pagination">
    {{-- Left: Page Info --}}
    <div class="dt-pagination-info">
        @if ($paginator->total() > 0)
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        @else
            0 data ditemukan
        @endif
    </div>

    {{-- Center: Page Numbers --}}
    <nav class="dt-pagination-nav" aria-label="Pagination">
        @if ($paginator->hasPages())
            {{-- First Page --}}
            <a href="{{ $paginator->url(1) }}"
               class="dt-page-btn {{ $paginator->onFirstPage() ? 'disabled' : '' }}"
               {{ $paginator->onFirstPage() ? 'tabindex=-1 aria-disabled=true' : '' }}
               title="Halaman Pertama">
                <i class="bx bx-chevrons-left"></i>
            </a>

            {{-- Previous Page --}}
            <a href="{{ $paginator->previousPageUrl() }}"
               class="dt-page-btn {{ $paginator->onFirstPage() ? 'disabled' : '' }}"
               {{ $paginator->onFirstPage() ? 'tabindex=-1 aria-disabled=true' : '' }}
               title="Halaman Sebelumnya">
                <i class="bx bx-chevron-left"></i>
            </a>

            {{-- Page Numbers (Hidden on mobile) --}}
            <div class="dt-page-numbers">
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);

                    if ($endPage - $startPage < 4 && $lastPage >= 5) {
                        if ($startPage == 1) {
                            $endPage = min($lastPage, 5);
                        } elseif ($endPage == $lastPage) {
                            $startPage = max(1, $lastPage - 4);
                        }
                    }
                @endphp

                @if ($startPage > 1)
                    <a href="{{ $paginator->url(1) }}" class="dt-page-btn">1</a>
                    @if ($startPage > 2)
                        <span class="dt-page-ellipsis">…</span>
                    @endif
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <a href="{{ $paginator->url($i) }}"
                       class="dt-page-btn {{ $i == $currentPage ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($endPage < $lastPage)
                    @if ($endPage < $lastPage - 1)
                        <span class="dt-page-ellipsis">…</span>
                    @endif
                    <a href="{{ $paginator->url($lastPage) }}" class="dt-page-btn">{{ $lastPage }}</a>
                @endif
            </div>

            {{-- Next Page --}}
            <a href="{{ $paginator->nextPageUrl() }}"
               class="dt-page-btn {{ !$paginator->hasMorePages() ? 'disabled' : '' }}"
               {{ !$paginator->hasMorePages() ? 'tabindex=-1 aria-disabled=true' : '' }}
               title="Halaman Berikutnya">
                <i class="bx bx-chevron-right"></i>
            </a>

            {{-- Last Page --}}
            <a href="{{ $paginator->url($paginator->lastPage()) }}"
               class="dt-page-btn {{ !$paginator->hasMorePages() ? 'disabled' : '' }}"
               {{ !$paginator->hasMorePages() ? 'tabindex=-1 aria-disabled=true' : '' }}
               title="Halaman Terakhir">
                <i class="bx bx-chevrons-right"></i>
            </a>
        @else
            {{-- Single page indicator --}}
            <span class="dt-page-btn active">1</span>
        @endif
    </nav>

    {{-- Right: Rows Per Page --}}
    <div class="dt-pagination-perpage">
        <label for="perPageSelect">Baris:</label>
        <select id="perPageSelect" class="form-select form-select-sm" onchange="changePerPage(this.value)">
            @foreach ([10, 25, 50, 100] as $size)
                <option value="{{ $size }}" {{ request('per_page', $paginator->perPage()) == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<script>
function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
