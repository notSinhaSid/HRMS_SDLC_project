@extends('layouts.app')
@section('title', 'Add User')

@section('content')
    <x-page-header title="Add user" subtitle="A temporary password is emailed; the user must change it on first login."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Add user' => null]" />

    <form action="{{ route('users.store') }}" method="post" class="card form-card form-card-sm">
        @csrf
        <div class="card-body">
            @include('users.partials._form', ['roles' => $roles, 'user' => null])
        </div>
        <div class="card-footer">
            <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Create user</button>
        </div>
    </form>
@endsection
