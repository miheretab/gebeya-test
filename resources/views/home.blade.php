@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in{{isset($impersonateUser) ? ' as ' . $impersonateUser->name : ''}}!
                </div>
                @if (isset($client))
                <div class="table">

                    <table class="table responsive stripe">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client['orders'] as $order)
                            <tr>
                                <td>{{ $client['products'][$order->product_id] }}</td>
                                <td>{{ $order->total }}</td>
                                <td>${{ $order->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
