<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sertifikat Training Staff</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="/assets/css/style.css">

    <style>
        /* Card Container */
        .card-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* Table Scroll & Layout */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
        }

        th,
        td {
            white-space: nowrap;
            padding: 8px;
            text-align: left;
        }

        /* Sticky Header */
        thead th {
            position: sticky;
            top: 0;
            background-color: rgb(151, 189, 227);
            z-index: 5;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        /* Highlight Sertifikat Expired / Expiring Soon */
        .expiring-soon {
            background-color: #fff3cd;
        }

        .expired {
            background-color: #f8d7da;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons img {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .action-buttons img:hover {
            transform: scale(1.1);
        }

        /* Responsive Search Bar */
        .search-bar {
            margin-bottom: 15px;
        }
    </style>
</head>

<body class="with-sidebar">
    @include('app')

    <div class="main-content">
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fas fa-certificate"> Sertifikat Training Staff</h2>
                    <p>Manajemen seluruh sertifikat training staff di sistem.</p>
                </div>
            </div>

            <div class="text-right" style="margin-bottom: 10px;">
                <a href="{{ route('admin.training.certificates.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Tambah Sertifikat
                </a>
            </div>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Certificate Table -->
            <!-- <div class="card-container"> -->
                <div class="table-container">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Staff</th>
                                <th>Safety Management System</th>
                                <th>Human Factors</th>
                                <th>Ramp Safety / Airside Safety</th>
                                <th>Dangerous Goods (DG) Regulations</th>
                                <th>Aviation Security (AVSEC) Awareness</th>
                                <th>Airport Emergency Plan (AEP)</th>
                                <th>Ground Support Equipment (GSE) Operation</th>
                                <th>Basic First Aid</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                            <tr class="{{ $certificate->is_expiring_soon ? 'expiring-soon' : ($certificate->is_expired ? 'expired' : '') }}">
                                <td>{{ $certificate->nip }}</td>
                                <td>{{ $certificate->staff_name }}</td>
                                <td>{{ $certificate->sms_expiry }}</td>
                                <td>{{ $certificate->human_factors_expiry }}</td>
                                <td>{{ $certificate->ramp_safety_expiry }}</td>
                                <td>{{ $certificate->dangerous_goods_expiry }}</td>
                                <td>{{ $certificate->avsec_expiry }}</td>
                                <td>{{ $certificate->aep_expiry }}</td>
                                <td>{{ $certificate->gse_operation_expiry }}</td>
                                <td>{{ $certificate->basic_first_aid_expiry }}</td>
                                <td>{{ $certificate->notes }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.training.certificates.edit', $certificate) }}">
                                            <img src="{{ asset('storage/edit.png') }}" width="20" height="20" alt="Edit">
                                        </a>
                                        <form action="{{ route('admin.training.certificates.destroy', $certificate) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $certificates->links() }}
            </div>
        </div>
    </div>

    @include('sweetalert::alert')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>
