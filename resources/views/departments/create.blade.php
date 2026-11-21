@extends('layouts.app')

@section('title', 'Departments')

@section('content')
    <div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Create department</h1>
        <form action="{{ route('departments.store') }}" method="post">
            @csrf
            @include('departments.partials._form')

            <button type="submit" class="btn btn-primary">Create department</button>
        </form>
    </div>
</div>
@endsection