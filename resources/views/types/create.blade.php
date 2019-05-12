@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Asset Type</div>

                <div class="card-body">
                    @include('partials.errors.errors')
                    <form method="POST" action="{{ route('types.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Asset Type</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Enter type name" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Save Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
