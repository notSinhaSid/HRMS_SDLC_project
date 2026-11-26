<div class="row g-3">
    <div class="col-sm-8">
        <label for="department_name" class="form-label">Department name <span class="required">*</span></label>
        <input type="text" placeholder="e.g. Operations" name="name" id="department_name"
               value="{{ old('name', $department->name ?? '') }}"
               class="form-control @error('name') is-invalid @enderror" autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-4">
        <label for="department_code" class="form-label">Code <span class="required">*</span></label>
        <input type="text" placeholder="e.g. OPS" name="code" id="department_code"
               value="{{ old('code', $department->code ?? '') }}"
               class="form-control @error('code') is-invalid @enderror">
        @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4" placeholder="What does this department do?"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $department->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch p-3 ps-5 border rounded bg-light mb-0">
            <input type="checkbox" role="switch" name="is_active" id="is_active" value="1" class="form-check-input"
                   @checked(old('is_active', $department->is_active ?? true))>
            <label for="is_active" class="form-check-label fw-medium text-dark">Active</label>
            <div class="form-text mt-0">Inactive departments can't be picked for new employees.</div>
        </div>
    </div>
</div>
