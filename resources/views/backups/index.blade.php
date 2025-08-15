@extends('layouts.admin')
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
@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Backup Manager</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
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
        {{-- <div class="col-md-4">
            <a href="{{ route('backup.full') }}" class="backup-card text-decoration-none">
                <div class="card p-4 text-center shadow-sm border-0 h-100">
                    <div class="icon-box mb-3">
                        🔄
                    </div>
                    <h5 class="fw-bold">Full Backup</h5>
                    <p class="text-muted mb-0">Download database and files together.</p>
                </div>
            </a>
        </div> --}}

        {{-- Restore Forms --}}
        <div class="col-md-4">
            <form action="{{ route('restore.database') }}" method="POST" enctype="multipart/form-data" id="restoreFormData" class="card p-4 text-center shadow-sm border-0 h-100">
                @csrf
                <label class="form-label fw-bold">Restore Database</label>
                <input type="file" name="sql_file" class="form-control mb-3" accept=".sql" required>
                <button type="submit" class="btn btn-success" id="restoreBtnData">Restore</button>
            </form>
        </div>
        {{-- <div class="col-md-4">
            <form action="{{ route('restore.files') }}" method="POST" enctype="multipart/form-data" id="restoreFormFile" class="card p-4 text-center shadow-sm border-0 h-100">
                @csrf
                <label class="form-label fw-bold">Restore Files</label>
                <input type="file" name="zip_file" class="form-control mb-3" accept=".zip" required>
                <button type="submit" class="btn btn-primary" id="restoreBtnFile">Restore</button>
            </form>
        </div> --}}
    </div>
</div>
<!-- Loading Modal -->
<div class="modal custom-modal fade" id="loadingModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4 align-items-center border-0 shadow-sm">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h5 class="mt-3">Processing...</h5>
            <p class="text-muted mb-0">Please wait while we complete your request.</p>
        </div>
    </div>
</div>


@endsection
@section('script')
    @include('includs.datatable_basic')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('restoreFormFile');
            const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'), {
                backdrop: 'static',
                keyboard: false
            });
            if (form) {
                form.addEventListener('submit', function(e) {
                    const btn = document.getElementById('restoreBtnFile');
                    btn.disabled = true;
                    btn.innerHTML = 'Pending...';
                    loadingModal.show();
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('restoreFormData');
            const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'), {
                backdrop: 'static',
                keyboard: false
            });
            if (form) {
                form.addEventListener('submit', function(e) {
                    const btn = document.getElementById('restoreBtnData');
                    btn.disabled = true;
                    btn.innerHTML = 'Pending...';
                    loadingModal.show();
                });
            }
        });
    </script>
@endsection
