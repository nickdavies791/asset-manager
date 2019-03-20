@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('assets.store') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Asset Information</div>
                        <div class="card-body">
                            @include('partials.errors.errors')
                            @csrf
                            <school-selector token="{{ auth()->user()->api_token }}"></school-selector>
                            <div class="row">
                                <div class="col-md-6">
                                    <type-selector token="{{ auth()->user()->api_token }}"></type-selector>
                                </div>
                                <div class="col-md-6">
                                    <category-selector token="{{ auth()->user()->api_token }}"></category-selector>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Asset Name</label>
                                        <input class="form-control" id="name" type="text" name="name" placeholder="Enter asset name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tag">Asset Tag</label>
                                        <input class="form-control" id="tag" type="text" name="tag" placeholder="Enter asset tag" required>
                                    </div>
                                </div>
                            </div>
                            <div v-if="type == 6">
                                <div class="form-group" >
                                    <label for="serial_number">Serial Number</label>
                                    <input class="form-control" id="serial_number" type="text" name="serial_number" placeholder="Enter serial number">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="make">Make</label>
                                            <input class="form-control" id="make" type="text" name="make" placeholder="Enter make">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="model">Model</label>
                                            <input class="form-control" id="model" type="text" name="model" placeholder="Enter model">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="processor">Processor</label>
                                            <input class="form-control" id="processor" type="text" name="processor" placeholder="Enter processor">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="memory">Memory/RAM</label>
                                            <input class="form-control" id="memory" type="text" name="memory" placeholder="Enter memory">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="storage">Storage (HDD/SSD)</label>
                                            <input class="form-control" id="storage" type="text" name="storage" placeholder="Enter storage">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="operating_system">Operating System</label>
                                            <input class="form-control" id="operating_system" type="text" name="operating_system" placeholder="Enter operating system">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="warranty">Warranty Information</label>
                                    <textarea class="form-control" id="warranty" name="warranty" placeholder="Enter warranty information"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes">Additional Notes</label>
                                <textarea class="form-control" id="notes" name="notes" placeholder="Enter additional notes"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Finance Information</div>
                        <div class="card-body">
                            <create-asset-finance></create-asset-finance>
                            <button class="btn btn-primary" type="submit">Save Asset</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection