@extends('layouts.app')
@section('title', 'Edit Designation')

@section('content')
    <x-page-header title="Edit designation" :subtitle="$designation->name"
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Designations' => route('designations.index'), 'Edit' => null]" />

    <form action="{{ route('designations.update', $designation) }}" method="post" class="card form-card form-card-sm">
        @csrf
        @method('PATCH')
        <div class="card-body">
            @include('designations.partials._form')
        </div>
        <div class="card-footer">
            <a href="{{ route('designations.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Save changes</button>
        </div>
    </form>
@endsection
