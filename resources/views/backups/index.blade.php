@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Backup Manager</h2>

    <div class="row g-4">
        <!-- Database Backup -->
        <div class="col-md-4">
            <a href="{{ route('backup.database') }}" class="backup-card text-decoration-none">
                <div class="card p-4 text-center shadow-sm border-0 h-100">
                    <div class="icon-box mb-3">
                        💾
                    </div>
                    <h5 class="fw-bold">Database Backup</h5>
                    <p class="text-muted mb-0">Download a backup of the MySQL database.</p>
                </div>
            </a>
        </div>

        <!-- Files Backup -->
        <div class="col-md-4">
            <a href="{{ route('backup.files') }}" class="backup-card text-decoration-none">
                <div class="card p-4 text-center shadow-sm border-0 h-100">
                    <div class="icon-box mb-3">
                        📂
                    </div>
                    <h5 class="fw-bold">Files Backup</h5>
                    <p class="text-muted mb-0">Download all stored files in a ZIP archive.</p>
                </div>
            </a>
        </div>

        <!-- Full Backup -->
        <div class="col-md-4">
            <a href="{{ route('backup.full') }}" class="backup-card text-decoration-none">
                <div class="card p-4 text-center shadow-sm border-0 h-100">
                    <div class="icon-box mb-3">
                        🔄
                    </div>
                    <h5 class="fw-bold">Full Backup</h5>
                    <p class="text-muted mb-0">Download database and files together.</p>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .icon-box {
        font-size: 2.5rem;
        color: #4e73df;
    }
    .backup-card .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .backup-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection