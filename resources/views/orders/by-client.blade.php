@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Orders</div>

                <div class="table">

                    <table class="table responsive stripe">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ date('M d, Y h:m A', strtotime($order->created_at)) }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->customer->id }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>${{ $order->price }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <a href="{{ url('view-order', $order->id) }}">View</a>
                                    @if ($order->status == 'paid')
                                    &nbsp;&nbsp;|&nbsp;
                                    <a href="{{ url('complete-order', $order->id) }}" onclick="event.preventDefault();
                                        document.getElementById('complete-form-{{$order->id}}').submit();">Complete</a>
                                    <form id="complete-form-{{$order->id}}" action="{{ url('complete-order', $order->id) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    @endif
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
