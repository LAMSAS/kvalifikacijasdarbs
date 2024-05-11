<div class="card">
    <div class="card-body">
        <div class="d-flex flex-column">
            <label class="form-label fw-semibold">
                Manager
            </label>
            <div class="d-flex align-items-center mb-1">
                <div id="avatarcontainer" class="mr-3 position-relative rounded overflow-hidden" style="width: 100px; height:100px">
                <img src="/uploads/{{ $avatars[$team->manager_id] }}" alt="" class="shadow-warning" style="width:100%; height:100%; object-fit: contain; border-radius: 15%;" id="avatar_img">
                </div>
                <h5 class="fw-semibold fs-5 " id="manager_name"></h5>
                <p class="fs-3 mb-0"></p>
            </div>
            
            
            <select class="form-select" name="manager_id" id="managerSelect">
                <option value="">Select a manager</option>
                @foreach($allManagers as $manager)
                    <option value="{{ $manager->employee->id }}" {{ $team->manager_id == $manager->employee->id ? 'selected' : ''}}>
                        {{ $manager->employee->first_name . ' ' . $manager->employee->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="d-flex align-items-center mt-3">
            <div>
                <a href="/employees/profile/{{ $manager->employee->id }}" class="btn btn-sm bg-primary-subtle" data-bs-toggle="tooltip" title="Open profile" data-request="onAction" data-request-data="action: 'open_profile', team_id: {{ $team->id }}">
                    Open profile
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var avatars = {!! json_encode($avatars) !!};
        var managerSelect = document.getElementById('managerSelect');
        managerSelect.addEventListener('change', function() {
            var selectedEmployee = this.options[this.selectedIndex].value;
            document.getElementById('avatar_img').src = '/uploads/'+avatars[selectedEmployee];
            document.getElementById('manager_name').textContent = this.options[this.selectedIndex].text;
        });

        // Set the initial manager name
        if (managerSelect.selectedIndex >= 0) {
            document.getElementById('manager_name').textContent = managerSelect.options[managerSelect.selectedIndex].text;
        }

        document.getElementById('formFile').addEventListener('change', function(event) {
            document.getElementById('form').submit();
        });
    });
</script>