@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">View Order #{{ $order->id}}</div>

                <div class="row">

                    <div class="h6 col-md-6">Customer: {{ $order->customer->name }} - {{ $order->customer->address}}</div>
                    <div class="h6 col-md-6">Product: {{ $order->product->name}}</div>
                    <div class="h6 col-md-6">Price: {{ $order->quantity }} x ${{ $order->price }} = ${{ $order->price * $order->quantity }}</div>
                    <div class="h6 col-md-6">Status: {{ $order->status }}</div>
                    @guest
                    @else
                    <div class="h6 col-md-6"><a class="btn" href="{{ url('client-orders') }}">Back</a>
                    @if (Auth::user()->is_admin && $order->status == 'paid')
                        <a class="btn" href="{{ url('complete-order', $order->id) }}" onclick="event.preventDefault();
                            document.getElementById('complete-form').submit();">Complete</a>
                        <form id="complete-form" action="{{ url('complete-order', $order->id) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endif
                    @endguest
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
