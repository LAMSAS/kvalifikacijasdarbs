<form data-request="onSetFilters">
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="name" class="form-label fw-semibold">Name</label>
            <input type="text" class="form-control" name="filters[title][like]" id="name"
                   value="{{ $filters['title']['like'] ?? '' }}">
        </div>

        <div class="col-md-12 mb-4">
            <label for="managerSelect" class="form-label fw-semibold">Manager</label>
            <select class="form-select" name="filters[manager_id][is]" id="managerSelect">
                <option value="">Select a manager</option>
                @foreach($allManagers as $manager)
                    <option value="{{ $manager->employee->id }}" {{ isset($filters['manager_id']) && $filters['manager_id'] == $manager->manager_id ? 'selected' : '' }}
                        {{ ($filters['manager_id']['is'] ?? '') == $manager->employee->id ? 'selected' : ''}}
                    >
                        {{ $manager->employee->first_name . ' ' . $manager->employee->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-4">
            <label for="colorSelect" class="form-label fw-semibold">Color</label>
            <select class="form-select" name="filters[team_type_id][is]" id="colorSelect">
                <option value="">Select a color</option>
                @foreach($employeeTeamsTypes as $listItem)
                    <option value="{{ $listItem->id }}" {{ isset($filters['team_type_id']) && $filters['team_type_id'] == $listItem->team_type_id ? 'selected' : '' }}
                        {{
                            ($filters['team_type_id']['is'] ?? '') == $listItem->id ? 'selected': ''
                           }}
                    >
                        {{ $listItem->color }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="row pe-0">
            <div class="col-md-3 mb-4">
                <label for="employee_count_min" class="form-label fw-semibold">Employee count</label>
                <input type="text" class="form-control" id="employee_count_min" name="filters[employee_count][min]"
                       placeholder="From" value="{{$filters['employee_count']['min'] ?? ''}}">
            </div>
            <div class="col-md-3 mb-4">
                <label for="employee_count_max" class="form-label fw-semibold "></label>
                <input type="text" class="form-control mt-2" id="employee_count_max" name="filters[employee_count][max]"
                       placeholder="To" value="{{$filters['employee_count']['max'] ?? ''}}">
            </div>
            <div class="col-md-6 mb-4 pe-0">
                <label for="statusSelect" class="form-label fw-semibold">Status</label>
                <select class="form-select" name="filters[is_active][is]" id="statusSelect">
                    @foreach([['id' => '', 'value' => 'Any'],
                              ['id' => '1', 'value' => 'Active'],
                              ['id' => '0', 'value' => 'Not active']] as $item)
                        <option value="{{ $item['id'] }}"
                                {{
                                    ($filters['is_active']['is'] ?? '') == $item['id'] ? 'selected': ''
                                   }}
                        >
                            {{ $item['value'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>


    </div>

    <div class="text-center">
        <div class="d-inline-block">
            <div class="mb-3">
                <button class="btn bg-secondary-subtle text-muted me-2" type="button" data-request="onUnsetFilters">
                    <i class="ti ti-times"></i>
                    {{ 'Cancel filter' }}
                </button>
                <button type="submit" class="btn bg-primary-subtle text-primary" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i class="ti ti-adjustments"></i>
                    Filter&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                </button>
            </div>
        </div>
    </div>
</form>