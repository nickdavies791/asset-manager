@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Assets</div>

                <div class="card-body">
                    @foreach($assets as $asset)
                        <a href="{{ route('assets.show', ['id' => $asset->id]) }}">{{ $asset->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
