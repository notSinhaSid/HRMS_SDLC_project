@extends('layouts.app')
@section('title', 'Edit Department')

@section('content')
    <x-page-header title="Edit department" :subtitle="$department->name"
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Departments' => route('departments.index'), 'Edit' => null]" />

    <form action="{{ route('departments.update', $department) }}" method="post" class="card form-card form-card-sm">
        @csrf
        @method('PATCH')
        <div class="card-body">
            @include('departments.partials._form')
        </div>
        <div class="card-footer">
            <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Save changes</button>
        </div>
    </form>
@endsection
