@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Category') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('save-category', $category->id) }}">
                        @csrf

                        @include('categories.form', compact('category'))
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
