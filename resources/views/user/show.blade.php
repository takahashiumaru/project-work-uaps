@extends('app')

@section('title', 'Profil User')

@section('styles')
<style>
    main.content-area {
        padding: 32px 48px;
        overflow-y: auto;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        max-width: 1440px;
        margin: 0 auto;
    }

    main.content-area h2.section-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 36px;
        display: flex;
        align-items: center;
        gap: 12px;
        user-select: none;
        color: #222;
    }

    main.content-area h2.section-title .material-icons {
        color: #d9141b;
        font-size: 26px;
    }

    form.personal-data-form {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px 32px;
        width: 100%;
    }

    form.personal-data-form label {
        display: flex;
        flex-direction: column;
        font-weight: 500;
        font-size: 0.9rem;
        color: #444;
    }

    form.personal-data-form input,
    form.personal-data-form select {
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f7f7f7;
        padding: 10px 14px;
        font-size: 1rem;
        color: #333;
        transition: border-color 0.25s ease;
        user-select: text;
    }

    form.personal-data-form input:disabled,
    form.personal-data-form select:disabled {
        background: #e9ecef;
        color: #6c757d;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    form.personal-data-form input:focus,
    form.personal-data-form select:focus {
        border-color: #d9141b;
        outline: none;
        background: #fff;
    }

    @media (max-width: 576px) {
        .profile-card {
            padding: 20px !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        .profile-card form {
            margin-bottom: 20px;
        }

        .profile-card img {
            width: 120px !important;
            height: 120px !important;
            border-width: 3px !important;
        }

        .profile-card h3 {
            font-size: 1.5rem !important;
            margin-top: 10px !important;
        }

        .profile-card>div:nth-child(2) {
            display: block !important;
            width: 100% !important;
            font-size: 14px !important;
        }

        .profile-card>div:nth-child(2)>div {
            display: flex !important;
            justify-content: space-between !important;
            padding: 6px 0 !important;
            border-bottom: 1px solid #eee;
            word-wrap: break-word;
        }
    }
</style>
@endsection

@section('content')
{{-- Konten utama halaman profil --}}
<div style="width: 100%; max-width: 1500px; margin: 0 auto; margin-top: 80px; padding: 20px;">
    {{-- Tombol BACK --}}
    <div style="max-width: 900px; margin: 0 auto; margin-bottom: 20px; text-align: right;">
        <a href="{{ route('users.index', ['page' => $page]) }}" class="btn btn-warning">BACK</a>
    </div>

    {{-- Kartu Profil Utama --}}
    <div class="profile-wrapper responsive-profile-wrapper" style="display: flex; justify-content: center;">
        <div class="profile-card responsive-profile-card" style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; align-items: center; gap: 30px; max-width: 900px; width: 100%;">
            {{-- Formulir Unggah Foto Profil --}}
            <form id="photoForm" method="POST" enctype="multipart/form-data" action="{{ route('user.updatePhoto', ['userId' => $user->id]) }}">
                @csrf
                <input type="file" name="profile_picture" id="fileInput" style="display: none;" onchange="document.getElementById('photoForm').submit();">
                <div style="text-align: center;">
                    <label for="fileInput" style="cursor: pointer;">
                        <img src="{{ $user->profile_picture ? asset('storage/photo/' . $user->profile_picture): asset('storage/photo/user.jpg') }}"
                            alt="User Photo"
                            style="width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 4px solid #ccc;">
                    </label>
                    <h3 style="margin-top: 20px; font-weight: bold;">{{ $user->fullname }}</h3>
                    <p style="color: gray;">{{ $user->role ?? 'Title or Company' }}</p>
                </div>
            </form>

            {{-- Area Data Pribadi --}}
            <main class="content-area" role="main" tabindex="-1">
                <h2 class="section-title">Personal Data</h2>
                <form class="personal-data-form" aria-label="Personal data form">
                    <label for="Nip">
                        NIP
                        <input type="text" id="staffId" name="staffId" value="{{ $user->id }}" disabled />
                    </label>
                    <label for="firstName">
                        First Name
                        <input type="text" id="firstName" name="firstName" value="{{ $user->fullname }}" disabled />
                    </label>
                    <label for="lastName">
                        Station
                        <input type="text" id="station" name="station" value="{{ $user->station }}" disabled />
                    </label>
                    <label for="email">
                        Email
                        <input type="text" id="email" name="email" value="{{ $user->email }}" disabled />
                    </label>
                    <label for="JobTitle">
                        Job Title
                        <input type="text" id="jobTitle" name="jobTitle" value="{{ $user->job_title }}" disabled />
                    </label>
                    <label for="Cluster">
                        Cluster
                        <input type="text" id="CLuster" name="CLuster" value="{{ $user->cluster }}" disabled />
                    </label>
                    <label for="Unit">
                        Unit
                        <input type="text" id="Unit" name="Unit" value="{{ $user->unit }}" disabled />
                    </label>
                    <label for="SubUnit">
                        Sub Unit
                        <input type="text" id="subUnit" name="subUnit" value="{{ $user->sub_unit }}" disabled />
                    </label>
                    <label for="Manager">
                        Manager
                        <input type="text" id="manager" name="manager" value="{{ $user->manager}}" disabled />
                    </label>
                    <label for="SeniorManager">
                        Senior Manager
                        <input type="text" id="SeniorManager" name="SeniorManager" value="{{ $user->senior_manager}}" disabled />
                    </label>
                    <label for="Gender">
                        Gender
                        <input type="text" id="Gender" name="Gender" value="{{ $user->gender}}" disabled />
                    </label>
                    <label for="Status">
                        Status
                        <input type="text" id="Status" name="Status" value="{{ $user->status}}" disabled />
                    </label>
                    <label for="JoinDate">
                        Join Date
                        <select id="JoinDate" name="join_date" disabled>
                            <option selected>{{ $user->join_date }}</option>
                        </select>
                    </label>
                    @if (in_array(Auth::user()->role, ['ADMIN', 'ASS LEADER', 'CHIEF', 'LEADER']))
                    <label for="ContractStart">
                        Contract Start
                        <select id="ContractStart" name="ContractStart" disabled>
                            <option selected>{{ $user->contract_start }}</option>
                        </select>
                    </label>
                    <label for="ContractEnd">
                        Contract End
                        <select id="ContractEnd" name="ContractEnd" disabled>
                            <option selected>{{ $user->contract_end }}</option>
                        </select>
                    </label>
                    @endif
                    <label for="PASResgistered">
                        PAS Registered
                        <select id="PASRegistered" name="PASRegistered" disabled>
                            <option selected>{{ $user->pas_registered }}</option>
                        </select>
                    </label>
                    <label for="PASExpired">
                        PAS Expired
                        <select id="PASEXpired" name="PASExpired" disabled>
                            <option selected>{{ $user->pas_expired }}</option>
                        </select>
                    </label>
                    @if (in_array(Auth::user()->role, ['Admin', 'Ass Leader', 'Chief', 'Leader', 'Finance']))
                    <label for="Salary">
                        Salary
                        <select id="Salary" name="Salary" disabled>
                            <option selected>Rp {{ number_format((float)$user->salary, 0, ',', '.') }}</option>
                        </select>
                    </label>
                    @endif
                </form>
            </main>
        </div>
    </div>
</div>
@endsection
