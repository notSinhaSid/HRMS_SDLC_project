@error('message')
    <div class="alert alert-danger">
        {{ $message }}
    </div>
@enderror

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    
@endif