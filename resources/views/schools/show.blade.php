@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $school->name }}</div>

                <div class="card-body">
                    <a class="btn btn-primary" href="{{ route('schools.assets', ['id' => $school->id]) }}">View Assets</a>
                    <a class="btn btn-primary" href="{{ route('assets.create') }}">Add an Asset</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
