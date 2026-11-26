<div class="form-section-title">Employment</div>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label for="department_id" class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
            <option value="">Not assigned yet</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? '') == $department->id)>{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="designation_id" class="form-label">Designation</label>
        <select name="designation_id" id="designation_id" class="form-select @error('designation_id') is-invalid @enderror">
            <option value="">Not assigned yet</option>
            @foreach ($designations as $designation)
                <option value="{{ $designation->id }}" @selected(old('designation_id', $employee->designation_id ?? '') == $designation->id)>{{ $designation->name }}</option>
            @endforeach
        </select>
        @error('designation_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="date_of_joining" class="form-label">Date of joining <span class="required">*</span></label>
        <input type="date" name="date_of_joining" id="date_of_joining"
               value="{{ old('date_of_joining', $employee?->date_of_joining?->format('Y-m-d')) }}"
               class="form-control @error('date_of_joining') is-invalid @enderror">
        @error('date_of_joining')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-section-title">Personal details</div>
<div class="row g-3">
    <div class="col-md-6">
        <label for="phone" class="form-label">Phone</label>
        <div class="input-group has-validation">
            <span class="input-group-text bg-white"><i class="bi bi-telephone text-secondary"></i></span>
            <input type="tel" inputmode="numeric" name="phone" id="phone" placeholder="10-digit mobile number"
                   value="{{ old('phone', $employee->phone ?? '') }}"
                   class="form-control @error('phone') is-invalid @enderror">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="date_of_birth" class="form-label">Date of birth</label>
        <input type="date" name="date_of_birth" id="date_of_birth"
               value="{{ old('date_of_birth', $employee?->date_of_birth?->format('Y-m-d')) }}"
               class="form-control @error('date_of_birth') is-invalid @enderror">
        @error('date_of_birth')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" id="address" placeholder="Street, city, state"
               value="{{ old('address', $employee->address ?? '') }}"
               class="form-control @error('address') is-invalid @enderror">
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label d-block">Gender</label>
        <div class="choice-group" role="group" aria-label="Gender">
            @foreach (['male' => 'Male', 'female' => 'Female', 'others' => 'Others'] as $value => $label)
                <input type="radio" class="btn-check" name="gender" id="gender_{{ $value }}" value="{{ $value }}" autocomplete="off"
                       @checked(old('gender', $employee->gender ?? '') === $value)>
                <label class="btn btn-outline-secondary btn-sm" for="gender_{{ $value }}">{{ $label }}</label>
            @endforeach
        </div>
        @error('gender')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>
