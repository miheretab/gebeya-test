@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">Checkout Page</div>
                  @if (isset($cart['orders']) && !empty($cart['orders']))
                    <div class="table">
                        <table class="table responsive stripe">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0;
                                @endphp
                                @foreach($cart['orders'] as $order)
                                <tr>
                                    <td>{{ $order['product']->name }}</td>
                                    <td>{{ $order['quantity'] }}</td>
                                    <td>${{ $order['product']->price }}</td>
                                    <td>${{ $order['product']->price * $order['quantity'] }}</td>
                                @php
                                $total += $order['product']->price * $order['quantity'];
                                @endphp
                                </tr>
                                @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td>${{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  @endif
                <form id="cart-form" action="{{ url('go-checkout') }}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" {{isset($success) ? 'disabled' : ''}} class="form-control" name="name" value="{{ isset($cart['customer']) ? $cart['customer']->name : '' }}" required autocomplete="name">
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                        <div class="col-md-6">
                            <input id="address" type="text" {{isset($success) ? 'disabled' : ''}} class="form-control" name="address" value="{{ isset($cart['customer']) ? $cart['customer']->address : '' }}" required autocomplete="address">
                        </div>

                    </div>

                    @if (isset($success) && $cart['customer'])
                        Thank You. Your order id is #{{ $cart['customer']->id }}
                    @else
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
