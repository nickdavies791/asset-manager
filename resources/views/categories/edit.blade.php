@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Category</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('categories.update', ['id' => $category->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" placeholder="Enter category name" value="{{ $category->name }}">
                        <button type="submit">Save Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
