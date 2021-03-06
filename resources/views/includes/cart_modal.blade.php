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
                        <td><a class="btn" href="{{ url('remove-from-cart', $order['product']->slug) }}{{ isset($category) ? '/'. $category->slug : ''}}" onclick="event.preventDefault();
                            document.getElementById('remove-cart-form-{{$order['product']->id}}').submit();">Remove from cart</a>
                        <form id="remove-cart-form-{{$order['product']->id}}" action="{{ url('remove-from-cart', $order['product']->slug) }}{{ isset($category) ? '/'. $category->slug : ''}}" method="POST" class="d-none">
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