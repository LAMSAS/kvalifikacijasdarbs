<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-3">Basic information</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Title
                    </label>
                    <input type="text" class="form-control"  placeholder="Title" name="data[title]" value="{{ $team->title }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="initials" class="form-label fw-semibold">Initials</label>
                    <input type="text" id="initials" name="data[initials]" class="form-control" placeholder="Enter initials" value="{{ $team->initials }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Status
                    </label>
                    <select class="form-select" name="data[is_active]" id="statusSelect">
                        @foreach([['id' => '', 'value' => 'Any'],
                                  ['id' => '1', 'value' => 'Active'],
                                  ['id' => '0', 'value' => 'Not active']] as $item)
                            <option value="{{ $item['id'] }}"
                                {{
                                    $team->is_active== $item['id'] ? 'selected': ''
                                   }}
                            >
                                {{ $item['value'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Color
                    </label>
                    <select class="form-select" name="data[color]" id="colorSelect">
                        <option value="">Select a color</option>
                        @foreach($allTeamsTypes as $listItem)
                            <option value="{{ $listItem->id }}"
                                {{
                                    $team->teamType->id == $listItem->id ? 'selected': ''
                                   }}
                            >
                                {{ $listItem->color }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary" data-request="onAction" data-request-data="action: 'update_profile', team_id: {{ $team->id }}">
                    <i class="ti ti-check me-1"></i>
                    Update
                </button>
            </div>
        </div>
    </div>
</div>