@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Category') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('create-category') }}">
                        @csrf

                        @include('categories.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
