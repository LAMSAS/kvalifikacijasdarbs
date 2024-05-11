<form>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <div id="avatarcontainer" class="position-relative" style="width: 90px; height:90px;">
                    <img src="{{ $avatar_b64}}" alt="" class="shadow-warning" style="width:100%; height:100%; object-fit: contain; border-radius: 15%; background-color: #F9F9F9;" id="avatar_img">
                    @if ($avatar_uploaded)                 
                        <button id="deleteButton" class="btn position-absolute top-0 end-1 translate-middle p-0 mt-1" type="submit" data-request="onSaveAvatar" style="transform: translate(70%, 50%);">
                            <i class="ti ti-xbox-x fs-5"></i>
                        </button>
                    @endif
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="fw-semibold fs-5 ">
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </h5>
                    <p class="fs-3 mb-0"></p>
                </div>
            </div>
            <div class="row" id="my-form-container">
                <div class="col-md-12">
                    <input name="modelId" type="hidden" value="{{ $employee->id }}">
                    <label class="form-label" for="formFile"></label> <br>
                    <div id="avatar_controls" class="d-flex justify-content-center gap-1">
                        @if(!$avatar_uploaded)
                            @include('employees::partials.avatar_control_upload')
                        @else
                            @include('employees::partials.avatar_control_change')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Team</h5>
            <div class="row">  <div class="col-md-12 mt-2">
               
                <div class="col-md-12 mt-1">
                    <div class="">
                        <select class="form-select" name="team_id">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ $employee->team_id == $team->id ? 'selected' : '' }}>{{ $team->title }}</option>
                            @endforeach
                        </select>
                        <div class="text-center mt-3">
                            <button id="updateTeamButton" class="btn btn-primary mt-2" data-request="onAction" data-request-data="action: 'change_team', employee_id: {{ $employee->id }}">Update Team</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('formFile').addEventListener('change', function(event) {
            document.getElementById('form').submit();
        });
    });
    
</script>