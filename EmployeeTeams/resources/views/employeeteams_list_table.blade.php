<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="table-layout:fixed;">
                    <table class="table table-nowrap table-hover table-align-middle">
                        <thead class="thead-light">
                        <tr>
                            <th class="align-middle" style="width: 5%;">
                                <input type="checkbox" class="form-check-input" id="list-select-all">
                            </th>
                            <th style="width: 25%;">{{ 'Title' }}</th>
                            <th style="width: 5%;">{{ 'Manager' }}</th>
                            <th style="width: 5%;" class="text-center">{{ 'Active' }}</th>
                            <th class="text-center" style="width: 20%;">{{ 'Employee count' }}</th>
                            <th class="text-center">{{ 'Action' }}</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        @foreach ($listItems as $listItem)
                            <tr id="list-row-{{ $listItem->id }}" data-request-data="listItem: {{ $listItem->id }}"
                                class="align-middle">
                                <!-- checkbox -->
                                <td class="align-middle">
                                    <input type="checkbox" class="form-check-input" id="check-{{ $listItem->id }}">
                                </td>
                                <!-- icon & title -->
                                <td style='width: 25%'>
                                    <a href="/employees-teams/profile/{{ $listItem->id }}">
                                        <div class="d-flex align-items-center">
                                        <div class="p-6 rounded-circle me-3 d-flex align-items-center justify-content-center text-white" style="background-color: {{$listItem->teamType->color}}; width: 30px; height: 30px;">
                                                @if(isset($listItem->initials))
                                                    <h6 class="m-0" style="font-size: 0.8em;"> {{$listItem->initials}}</h6>
                                                @endif
                                            </div>

                                            <div class="">
                                                <div class="user-meta-info">
                                                    <h6 class="user-name mb-0">{{ $listItem->title}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td style='width: 20%'>
                                    <a href="/employees/profile/{{ $listItem->manager_id }}">
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 bg-secondary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-user text-muted fs-5"></i>
                                            </div>
                                            <div class="">
                                                <div class="user-meta-info">
                                                    <h6 class="user-name mb-0">{{
                                                        $listItem->employee->first_name . ' '.
                                                        $listItem->employee->last_name}}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <!-- is active -->
                                <td class="text-center" style='width: 10%'>
                                    @if($listItem->is_active)
                                        <span
                                            class="circle d-inline-flex align-items-center justify-content-center rounded-circle p-2 bg-primary-subtle text-primary">
                                                <i class="ti ti-check fs-4"></i>
                                            </span>
                                    @else
                                        <span
                                            class="circle d-inline-flex align-items-center justify-content-center rounded-circle p-2 bg-danger-subtle text-danger">
                                                <i class="ti ti-x fs-4"></i>
                                            </span>
                                    @endif
                                </td>
                                <!-- employee count -->
                                <td class="text-center text-wrap" style='width: 15%'>{{ $listItem->employee_count }}</td>
                                <!-- action -->
                                <td class="text-center">
                                    <a class="btn btn-sm bg-secondary-subtle" data-bs-toggle="tooltip" title="" href="" target="_blank">
                                        <i class="ti ti-link"></i>
                                    </a>
                                    <a href="/employees-groups/profile/{{ $listItem->id }}" class="btn btn-sm bg-primary-subtle"
                                    data-bs-toggle="tooltip" title="Open profile">
                                        <i class="ti ti-users-group"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>