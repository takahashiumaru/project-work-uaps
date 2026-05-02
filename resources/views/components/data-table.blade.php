{{--
    ======================================================================
    REUSABLE DATA TABLE COMPONENT: <x-data-table>
    ======================================================================
    Usage:
        <x-data-table :paginator="$users" empty-icon="bx-user" empty-text="Tidak ada user.">
            <x-slot name="head">
                <th>NIP</th>
                <th>Nama</th>
            </x-slot>

            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->fullname }}</td>
            </tr>
            @endforeach
        </x-data-table>

    Props:
        - $paginator  : LengthAwarePaginator instance (required for pagination)
        - $emptyIcon  : Boxicons class for empty state (default: bx-data)
        - $emptyText  : Message when data is empty
        - $colSpan    : colspan for empty state row (default: 99)
        - slot "head" : <th> elements
        - default slot: <tr> rows
    ======================================================================
--}}

@props([
    'paginator' => null,
    'emptyIcon' => 'bx-data',
    'emptyText' => 'Tidak ada data ditemukan.',
    'colSpan'   => 99,
])

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>
        <tbody>
            @if (($paginator && $paginator->isEmpty()) || (!$paginator && trim($slot) === ''))
                <tr>
                    <td colspan="{{ $colSpan }}">
                        <div class="empty-state">
                            <i class="bx {{ $emptyIcon }} d-block"></i>
                            <p>{{ $emptyText }}</p>
                        </div>
                    </td>
                </tr>
            @else
                {{ $slot }}
            @endif
        </tbody>
    </table>
</div>

{{-- Pagination Footer (Always visible) --}}
@if ($paginator && $paginator instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="dt-pagination-wrapper">
    {{ $paginator->links('vendor.pagination.custom') }}
</div>
@endif
