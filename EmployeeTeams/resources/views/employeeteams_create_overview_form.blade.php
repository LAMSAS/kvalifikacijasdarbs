    <div class="card">
    <div class="card-body">
        {{-- Basic information --}}
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-3">Basic information</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" class="form-control" placeholder="Team Name" name="data[title]" value="" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="filterProjectId" class="form-label">Is active</label>
                <div class="form-check form-switch">
                    <input type="hidden" name="data[is_active]" value="0">
                    <input type="checkbox" class="form-check-input" name="data[is_active]" value="1">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Team Type</label>

                    <select class="form-select" name="data[team_type_id]">
                        <option value="">Select a team</option>
                        @foreach($allTeamTypes as $teamType)
                            <option value="{{ $teamType->id }}">{{ $teamType->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Manager</label>
                    <select class="form-select" name="data[manager_id]">
                        <option value="">Select a manager</option>
                        @foreach($allManagers as $manager)
                            <option value="{{ $manager->employee->id }}">{{ $manager->employee->first_name. ' ' . $manager->employee->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="text-center">
            <div class="d-inline-block">
                <div class="mb-3">
                    <a href="/employees-teams">
                        <button class="btn bg-secondary-subtle text-muted me-2" type="button">
                            <i class="ti ti-times"></i>
                            {{ 'Back' }}
                        </button>
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>
                        Create
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
