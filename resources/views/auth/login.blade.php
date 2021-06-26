@extends('layouts.app')

@section('content')

<div class="container-fluid"
  style="background: url('img/cover4.png'); background-position: center; background-repeat: no-repeat; background-size: cover; height: 100vh;">
  <div class="row justify-content-center pt-5">
    <img class="float-left mr-3" src="{{asset('img/flag_gerb_uz.png')}}" alt="main-img" width="120" height="70" />
    <h4 class="text-white mt-3">ГОСУДАРСТВЕННЫЙ ВОДНЫЙ КАДАСТР<br />РЕСПУБЛИКИ УЗБЕКИСТАН</h4>
  </div>
  <div class="row justify-content-center mt-5">
    <div class="col-auto">
      <button class="btn btn-light">
        <div class="media">
          <img class="mr-2" src="{{ asset('img/logo2.png') }}" width="50" height="40" alt="uzgidrogeologiya" />
          <div class="media-body">
            <h6 class="small text-primary text-left mb-0">ЎЗБЕКИСТОН<br>СУВ ХЎЖАЛИГИ<br>ВАЗИРЛИГИ</h6>
          </div>
        </div>
      </button>
    </div>
    <div class="col-auto">
      <button class="btn btn-light">
        <div class="media">
          <img class="mr-2" src="{{ asset('img/meteologo.png') }}" width="40" height="40" alt="uzgidrogeologiya" />
          <div class="media-body">
            <h6 class="small text-primary text-left mb-0">O'ZBEKISTON RESPUBLIKASI<br>GIDROMETEOROLOGIYA<br>XIZMATI
              MARKASI</h6>
          </div>
        </div>
      </button>
    </div>
    <div class="col-auto">
      <button class="btn btn-light">
        <div class="media">
          <img class="mr-2" src="{{ asset('img/geolog_logo.png') }}" width="50" height="40" alt="uzgidrogeologiya" />
          <div class="media-body">
            <h6 class="small text-primary text-left mb-0">ЎЗГИДРО<br>ГЕОЛОГИЯ<br>ҚЎМИТАСИ</h6>
          </div>
        </div>
      </button>
    </div>
  </div>
  <div class="row justify-content-center mt-5">
    <div class="col-5 card" style="background-color: #B2D6E3D2;">
      <div class="card-body container">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group row justify-content-center">
            <div class="col-8">
              <h4>{{ __('messages.enter_data_for_signin') }}</h4>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <div class="col-8">
              <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="{{ __("messages.Username") }}">

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="form-group row justify-content-center">
            <div class="col-8">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password" placeholder="{{ __("messages.Password") }}">

              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-4 offset-md-2">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="showpass" onclick="togglePasswordVisible()">
                <label class="custom-control-label text-white" for="showpass">
                  {{ __("messages.show_pwd") }}
                </label>
              </div>
            </div>
            <div class="col-md-4 text-right">
              <button type="submit" class="btn btn-primary py-1 px-3">
                {{ __("messages.signin") }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('css')
<style type="text/css">
  .card {
    background-color: #B2D6E3;
    box-shadow: 5px 5px 10px #0083b4;
  }

  h4,
  h5 {
    color: #0079ca;
  }
</style>
@endsection
