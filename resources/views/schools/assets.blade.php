@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Assets</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Tag</th>
                            <th>Type</th>
                            <th>Category</th>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr>
                                    <td><a href="{{ route('assets.show', ['id' => $asset->id]) }}">{{ $asset->name }}</a></td>
                                    <td>{{ $asset->tag }}</td>
                                    <td>{{ $asset->type->name }}</td>
                                    <td>{{ $asset->category->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
