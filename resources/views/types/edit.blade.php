@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Asset Type</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('types.update', ['id' => $type->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" placeholder="Enter type name" value="{{ $type->name }}">
                        <button type="submit">Save Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
