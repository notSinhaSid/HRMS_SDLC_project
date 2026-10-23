<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile| Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <form action="{{ route('password.change.update') }}" method="post">
            @csrf
                <div class="form-group">
                  <label for="current_password">Current Password</label>
                  <input type="password" name="current_password" id="current_password" class="@error('current_password') is-invalid @enderror form-control">
                  
                  @error('current_password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="password">New Password</label>
                  <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control">
                  
                  @error('password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
                <div class="form-group">
                  <label for="password_confirmation">Confirm New Password</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
              </div>

                <button type="submit" class="btn btn-md btn-outline-success">Change password</button>
            
        </form>

        <form action="{{ route('logout') }}" method="post">
        <button type="submit">
            logout button
        </button>
    </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>