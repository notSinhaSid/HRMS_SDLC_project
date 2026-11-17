<div class="mb-3">
    <label for="department_id" class="form-select-label">Department</label>
    <select name="department_id" id="department_id" class="form-select @error('department_id')
        is-invalid
    @enderror">
        <option value="" unselectable>Not assigned yet</option>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? '') == $department->id)>{{$department->name}}</option>
        @endforeach
    </select>
    @error('department_id')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="designation_id" class="form-select-label">Designation</label>
    <select name="designation_id" id="designation_id" class="form-select @error('designation_id')
        is-invalid
    @enderror">
        <option value="" unselectable>Not assigned yet</option>
        @foreach ($designations as $designation)
            <option value="{{ $designation->id }}" @selected(old('designation_id', $employee->designation_id ?? '') == $designation->id)>{{$designation->name}}</option>
        @endforeach
    </select>
    @error('designation_id')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="number" name="phone" id="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="form-control @error('phone')
        is-invalid
    @enderror">
    @error('phone')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" name="address" id="address" value="{{ old('address', $employee->address ?? '') }}" class="form-control @error('address')
        is-invalid
    @enderror">
    @error('address')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label d-block">Gender</label>

    @foreach (['male' => 'Male', 'female' => 'Female', 'others' => 'Others'] as $value => $label)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender"
                   id="gender_{{ $value }}" value="{{ $value }}"
                   @checked(old('gender', $employee->gender ?? '') === $value)>
            <label class="form-check-label" for="gender_{{ $value }}">{{ $label }}</label>
        </div>
    @endforeach

    @error('gender')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label for="date_of_birth" class="form-date-label">Date of birth</label>
    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $employee?->date_of_birth?->format('Y-m-d')) }}" class="form-control @error('date_of_birth')
        is-invalid
    @enderror">
    @error('date_of_birth')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="mb-3">
    <label for="date_of_joining" class="form-date-label">Date of Joining</label>
    <input type="date" name="date_of_joining" id="date_of_joining" value="{{ old('date_of_joining', $employee?->date_of_joining?->format('Y-m-d')) }}" class="form-control @error('date_of_joining')
        is-invaild
    @enderror">
    @error('date_of_joining')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
