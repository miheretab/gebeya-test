@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('save-user', $user->id) }}">
                        @csrf

                        @include('users.form', compact('user'))
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
