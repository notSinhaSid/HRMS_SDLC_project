<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name" placeholder="Name" value="{{ old('name', $user->name ?? '') }}" class="form-control @error('name')
        is-invalid
    @enderror">
    @error('name')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" placeholder="employee@email.com" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control @error('email')
        is-invalid
    @enderror">
    @error('email')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="mb-3">
    <label for="role_id">Assign role</label>
    <select name="role_id" id="role_id" class="form-select @error('role_id')
        is-invalid
    @enderror">
        <option value="">Select option</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>{{$role->name}}</option>
        @endforeach
    </select>
    @error('role_id')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>