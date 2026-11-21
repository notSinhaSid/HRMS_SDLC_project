@extends('layouts.app')
@section('title', 'Departments')

@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Edit department</h1>
        <form action="{{ route('departments.update', $department) }}" method="post">
            @csrf
            @method('PATCH')
            @include('departments.partials._form')

            <button type="submit" class="btn btn-primary">Update department</button>
        </form>
    </div>
@endsection