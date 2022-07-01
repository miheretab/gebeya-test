@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Stores') }}</div>

                <div class="card-body">

                <div class="table">

                    <table class="table responsive stripe">
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td><a href="{{ url('store', $client->id) }}">{{ $client->name }}</a> - Store [{{ $client->id }}]</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
