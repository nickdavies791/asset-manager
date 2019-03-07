@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Asset</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('assets.update', ['id' => $asset->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" placeholder="Enter asset name" value="{{ $asset->name }}">
                        <button type="submit">Save Asset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
