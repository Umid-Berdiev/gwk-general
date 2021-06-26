@extends('layouts.master')
@section('content')
<main class="py-3" id="main">
  <div class="container">
    <div class="row">
      <div class="col">
        <form method="post" action="{{ route('languages.store') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <div>
              <label for="language_name">Названия</label>
              <input name="language_name" id="language_name" class="form-control">
            </div><br>
            <div>
              <label for="language_prefix">Префикс</label>
              <input name="language_prefix" id="language_prefix" class="form-control">
            </div>
          </div>
          <button class="btn btn-success" type="submit">{{ __('messages.save') }}</button>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection
