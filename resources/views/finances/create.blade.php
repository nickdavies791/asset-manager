@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('finances.store', ['id' => Request()->asset]) }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Finance Information</div>
                        <div class="card-body">
                            @include('partials.errors.errors')
                            <input type="hidden" name="asset_id" value="{{ Request()->asset['id'] }}">
                            <create-asset-finance :old="{{ $finance }}"></create-asset-finance>
                            <button class="btn btn-primary" type="submit">Save Asset</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection