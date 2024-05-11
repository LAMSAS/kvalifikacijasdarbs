<form>
    <div class="card">
        <div class="card-body">
            {{-- Basic information --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3">Basic information</h5>
                </div>
            </div>
    
            <div class="row">
        <div class="col-md-6">
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    First Name
                    <span class="ti ti-asterisk text-danger"></span>
                </label>
                <input type="text" class="form-control" placeholder="First Name" name="data[first_name]" value="{{ $employee->first_name }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Last Name
                    <span class="ti ti-asterisk text-danger"></span>
                </label>
                <input type="text" class="form-control" placeholder="Last Name" name="data[last_name]" value="{{ $employee->last_name }}" required>
            </div>
        </div>
    </div> 
    
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Status
                            <span class="ti ti-asterisk text-danger"></span>
                        </label>
                        <select class="form-select" name="data[status]">
                            <option value="1" {{ $employee->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $employee->is_active ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Position</label>
                        <input type="text" class="form-control" placeholder="Position" name="data[position]" value="{{ $employee->position }}">
                    </div>
                </div>
            </div>
    
            {{-- Contact information --}}
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3 mt-4">Contact information</h5>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Address
                        </label>
                        <input type="text" class="form-control" placeholder="Address" name="data[address]" value="{{ $employee->address }}">
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" class="form-control" placeholder="Phone number" name="data[phone]" value="{{ $employee->phone }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email" name="data[email]" value="{{ $employee->email }}">
                            <a class="btn bg-info-subtle text-info font-medium" href="mailto:{{ $employee->email }}">
                                <i class="ti ti-mail"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" data-request="onAction" data-request-data="action: 'update_profile', employee_id: {{ $employee->id }}" >
                        <i class="ti ti-check me-1"></i>
                        Update
                        
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>