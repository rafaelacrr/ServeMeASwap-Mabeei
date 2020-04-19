@extends('layouts.app')

@section('content')
    <div class="card card--section">
        <div class="card-header">Create a new account</div>
        <div class="card-body">
            <form role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                {{-- Name --}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                </div>

                {{-- E-mail address --}}
                <div class="form-group">
                    <label for="email">E-mail address</label>
                    <div class="input-group {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    </div>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                {{-- Mobile phone indicative + mobile phone--}}
                <div class="row">
                  <div class="form-group col-2">
                      <label for="phone_indicative">Mobile phone indicative</label>
                      <input id="phone_indicative" type="string" class="form-control {{ $errors->has('phone_indicative') ? 'is-invalid' : '' }}" name="phone_indicative" value="{{ old('phone_indicative') }}">
                      <div class="invalid-feedback">{{ $errors->first('phone_indicative') }}</div>
                  </div>

                  <div class="form-group col-4">
                      <label for="phone">Mobile phone</label>
                      <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ old('phone') }}">
                      <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                  </div>
                </div>

                {{-- NIF --}}
                <div class="form-group">
                    <label for="nif">NIF</label>
                    <input id="nif" type="text" class="form-control {{ $errors->has('nif') ? 'is-invalid' : '' }}" name="nif" value="{{ old('nif') }}">
                    <div class="invalid-feedback">{{ $errors->first('nif') }}</div>
                </div>

                {{-- Password --}}
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                </div>

                {{-- Password confirmation --}}
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">Create account</button>
            </form>
        </div>
    </div>
@endsection
