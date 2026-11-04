@extends('layouts.app')
@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Create user</h1>
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            @include('users.partials._form', ['roles' => $roles, 'user' => null])

            <button type="submit" class="btn btn-primary">Create user</button>
        </form>
    </div>
</div>
@endsection