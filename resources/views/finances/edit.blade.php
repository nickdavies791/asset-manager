@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('finances.update', ['id' => $finance->id]) }}">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Update {{ $finance->accounting_year }} Finance</div>
                        <div class="card-body">
                            @include('partials.errors.errors')
                            <create-asset-finance :old="{{ $finance }}"></create-asset-finance>
                            <button class="btn btn-primary" type="submit">Save Finance</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection