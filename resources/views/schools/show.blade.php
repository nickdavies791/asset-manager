@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">School</div>

                <div class="card-body">
                    {{ $school->name }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
