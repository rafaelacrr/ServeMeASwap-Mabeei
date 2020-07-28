@extends('layouts.app')

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card card--section">
        <div class="card-header">Create a new Swap</div>
        <div class="card-body">
            <form role="form" method="POST" action="{{ route('addSwap') }}">
              <input type="hidden" name="_token">
                {{ csrf_field() }}
                    <div id="app"></div>
                    <swap-component></swap-component>
            </form>
        </div>
    </div>

@endsection
