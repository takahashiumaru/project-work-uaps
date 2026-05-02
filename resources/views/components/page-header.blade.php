{{--
    ======================================================================
    REUSABLE PAGE HEADER: <x-page-header>
    ======================================================================
    Usage:
        <x-page-header
            title="Manajemen Kontrak"
            subtitle="Monitoring masa kontrak pegawai"
            :breadcrumbs="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'User Management'],
                ['label' => 'Kontrak'],
            ]"
        />
    ======================================================================
--}}

@props([
    'title'       => 'Judul Halaman',
    'subtitle'    => '',
    'breadcrumbs' => [],
])

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-1 mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $title }}</h4>
        @if ($subtitle)
            <p class="text-muted mb-0" style="font-size:0.875rem;">{{ $subtitle }}</p>
        @endif
    </div>

    @if (count($breadcrumbs))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            @foreach ($breadcrumbs as $i => $crumb)
                @if ($i === count($breadcrumbs) - 1)
                    <li class="breadcrumb-item active">{{ $crumb['label'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $crumb['url'] ?? 'javascript:void(0);' }}">{{ $crumb['label'] }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
    @endif
</div>
