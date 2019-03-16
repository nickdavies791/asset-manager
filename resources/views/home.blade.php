@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @can('create', App\Asset::class)
                        <a class="btn btn-primary" href="{{ route('assets.create') }}">Add Asset</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
