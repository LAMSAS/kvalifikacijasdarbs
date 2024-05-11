{{-- breadcrumb --}}
<div class="row">
    <div class="col-md-12">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/employees">Employees</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Employee profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i class="{{ $aimx['icon'] }} text-white" style="font-size: 9rem !important;"></i>
                            <img src="../assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- tab navigation --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-pills user-profile-tab">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4 {{ $tab == 'overview' ? 'active' : '' }}" href="/employees/profile/{{ $employee->id }}/profile">
                                <i class="ti ti-users me-2 fs-6"></i>
                                <span class="d-none d-md-block">Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 text-end">
                    <div class="p-3">
                        <a class="btn bg-danger-subtle text-danger me-2 px-2" href="#" data-request="onDelete" data-request-confirm="Are you sure you want to delete this employee?" data-request-data="id: {{ $employee->id }}">
                            <i class="ti ti-trash fs-6"></i>
                        </a>
                        <a class="btn bg-primary-subtle text-primary me-2 px-2" href="#" data-request="onClone" data-request-confirm="Are you sure you want to delete this employee?" data-request-data="id: {{ $employee->id }}">
                            <i class="ti ti-copy fs-6"></i>
                        </a>
                        <a class="btn bg-primary-subtle text-primary px-2" href="#" data-request="onClone" data-request-confirm="Are you sure you want to delete this employee?" data-request-data="id: {{ $employee->id }}">
                            <i class="ti ti-message fs-6"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




