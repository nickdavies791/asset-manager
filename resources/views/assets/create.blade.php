@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Asset</div>

                <div class="card-body">
                    @include('partials.errors.errors')
                    <form method="POST" action="{{ route('assets.store') }}">
                        @csrf
                        <school-selector token="{{ auth()->user()->api_token }}"></school-selector>
                        <type-selector token="{{ auth()->user()->api_token }}"></type-selector>
                        <category-selector token="{{ auth()->user()->api_token }}"></category-selector>
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
                            <textarea class="form-control" id="notes" name="notes" placeholder="Enter notes information"></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Save Asset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection