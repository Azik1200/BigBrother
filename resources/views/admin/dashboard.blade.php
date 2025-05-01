@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold mb-4"><i class="bi bi-tools me-2"></i> Admin Panel</h1>

        <div class="row g-4">
            <!-- FollowUp -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="mb-0"><i class="bi bi-clipboard-data-fill me-2"></i> FollowUp Management</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="text-muted">Manage FollowUp entries and analyze submitted data.</p>
                        <a href="{{ route('admin.followup') }}" class="btn btn-outline-primary w-100 mt-auto">Go to FollowUp</a>
                    </div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white rounded-top">
                        <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i> User Management</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="text-muted">Create, update, and manage user accounts and roles.</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success w-100 mt-auto">Manage Users</a>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-warning text-dark rounded-top">
                        <h5 class="mb-0"><i class="bi bi-bar-chart-line-fill me-2"></i> Analytics</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="text-muted">View statistical reports, trends and performance indicators.</p>
                        <a href="{{ route('admin.analytics') }}" class="btn btn-outline-warning w-100 mt-auto">View Analytics</a>
                    </div>
                </div>
            </div>

            <!-- Backups -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-dark text-white rounded-top">
                        <h5 class="mb-0"><i class="bi bi-hdd-fill me-2"></i> Backups</h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="text-muted">View and manage database backups.</p>
                        <a href="{{ route('admin.backups.index') }}" class="btn btn-outline-dark w-100 mt-auto">Manage Backups</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
