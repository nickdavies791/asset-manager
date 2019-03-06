@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Schools</div>

                <div class="card-body">
                    @foreach($schools as $school)
                        <a href="{{ route('schools.show', ['id' => $school->id]) }}">{{ $school->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
