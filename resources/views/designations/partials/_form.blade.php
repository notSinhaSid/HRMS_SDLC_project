<div class="mb-3">
    <label for="name" class="form-label">Designation Name</label>
    <input type="text" placeholder="Designation name" class="form-control @error('name')
        is-invalid
    @enderror" value="{{ old('name', $designation->name ?? '') }}" name="name" id="name" autofocus>
    @error('name')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>