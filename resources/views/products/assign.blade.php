@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Assign Categories') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('assigning-categories', $product->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="categories" class="col-md-4 col-form-label text-md-right">{{ __('Categories') }}</label>

                            <div class="col-md-6">
                                <select id="categories" multiple class="form-control" name="categories[]" autofocus>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, $assignedIds) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-sm-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
