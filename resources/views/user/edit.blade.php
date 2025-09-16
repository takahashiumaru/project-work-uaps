<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT. Angkasa Pratama Sejahtera</title>
    <link rel="icon" href="{{ asset('storage/aps_mini.png') }}" sizes="48x48" type="image/png">
    <!-- Bootstrap & FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- jQuery & Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="{{ asset('/assets/js/script.js') }}" defer></script>
</head>

<body>
    @extends('app') 
    @include('partials.sidebar')

    @include('partials.navbar')
    <!-- Konten -->
    <div class="main-content">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">EDIT STAFF</h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" name="id" value="{{ $user->id }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fullname" value="{{ $user->fullname }}">
                                </div>
                                <div class="form-group">
                                    <label>Station</label>
                                    <select name="station" class="form-control">
                                        <option value="Office CGK">Office CGK</option>
                                        <option value="CGK">CGK</option>
                                        <option value="DPS">DPS</option>
                                        <option value="KNO">KNO</option>
                                        <option value="UPG">UPG</option>
                                        <option value="SUB">SUB</option>
                                        <option value="KJT">KJT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label>Job Title</label>
                                    <select name="JobTitle" class="form-control">
                                        <option value="PASSENGER HANDLING">PASSENGER HANDLING</option>
                                        <option value="BAGGAGE HANDLING">BAGGAGE HANDLING</option>
                                        <option value="RAMP HANDLING">RAMP HANDLING</option>
                                        <option value="CARGO HANDLING">CARGO HANDLING</option>
                                        <option value="AIRCRAFT SERVICE">AIRCRAFT SERVICE</option>
                                        <option value="SUPPORTING UNIT">SUPPORTING UNIT</option>
                                        <option value="OFFICE / ADMINISTRATION">OFFICE / ADMINISTRATION</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Cluster</label>
                                    <select name="Cluster" class="form-control">
                                        <option value="GROUND HANDLING">GROUND HANDLING</option>
                                        <option value="OFFICE">OFFICE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select name="Unit" class="form-control">
                                        <option value="FLIGHT OPERATION">FLIGHT OPERATION</option>
                                        <option value="RAMP HANDLING">RAMP HANDLING</option>
                                        <option value="BAGGAGE HANDLING">BAGGAGE HANDLING</option>
                                        <option value="HEAD OFFICE">HEAD OFFICE</option>
                                        <option value="PASSENGER HANDLING">PASSENGER HANDING</option>
                                        <option value="SUPPORTING / MANAGEMENT">SUPPORTING / MANAGEMENT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sub Unit</label>
                                    <select name="SubUnit" class="form-control">
                                        <option value="PORTER APRON">PORTER APRON</option>
                                        <option value="PORTER CARGO">PORTER CARGO</option>
                                        <option value="PORTER MAKE-UP">PORTER MAKE-UP</option>
                                        <option value="AIRCRAFT INTERIOR CLEANING">AIRCRAFT INTERIOR CLEANING</option>
                                        <option value="DISPATCHER">DISPATCHER</option>
                                        <option value="CONTROLLER">CONTROLLER</option>
                                        <option value="DRIVER">DRIVER</option>
                                        <option value="AVSEC">AVSEC</option>
                                        <option value="RAMP">RAMP</option>
                                        <option value="PASASI">PASASI</option>
                                        <option value="QUALITY CONTROL">QUALITY CONTROL(QC)</option>
                                        <option value="HEALTH, SAFETY, AND ENVIRONMENT">HEALTH, SAFETY, AND ENVIRONMENT (HSE)</option>
                                        <option value="HEAD OF AIRPORT SERVICES">HEAD OF AIRPORT SERVICES</option>
                                        <option value="HEAD STATION">HEAD STATION</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Manager</label>
                                    <select name="Manager" class="form-control">
                                        <option value="HAURA SHAFA AFANIN">HAURA SHAFA AFANIN(24080101002)</option>
                                        <option value="TRI UTAMI RHAHAYU">TRI UTAMI RHAHAYU(24080101001)</option>
                                        <option value="SISI FADILLAH">SISI FADILLAH(24080101003)</option>
                                        <option value="DIMAS RAFI HADITIYO">DIMAS RAFI HADITIYO(24080101004)</option>
                                        <option value="MULYADI">MULYADI(102240008)</option>
                                        <option value="JUNAIDI">JUNAIDI(102240006)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Senior Manager</label>
                                    <select name="SeniorManager" class="form-control">
                                        <option value="SUBCHAN">SUBCHAN(507040102)</option>
                                        <option value="ADE IRWAN EFFENDI">ADE IRWAN EFFENDI(102240243)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="gender" class="form-control">
                                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Join Date</label>
                                    <input type="date" class="form-control" name="join_date" value="{{ $user->join_date }}">
                                </div>
                                <div class="form-group">
                                    <label>Gaji</label>
                                    <input type="number" class="form-control" name="salary" value="{{ $user->salary }}">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control">
                                        <option value="{{ $user->role }}">{{ $user->role }}</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="ASS LEADER">ASS LEADER</option>
                                        <option value="CHIEF">CHIEF</option>
                                        <option value="DISPATCHER">DISPATCHER</option>
                                        <option value="DRIVER">DRIVER</option>
                                        <option value="HSE">HSE</option>
                                        <option value="LEADER">LEADER</option>
                                        <option value="PORTER">PORTER</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Qantas</label>
                                    <select name="is_qantas" class="form-control">
                                        <option value="1" {{ old('is_qantas', $user->is_qantas) == 1 ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ old('is_qantas', $user->is_qantas) == 0 ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">UPDATE</button>
                                    <a href="{{ route('users.index', ['page' => $page]) }}" class="btn btn-warning">BACK</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#unit_select').on('change', function() {
                var unitValue = $(this).val();
                var subUnitSelect = $('#sub_unit_select');


                subUnitSelect.val('');

                if (unitValue === 'baggage handling') {
                    subUnitSelect.val('porter apron');
                } else if (unitValue === 'baggage claim') {
                    subUnitSelect.val('porter makeup');
                } else if (unitValue === 'aircraft cleaning') {
                    subUnitSelect.val('aiec');
                }

            });
        });
    </script>

</body>
