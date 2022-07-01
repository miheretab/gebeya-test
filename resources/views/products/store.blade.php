@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="h1">{{ 'Store / ' . $client->id }} {{ isset($category) ? '/ ' . ($category->slug ?: $category->id)  : '' }}</div>

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
                                <td><img src="/{{ $product->image }}" height="100px" alt="{{ $product->image }}" /></td>
                                <td>
                                    <a class="btn" href="{{ url(isset($category) ? 'store-cat' : 'store', $client->id) }}{{ isset($category) ? '/' . $category->id  : '' }}/{{ $product->id }}" >View</a>
                                    @if ($product->quantity > 0)
                                    <a class="btn" data-mdb-toggle="modal" data-mdb-target="#cartModal" href="#" onclick="event.preventDefault();
                                        document.getElementById('cart-form').setAttribute('action', '{{ url('add-to-cart', $product->id) }}{{ isset($category) ? '/'. $category->id : ''}}');
                                        document.getElementById('product-name').textContent = '{{ $product->name }}'" >Add to cart</a>
                                    @else
                                    Sold Out!
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

<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartModalLabel">Are you sure you want to add <span id="product-name"></span> to cart?</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      @if (isset($cart['orders']) && !empty($cart['orders']))
        <div class="table">
            <table class="table responsive stripe">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart['orders'] as $order)
                    <tr>
                        <td>{{ $order['product']->name }}</td>
                        <td>{{ $order['quantity'] }}</td>
                        <td><a class="btn" href="{{ url('remove-from-cart', $order['product']->id) }}{{ isset($category) ? '/'. $category->id : ''}}" onclick="event.preventDefault();
                            document.getElementById('remove-cart-form').submit();">Remove from cart</a>
                        <form id="remove-cart-form" action="{{ url('remove-from-cart', $order['product']->id) }}{{ isset($category) ? '/'. $category->id : ''}}" method="POST" class="d-none">
                            @csrf
                        </form></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      @endif
        <form id="cart-form" action="{{ url('add-to-cart') }}" method="POST" >
            @csrf
            <div class="form-group row">
                <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                <div class="col-md-6">
                    <input id="quantity" type="number" class="form-control" name="quantity" value="1" required autocomplete="quantity">

                    @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
            document.getElementById('cart-form').submit();">Yes</button>
      </div>
    </div>
  </div>
</div>
@endsection
