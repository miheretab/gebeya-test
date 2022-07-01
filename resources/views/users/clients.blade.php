@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Clients</div>

                <div class="table">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table responsive stripe">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ url('edit-user', $user->id) }}">Edit</a>&nbsp;&nbsp;|&nbsp;
                                    <a href="{{ url('switch-user', $user->id) }}" onclick="event.preventDefault();
                                        document.getElementById('switch-form-{{$user->id}}').submit();">{{ !$user->active ? 'Activate' : 'Deactivate'}} Store</a>&nbsp;&nbsp;|&nbsp;
                                    <form id="switch-form-{{$user->id}}" action="{{ url('switch-user', $user->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <a href="{{ url('remove-user', $user->id) }}" onclick="event.preventDefault();
                                        document.getElementById('delete-form-{{$user->id}}').submit();">Delete Store</a>&nbsp;&nbsp;|&nbsp;
                                    <form id="delete-form-{{$user->id}}" action="{{ url('remove-user', $user->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <a href="{{ route('autologin', $user->id) }}">Auto Login</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
