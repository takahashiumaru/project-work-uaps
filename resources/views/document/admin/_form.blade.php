@csrf
@isset($method)
    @method($method)
@endisset

<div class="row">
    <div class="col-lg-8">
        <div class="mb-3">
            <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
            <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen"
                name="nama_dokumen" value="{{ old('nama_dokumen', $document->nama_dokumen ?? '') }}" required>
            @error('nama_dokumen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi_dokumen" class="form-label">Deskripsi Dokumen</label>
            <textarea class="form-control @error('deskripsi_dokumen') is-invalid @enderror" id="deskripsi_dokumen"
                name="deskripsi_dokumen" rows="4" required>{{ old('deskripsi_dokumen', $document->deskripsi_dokumen ?? '') }}</textarea>
            @error('deskripsi_dokumen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        @php
            $selectedAccess = old(
                'role_akses_dokumen',
                isset($document) ? $document->role_access_values : [\App\Models\Document::ACCESS_ALL],
            );
            $selectedAccess = is_array($selectedAccess) ? $selectedAccess : [$selectedAccess];
            $selectedAccessNormalized = collect($selectedAccess)
                ->map(fn ($role) => \App\Models\Document::normalizeRole($role))
                ->all();
            $allRolesSelected = in_array(\App\Models\Document::ACCESS_ALL, $selectedAccessNormalized, true);
        @endphp
        <div class="mb-3">
            <label class="form-label">Role Akses Dokumen</label>
            <div class="document-role-picker @error('role_akses_dokumen') is-invalid @enderror @error('role_akses_dokumen.*') is-invalid @enderror">
                <label class="document-role-option is-all">
                    <input type="checkbox" name="role_akses_dokumen[]" value="{{ \App\Models\Document::ACCESS_ALL }}"
                        data-document-role-all {{ $allRolesSelected ? 'checked' : '' }}>
                    <span class="document-role-check"><i class="ti ti-check"></i></span>
                    <span>Semua Role</span>
                </label>

                <div class="document-role-search">
                    <i class="ti ti-search"></i>
                    <input type="text" class="form-control" placeholder="Cari role..." data-document-role-search>
                </div>

                <div class="document-role-list" data-document-role-list>
                    @foreach ($availableRoles as $role)
                        @php
                            $roleSelected = !$allRolesSelected
                                && in_array(\App\Models\Document::normalizeRole($role), $selectedAccessNormalized, true);
                        @endphp
                        <label class="document-role-option" data-document-role-option data-role-label="{{ strtolower($role) }}">
                            <input type="checkbox" name="role_akses_dokumen[]" value="{{ $role }}"
                                data-document-role-item {{ $roleSelected ? 'checked' : '' }}>
                            <span class="document-role-check"><i class="ti ti-check"></i></span>
                            <span>{{ $role }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            @error('role_akses_dokumen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @error('role_akses_dokumen.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="document_file" class="form-label">File Dokumen</label>
            <input type="file" class="form-control @error('document_file') is-invalid @enderror" id="document_file"
                name="document_file" {{ empty($document) ? 'required' : '' }}>
            <div class="form-text">PDF, DOC, XLS, JPG, PNG. Maksimal 10 MB.</div>
            @error('document_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @isset($document)
            <div class="document-file-summary">
                <div class="document-file-summary-icon">
                    <i class="ti ti-file-text"></i>
                </div>
                <div class="min-w-0">
                    <div class="fw-semibold text-truncate">{{ $document->nama_file }}</div>
                    <div class="small text-muted">{{ $document->ukuran_file ?? '-' }}</div>
                </div>
            </div>
        @endisset
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="ti ti-device-floppy me-1"></i>{{ $submitLabel }}
    </button>
    <a href="{{ route('admin.documents.index') }}" class="btn btn-label-secondary">Batal</a>
</div>
