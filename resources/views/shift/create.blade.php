@extends('layout.admin')

@section('title', 'Create New Shift')

@section('styles')
    <style>
        .shift-form-page {
            --shift-surface: #ffffff;
            --shift-soft: #f8fbff;
            --shift-muted: #718096;
            --shift-text: #243247;
            --shift-line: #e5edf7;
            --shift-blue: #2f80ed;
            --shift-blue-deep: #2368c8;
            --shift-green: #16a163;
            --shift-green-soft: #e9f8f0;
            --shift-shadow: 0 16px 38px rgba(31, 49, 78, 0.07);
            --shift-radius: 1rem;
            --shift-radius-sm: 0.8rem;
        }

        .shift-form-page .shift-page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .shift-form-page .shift-title {
            margin: 0;
            color: var(--shift-text);
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1.25;
        }

        .shift-form-page .shift-title span {
            color: #9aa8bb;
            font-weight: 650;
        }

        .shift-form-page .shift-page-chip,
        .shift-form-page .shift-meta-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            min-height: 36px;
            padding: 0.45rem 0.72rem;
            border-radius: 999px;
            background: rgba(47, 128, 237, 0.1);
            color: var(--shift-blue-deep);
            font-size: 0.78rem;
            font-weight: 750;
            white-space: nowrap;
        }

        .shift-form-page .shift-workspace {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 1rem;
            align-items: start;
        }

        .shift-form-page .shift-panel,
        .shift-form-page .shift-side-panel {
            background: var(--shift-surface);
            border: 1px solid var(--shift-line);
            border-radius: var(--shift-radius);
            box-shadow: var(--shift-shadow);
        }

        .shift-form-page .shift-panel {
            overflow: visible;
        }

        .shift-form-page .shift-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid var(--shift-line);
            background: linear-gradient(180deg, #fbfdff 0%, #ffffff 100%);
            border-radius: var(--shift-radius) var(--shift-radius) 0 0;
        }

        .shift-form-page .shift-panel-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .shift-form-page .shift-panel-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            width: 40px;
            height: 40px;
            border-radius: var(--shift-radius-sm);
            background: linear-gradient(135deg, var(--shift-blue), var(--shift-blue-deep));
            color: #ffffff;
            font-size: 1.1rem;
            box-shadow: 0 12px 24px rgba(47, 128, 237, 0.18);
        }

        .shift-form-page .shift-panel-title h5 {
            margin: 0;
            color: var(--shift-text);
            font-size: 1rem;
            font-weight: 800;
        }

        .shift-form-page .shift-panel-title p {
            margin: 0.15rem 0 0;
            color: var(--shift-muted);
            font-size: 0.78rem;
            font-weight: 600;
        }

        .shift-form-page .shift-form-body {
            padding: 1.1rem;
        }

        .shift-form-page .shift-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.95rem 1rem;
        }

        .shift-form-page .shift-field {
            min-width: 0;
        }

        .shift-form-page .shift-field.is-wide {
            grid-column: 1 / -1;
        }

        .shift-form-page .form-label {
            margin-bottom: 0.38rem;
            color: #69788d;
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .shift-form-page .form-control,
        .shift-form-page .form-select {
            min-height: 40px;
            padding: 0.55rem 0.78rem;
            border-color: var(--shift-line);
            border-radius: 0.78rem;
            color: #34445a;
            font-size: 0.84rem;
            box-shadow: none;
        }

        .shift-form-page .form-control:focus,
        .shift-form-page .form-select:focus {
            border-color: rgba(47, 128, 237, 0.45);
            box-shadow: 0 0 0 4px rgba(47, 128, 237, 0.09);
        }

        .shift-form-page .form-hint {
            margin-top: 0.32rem;
            color: #7b8ca3;
            font-size: 0.78rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .shift-form-page .time-input-group {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .shift-form-page .shift-alert {
            margin-bottom: 1rem;
            border: 1px solid rgba(239, 68, 68, 0.18);
            border-radius: 0.9rem;
            background: #fff7f7;
            color: #9b1c1c;
            padding: 0.85rem 1rem;
            font-size: 0.86rem;
        }

        .shift-form-page .shift-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.15rem;
            padding-top: 1rem;
            border-top: 1px solid var(--shift-line);
        }

        .shift-form-page .shift-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            min-height: 40px;
            padding: 0.55rem 1rem;
            border: 0;
            border-radius: 0.75rem;
            color: #ffffff;
            font-size: 0.82rem;
            font-weight: 800;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
        }

        .shift-form-page .shift-btn:hover {
            color: #ffffff;
            transform: translateY(-1px);
        }

        .shift-form-page .shift-btn.is-muted {
            background: #6b7684;
        }

        .shift-form-page .shift-btn.is-primary {
            background: linear-gradient(135deg, var(--shift-green), #129658);
            box-shadow: 0 12px 24px rgba(22, 161, 99, 0.18);
        }

        .shift-form-page .shift-side-panel {
            padding: 1rem;
        }

        .shift-form-page .shift-side-title {
            display: flex;
            align-items: center;
            gap: 0.58rem;
            margin-bottom: 0.85rem;
            color: var(--shift-text);
            font-size: 0.92rem;
            font-weight: 800;
        }

        .shift-form-page .shift-side-title i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 0.7rem;
            background: rgba(47, 128, 237, 0.1);
            color: var(--shift-blue);
        }

        .shift-form-page .shift-guide-list {
            display: grid;
            gap: 0.65rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .shift-form-page .shift-guide-list li {
            display: grid;
            grid-template-columns: 26px minmax(0, 1fr);
            gap: 0.55rem;
            color: #60728a;
            font-size: 0.8rem;
            line-height: 1.45;
        }

        .shift-form-page .shift-guide-list i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 999px;
            background: var(--shift-green-soft);
            color: var(--shift-green);
        }

        .shift-form-page .shift-format-box {
            margin-top: 1rem;
            padding: 0.85rem;
            border-radius: 0.9rem;
            background: var(--shift-soft);
            border: 1px solid var(--shift-line);
        }

        .shift-form-page .shift-format-box strong {
            display: block;
            margin-bottom: 0.3rem;
            color: var(--shift-text);
            font-size: 0.8rem;
        }

        .shift-form-page .shift-format-box span {
            color: var(--shift-muted);
            font-size: 0.76rem;
            font-weight: 600;
            line-height: 1.45;
        }

        html.aps-dark .shift-form-page {
            --shift-surface: #111c31;
            --shift-soft: #0f1a2d;
            --shift-muted: #9fb0c8;
            --shift-text: #dbe7f6;
            --shift-line: #263653;
            --shift-green-soft: rgba(34, 197, 94, 0.14);
            --shift-shadow: 0 18px 42px rgba(0, 0, 0, 0.22);
        }

        html.aps-dark .shift-form-page .shift-panel-head {
            background: #0f1a2d;
        }

        html.aps-dark .shift-form-page .form-control,
        html.aps-dark .shift-form-page .form-select {
            background: #111c31 !important;
            border-color: #2a3a55 !important;
            color: #dbe7f6 !important;
        }

        html.aps-dark .shift-form-page .shift-alert {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.24);
            color: #fecaca;
        }

        @media (max-width: 1199.98px) {
            .shift-form-page .shift-workspace {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .shift-form-page .shift-page-head,
            .shift-form-page .shift-panel-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .shift-form-page .shift-form-grid,
            .shift-form-page .time-input-group {
                grid-template-columns: 1fr;
            }

            .shift-form-page .shift-actions {
                flex-direction: column-reverse;
            }

            .shift-form-page .shift-btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y shift-form-page">
        <div class="shift-page-head">
            <h4 class="shift-title">
                <span>Schedule / Shift /</span> Create New
            </h4>
            <span class="shift-page-chip">
                <i class="bx bx-plus-circle"></i>
                New Shift
            </span>
        </div>

        <div class="shift-workspace">
            <section class="shift-panel">
                <div class="shift-panel-head">
                    <div class="shift-panel-title">
                        <span class="shift-panel-icon">
                            <i class="bx bx-time-five"></i>
                        </span>
                        <div>
                            <h5>Create New Shift</h5>
                            <p>Tambahkan shift operasional baru ke sistem.</p>
                        </div>
                    </div>
                    <span class="shift-meta-chip">
                        <i class="bx bx-calendar-check"></i>
                        Format 24 jam
                    </span>
                </div>

                <div class="shift-form-body">
                    @if ($errors->any())
                        <div class="shift-alert">
                            <strong>Periksa data:</strong>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('shift.store') }}" method="POST" id="shiftForm">
                        @csrf

                        <div class="shift-form-grid">
                            <div class="shift-field">
                                <label class="form-label" for="id">Shift ID *</label>
                                <input type="text" class="form-control" name="id" id="id"
                                    placeholder="Contoh: S1, S2, S3" value="{{ old('id') }}" required>
                                <div class="form-hint">Gunakan huruf dan angka, tanpa spasi.</div>
                            </div>

                            <div class="shift-field">
                                <label class="form-label" for="name">Nama Shift *</label>
                                <select class="form-select" name="name" id="name" required>
                                    <option value="">Pilih shift</option>
                                    <option value="Pagi" {{ old('name') === 'Pagi' ? 'selected' : '' }}>Pagi</option>
                                    <option value="Siang" {{ old('name') === 'Siang' ? 'selected' : '' }}>Siang</option>
                                    <option value="Malam" {{ old('name') === 'Malam' ? 'selected' : '' }}>Malam</option>
                                </select>
                                <div class="form-hint">Kategori shift yang mudah dicari.</div>
                            </div>

                            <div class="shift-field is-wide">
                                <label class="form-label" for="description">Deskripsi *</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    placeholder="Contoh: Shift operasional pagi hari" value="{{ old('description') }}" required>
                                <div class="form-hint">Tuliskan konteks singkat agar jadwal mudah dipahami.</div>
                            </div>

                            <div class="shift-field is-wide">
                                <label class="form-label">Jam Kerja *</label>
                                <div class="time-input-group">
                                    <div>
                                        <label class="form-label" for="start_time">Jam Mulai</label>
                                        <input type="time" class="form-control" name="start_time" id="start_time"
                                            value="{{ old('start_time') }}" required>
                                    </div>
                                    <div>
                                        <label class="form-label" for="end_time">Jam Berakhir</label>
                                        <input type="time" class="form-control" name="end_time" id="end_time"
                                            value="{{ old('end_time') }}" required>
                                    </div>
                                </div>
                                <div class="form-hint">Jam berakhir harus setelah jam mulai.</div>
                            </div>

                            <div class="shift-field">
                                <label class="form-label" for="use_manpower">Tenaga Kerja *</label>
                                <input type="number" class="form-control" name="use_manpower" id="use_manpower"
                                    placeholder="Contoh: 5" value="{{ old('use_manpower') }}" min="1" max="50" required>
                                <div class="form-hint">Jumlah staff yang dibutuhkan per shift.</div>
                            </div>
                        </div>

                        <div class="shift-actions">
                            <a href="{{ route('shift.index') }}" class="shift-btn is-muted">
                                <i class="bx bx-arrow-back"></i>
                                Back
                            </a>
                            <button type="submit" class="shift-btn is-primary">
                                <i class="bx bx-save"></i>
                                Create Shift
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <aside class="shift-side-panel">
                <div class="shift-side-title">
                    <i class="bx bx-info-circle"></i>
                    Panduan Shift
                </div>
                <ul class="shift-guide-list">
                    <li>
                        <i class="bx bx-check"></i>
                        <span><strong>Shift ID</strong> wajib unik dan dipakai sebagai referensi jadwal.</span>
                    </li>
                    <li>
                        <i class="bx bx-time"></i>
                        <span>Pastikan rentang jam kerja sudah sesuai kebutuhan operasional.</span>
                    </li>
                    <li>
                        <i class="bx bx-user"></i>
                        <span>Tenaga kerja menentukan kapasitas staff untuk shift tersebut.</span>
                    </li>
                </ul>
                <div class="shift-format-box">
                    <strong>Contoh format</strong>
                    <span>ID: S1, Nama: Pagi, Jam: 07:00 sampai 15:00.</span>
                </div>
            </aside>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function initShiftForm() {
                const form = document.getElementById('shiftForm');
                const startTime = document.getElementById('start_time');
                const endTime = document.getElementById('end_time');
                const shiftIdInput = document.getElementById('id');

                if (!form || !startTime || !endTime) return;

                function setEndTimeState(isValid) {
                    endTime.classList.toggle('is-invalid', !isValid);
                    endTime._apsPicker?.picker?.classList.toggle('is-invalid', !isValid);
                }

                function validateTime() {
                    const isValid = !(startTime.value && endTime.value && startTime.value >= endTime.value);
                    endTime.setCustomValidity(isValid ? '' : 'Jam berakhir harus setelah jam mulai');
                    setEndTimeState(isValid);
                    return isValid;
                }

                startTime.addEventListener('change', validateTime);
                endTime.addEventListener('change', validateTime);

                shiftIdInput?.addEventListener('input', function() {
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                });

                form.addEventListener('submit', function(event) {
                    if (!validateTime() || !form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Data belum valid',
                                text: validateTime() ? 'Lengkapi form terlebih dahulu.' : 'Jam berakhir harus setelah jam mulai.',
                                icon: 'warning',
                                timer: 2600,
                                showConfirmButton: false
                            });
                        }
                        return;
                    }

                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (!submitBtn) return;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="bx bx-loader bx-spin"></i> Creating...';
                    submitBtn.disabled = true;

                    window.setTimeout(function() {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 3000);
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initShiftForm);
            } else {
                initShiftForm();
            }
        })();
    </script>
@endsection
