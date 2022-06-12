@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Profile</div>

                <div class="row">
                    @if (session('status'))
                        <div class="alert alert-success col-md-12" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger col-md-12" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="h6 col-md-6">Name: {{ $user->name }}</div>
                    <div class="h6 col-md-6">Email: {{ $user->email }}</div>
                    <div class="col-md-12"><a class="btn" href="{{url('profile-edit')}}">Edit</a></div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
