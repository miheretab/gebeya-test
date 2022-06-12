@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Product') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('save-product', $product->id) }}">
                        @csrf

                        @include('products.form', compact('product'))
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
