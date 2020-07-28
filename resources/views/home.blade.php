@extends('layouts.app')
@section('content')
  <div class="text-center" id="createNewSwap">
        <a class="btn btn-info text-white btn-lg center-block" href="{{ url('/newSwap') }}">Create new Swap</a>
  </div>

<div class="container">
  <div class="card card--section rounded">
      <div class="card-header">Active Swaps</div>
      <div class="card-body">
        <div class="row">
          {{-- ONE --}}
          @foreach ($swaps as $key => $data)
            <div class="card card-swaps text-center col-sm-3" style="width: 60%;" >
              <div class="card-header"> {{$data->subdomain}} </div>
              <div class="card-body">
                <a type="button" class="btn btn-lg btn-block bg-info text-white btn-outline-primary" href="https://{{$data->subdomain}}.{{config('app.domain_url')}}" target="_blank">Open</a>
                <a type="button" class="btn btn-lg btn-block bg-info text-white btn-outline-primary" href="{{ route('resetSwap', $data->subdomain) }}">Reset</a>
                <a type="button" class="btn btn-lg btn-block bg-danger text-white btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter-{{{$data->subdomain}}}" >Delete</a>
              </div>
            </div>
            {{-- POPUP --}}
            <div class="modal fade" id="exampleModalCenter-{{{$data->subdomain}}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Swap?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete {{$data->subdomain}}? All the information will be lost!
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a type="button" class="btn bg-danger text-white btn-outline-danger" href="{{ route('deleteSwap', $data->id ) }}">Delete Swap</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            @if (count($swaps) === 0)
              <span class="noSwaps"> You don't have any active Swaps.</span>
            @endif
        </div>
    </div>
</div>
@if (count($swaps) === 0)
      <div class="space"></div>
@endif

@endsection
