@extends('layouts.master')
@section('content')
<main class="py-3" id="main">
  <div class="container">
    <div class="row">
      <div class="col">
        <form method="post" action="{{ route('languages.update', $lang->id) }}">
          @csrf
          @method('put')
          <div class="form-group">
            <div>
              <label for="language_name">Названия</label>
              <input name="language_name" id="language_name" class="form-control" value="{{ $lang->language_name }}">
            </div><br>
            <div>
              <label for="language_prefix">Префикс</label>
              <input name="language_prefix" id="language_prefix" class="form-control"
                value="{{ $lang->language_prefix }}">
            </div>
          </div>
          <button class="btn btn-success" type="submit">{{ __('messages.save') }}</button>
        </form>
      </div>
    </div>
  </div>
</main>




@endsection
