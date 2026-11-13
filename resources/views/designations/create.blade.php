@extends('layouts.app')
@section('title', 'Designations')

@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Add Designation</h1>
        <form action="{{ route('designations.store') }}" method="post">
            @csrf
            @include('designations.partials._form')

            <button type="submit" class="btn btn-primary">Add Designation</button>
        </form>
    </div>
@endsection