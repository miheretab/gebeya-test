@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Admin') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('save-admin') }}">
                        @csrf

                        @include('users.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
