@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Categories</div>

                <div class=""><a class="btn" href="{{url('add-category')}}">Add Category</a></div>
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ url('edit-category', $category->id) }}">Edit</a>&nbsp;&nbsp;|&nbsp;
                                    <a href="{{ url('remove-category', $category->id) }}" onclick="event.preventDefault();
                                        document.getElementById('delete-form').submit();">Delete</a>
                                    <form id="delete-form" action="{{ url('remove-category', $category->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
