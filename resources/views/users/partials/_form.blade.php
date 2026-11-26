<div class="mb-3">
    <label for="name" class="form-label">Full name <span class="required">*</span></label>
    <input type="text" name="name" id="name" placeholder="e.g. Priya Sharma" value="{{ old('name', $user->name ?? '') }}"
           class="form-control @error('name') is-invalid @enderror" autofocus>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email <span class="required">*</span></label>
    <div class="input-group has-validation">
        <span class="input-group-text bg-white"><i class="bi bi-envelope text-secondary"></i></span>
        <input type="email" id="email" name="email" placeholder="employee@company.com" value="{{ old('email', $user->email ?? '') }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div>
    <label for="role_id" class="form-label">Role <span class="required">*</span></label>
    <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror">
        <option value="">Select a role</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)><x-role-label :role="$role->name" /></option>
        @endforeach
    </select>
    @error('role_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">You can only assign roles below your own.</div>
</div>
