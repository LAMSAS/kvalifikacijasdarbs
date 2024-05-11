<form data-request="onSetFilters">
    <div class="row">
        <div class="col-md-12 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">Name</label>
            <input type="text" class="form-control" name="filters[first_name][like]" value="{{ isset($filters['first_name']['like']) ? $filters['first_name']['like'] : '' }}">
        </div>
        <div class="col-md-12 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">Department:</label>
            <select class="form-select" name="filters[department]">
                <option value="">Select a department</option>
                @foreach(DB::table('employees')->select('department')->groupBy('department')->get() as $listItem)
                    <option value="{{ $listItem->department }}" {{ isset($filters['department']) && $filters['department'] == $listItem->department ? 'selected' : '' }}>
                        {{ $listItem->department }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-4">
            <label for="exampleInputtext" class="form-label fw-semibold">Position</label>
            <select class="form-select" name="filters[position]">
                <option value="">Select a position</option>
                @foreach(DB::table('employees')->select('position')->groupBy('position')->get() as $listItem)
                    <option value="{{ $listItem->position }}" {{ isset($filters['position']) && $filters['position'] == $listItem->position ? 'selected' : '' }}>
                        {{ $listItem->position }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12 mb-4">
          <label for="exampleInputtext" class="form-label fw-semibold">Status</label>
          <select class="form-select" name="filters[is_active]">
            <option value="">Select a status</option>
            @foreach(DB::table('employees')->select('is_active')->groupBy('is_active')->get() as $listItem)
              <option value="{{ $listItem->is_active }}" {{ isset($filters['is_active']) && $filters['is_active'] == $listItem->is_active ? 'selected' : '' }}>
                {{ $listItem->is_active ? 'Active' : 'Inactive'}}  
              </option>
            @endforeach
          </select>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <button type="submit" class="btn btn-light-primary">
            <i class="ti ti-adjustments"></i>
            Filter
        </button>
    </div>
</form>