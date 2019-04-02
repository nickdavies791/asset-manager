@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Asset Information</div>
                <div class="card-body">
                    <h3 class="mb-3">{{ $asset->name }}</h3>

                    @includeWhen($asset->type->name == 'IT Equipment', 'assets.partials.it-equipment')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Finance Records</div>
                <div class="card-body">
                    @foreach($asset->finances as $finance)
                        <table class="table table-bordered mb-3">
                            <thead>
                                <tr class="thead-light">
                                    <th colspan="3">{{ $finance->accounting_year }}</th>
                                </tr>
                                <tr>
                                    <th>Cost</th>
                                    <th>Depreciation</th>
                                    <th>Net Book Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>&pound; {{ $finance->current_value }}</td>
                                <td>&pound; {{ $finance->depreciation }}</td>
                                <td>&pound; {{ $finance->net_book_value }}</td>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
