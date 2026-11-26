<label for="name" class="form-label">Designation name <span class="required">*</span></label>
<input type="text" placeholder="e.g. Software Engineer" name="name" id="name"
       value="{{ old('name', $designation->name ?? '') }}"
       class="form-control @error('name') is-invalid @enderror" autofocus>
@error('name')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
