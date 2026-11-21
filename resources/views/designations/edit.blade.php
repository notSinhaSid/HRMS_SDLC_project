@extends('layouts.app')
@section('title', 'Designations')

@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Edit Designation</h1>
        <form action="{{ route('designations.update', $designation) }}" method="post">
            @csrf
            @method('PATCH')
            @include('designations.partials._form')

            <button type="submit" class="btn btn-primary">Update Designation</button>
        </form>
    </div>
@endsection