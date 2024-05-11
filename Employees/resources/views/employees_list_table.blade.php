<div class="table-responsive">
    <table class="table table-nowrap table-hover table-align-middle">
        <thead class="thead-light">
        <tr>
            <th class="align-middle" style="width: 30px">
                <input type="checkbox" class="form-check-input" id="list-select-all">
            </th>
            <th>{{ 'Name' }}</th>
            <th>{{ 'Department' }}</th>
            <th>{{ 'Email' }}</th>
            <th>{{ 'Phone' }}</th>
            <th>{{ 'Status' }}</th>
            <th>{{ 'Hire date' }}</th>
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
                <!-- icon & name -->
                <td>
                    <a href="/employees/profile/{{ $listItem->id }}">
                        <div class="d-flex align-items-center">
                            <div
                                class="p-6 bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-users text-primary fs-6"></i>
                            </div>
                            <div class="">
                                <div class="user-meta-info">
                                    <h6 class="user-name mb-0">{{ $listItem-> first_name}} {{ $listItem->last_name }}</h6>
                                </div>
                                <div class="d-flex flex-column align-items-start">
                                    <div class="d-flex flex-row">
                                        <span class="badge bg-secondary-subtle text-muted rounded-pill fs-2 p-1 mt-1">
                                            <i class="ti ti-user-check text-gray fs-2"></i>
                                            {{ $listItem->position }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </td>
                <!-- department -->
                <td>
                    <span class="badge bg-secondary-subtle text-muted rounded-3 fs-4 pb-2 pt-2">
                        <i class="ti ti-building-skyscraper text-gray fs-4 me-1"></i>
                        {{ $listItem->department }}
                    </span>
                </td>
                <!-- email -->
                <td>{{ $listItem->email }}</td>
                <!-- phone -->
                <td>{{ $listItem->phone }}</td>
                <!-- status -->
                <td class="text-center">
                    @if($listItem->is_active == 1)
                        <span
                            class="circle d-inline-flex align-items-center justify-content-center rounded-circle p-2 bg-primary-subtle text-primary">
                                <i class="ti ti-check fs-4"></i>
                            </span>
                    @elseif($listItem->is_active == 0)
                        <span
                            class="circle d-inline-flex align-items-center justify-content-center rounded-circle p-2 bg-danger-subtle text-danger">
                                <i class="ti ti-x fs-4"></i>
                            </span>
                    @endif
                </td>
                <!-- hire date -->
                <td>{{ $listItem->hire_date }}</td>
                <!-- action -->
                <td class="text-end">
                    <a class="btn bg-secondary-subtle" data-bs-toggle="tooltip" title="" href="" target="_blank">
                        <i class="ti ti-link"></i>
                    </a>
                    <a href="/employees/profile/{{ $listItem->id }}" class="btn bg-primary-subtle"
                       data-bs-toggle="tooltip" title="Open profile">
                        <i class="ti ti-users"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>