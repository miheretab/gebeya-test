@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Products</div>

                <div class=""><a class="btn" href="{{url('add-product')}}">Add Product</a></div>
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
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>${{ $product->price }}</td>
                                <td><img src="{{ $product->image }}" alt="{{ $product->image }}" /></td>
                                <td>
                                    <a href="{{ url('edit-product', $product->id) }}">Edit</a>&nbsp;&nbsp;|&nbsp;
                                    <a href="{{ url('remove-product', $product->id) }}" onclick="event.preventDefault();
                                        document.getElementById('delete-form').submit();">Delete</a>&nbsp;&nbsp;|&nbsp;
                                    <form id="delete-form" action="{{ url('remove-product', $product->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <a href="{{ url('assign-categories', $product->id) }}">Assign Categories</a>
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
