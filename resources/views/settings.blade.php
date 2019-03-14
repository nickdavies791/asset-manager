@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Settings</div>

                <div class="card-body">
                    <a href="{{ route('schools.create') }}" class="btn btn-primary">Create School</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
