@extends('layouts.app')
@section('title', 'Add Department')

@section('content')
    <x-page-header title="Add department" subtitle="Give the team a name and a short unique code."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Departments' => route('departments.index'), 'Add' => null]" />

    <form action="{{ route('departments.store') }}" method="post" class="card form-card form-card-sm">
        @csrf
        <div class="card-body">
            @include('departments.partials._form')
        </div>
        <div class="card-footer">
            <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Create department</button>
        </div>
    </form>
@endsection
