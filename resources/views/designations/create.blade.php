@extends('layouts.app')
@section('title', 'Add Designation')

@section('content')
    <x-page-header title="Add designation"
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Designations' => route('designations.index'), 'Add' => null]" />

    <form action="{{ route('designations.store') }}" method="post" class="card form-card form-card-sm">
        @csrf
        <div class="card-body">
            @include('designations.partials._form')
        </div>
        <div class="card-footer">
            <a href="{{ route('designations.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Add designation</button>
        </div>
    </form>
@endsection
