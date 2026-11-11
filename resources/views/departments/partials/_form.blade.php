<div class="mb-3">
    <label for="department_name" class="form-label">Department name</label>
    <input type="text" placeholder="department name" name="name" value="{{ old('name', $department->name ?? '') }}" id="department_name" class="form-control @error('name')
        is-invalid
    @enderror" autofocus>
    @error('name')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="department_code" class="form-label">Department code</label>
    <input type="text" placeholder="department code" name="code" value="{{ old('code', $department->code ?? '') }}" id="department_code" class="form-control @error('code')
        is-invalid
    @enderror">
    @error('code')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" cols="20" rows="5" placeholder="short description about the department" class="form-control @error('description')
        is-invalid
    @enderror">{{ old('description', $department->description ?? '') }}</textarea>
    @error('description')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3 form-check-label">
    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" @checked(old('is_active', $department->is_active ?? true)) value="1">
    <label for="is_active" class="form-label">Department status</label>
</div>

