@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create School</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('schools.store') }}">
                        @csrf
                        <input type="text" name="name" placeholder="Enter school name">
                        <button type="submit">Save School</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
