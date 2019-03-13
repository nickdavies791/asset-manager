@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('alert.danger'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('alert.danger') }}
                        </div>
                    @endif

                    @forelse($schools as $school)
                        <a href="{{ route('schools.show', ['id' => $school->id]) }}">{{ $school->name }}</a><br />
                    @empty
                        You are not associated with any schools.
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
