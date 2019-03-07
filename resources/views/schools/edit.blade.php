@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update School</div>

                <div class="card-body">
                    <form>
                        <input type="text" name="school" placeholder="Enter school name" value="{{ $school->name }}">
                        <button type="submit">Save School</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
