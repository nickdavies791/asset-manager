@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create School</div>

                <div class="card-body">
                    @include('partials.errors.errors')
                    <form method="POST" action="{{ route('schools.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">School Name</label>
                            <input class="form-control" id="name" type="text" name="name" placeholder="Enter school name" value="{{ old('name')  }}" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Save School</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
