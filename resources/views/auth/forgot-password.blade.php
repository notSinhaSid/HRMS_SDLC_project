@extends('layouts.app')
@section('title', 'Forget password')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}" name="email" autofocus>
                
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul> 
                </div>
                
            @endif
            
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
@endsection
