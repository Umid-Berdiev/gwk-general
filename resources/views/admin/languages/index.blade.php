@extends('layouts.master')

@section('content')
<main class="py-3" id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <a href="{{ route('languages.create') }}" class="btn btn-success">
          <i class="bi bi-plus"></i>
        </a>
        <div class="table-responsive mt-3">
          <table class="table table-striped">
            <thead>
              <tr>
                <td>#</td>
                <td>Названия</td>
                <td>префикс</td>
                <td>действия</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($languages as $key=>$item)
              <tr>
                <td>{{ $key +1}}</td>
                <td> {{ $item->language_name }}</td>
                <td> {{ $item->language_prefix }}</td>
                <td>
                  <a class="btn btn-sm btn-outline-info" href="{{ route('languages.edit', $item->id) }}">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form class="d-inline" action="{{ route('languages.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('delete')

                    <button class="btn btn-sm btn-outline-danger" type="submit"
                      onclick="return confirm('Вы уверены?');">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
