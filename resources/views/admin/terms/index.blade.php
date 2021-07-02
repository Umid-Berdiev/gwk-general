@extends('layouts.master')

@section('content')
<div class="container-fluid pt-3">
  <div class="row mb-3">
    <div class="col-auto">
      <button data-toggle="modal" data-target="#createTermModal" class="btn btn-primary btn-sm"><i
          class="bi bi-plus"></i></button>
    </div>
    <div class="col-auto ml-auto">
      @include('partials.alerts')
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-sm small table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>key</th>
          @foreach($languages as $key=>$lang)
          <th> Метка: {{ $lang->language_prefix }}</th>
          @endforeach
          <th>Действия</th>
        </tr>
        <tr>
          <form id="searchForm" method="get">
            <td></td>
            <td>
              <input type="text" name="search" value="{{ $search_term ?? '' }}" class="form-control form-control-sm"
                placeholder="{{ __('messages.search') }}...">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <button class="btn btn-sm btn-outline-info" type="submit">{{ __('messages.search') }}</button>
            </td>
          </form>
        </tr>
      </thead>
      <tbody>
        @foreach($table as $row => $tb)
        <tr>
          <form id="allUpload" method="post" action="{{ route('terms.update', $tb->id) }}">
            @csrf
            @method('put')

            <td class="align-middle">{{ $row + 1 }}</td>
            <td class="align-middle">{{$tb->id_column}}</td>
            @foreach($languages as $lang)
            @php
            $el = \App\Models\Additional\Term::where("group_id", $tb->group_id)->where("language_id",
            $lang->id)->first();
            @endphp
            <td>
              <input type="hidden" name="lang_ids[]" value="{{ $lang->id ?? "" }}">
              <input autofocus class="form-control form-control-sm" type="text" name="mark_names[]"
                value="{{ $el->mark_name ?? '' }}" />
            </td>
            <td class="d-none">
              <button type="submit"></button>
            </td>
            @endforeach
          </form>
          <td>
            <form class="d-inline" action="{{ route('terms.destroy', $tb->group_id) }}" method="POST">
              @csrf
              @method('delete')

              <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Вы уверены?');">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $table->links() }}
  </div>
</div>
@endsection

<!-- Modal -->
@section('modal')
<div class="modal fade" id="createTermModal" tabindex="-1" role="dialog" aria-labelledby="createModalTermLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="{{route('terms.store')}}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="createModalTermLabel">{{ __("messages.форма добавления") }}</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table class="table table-sm table-striped table-bordered">
            <tbody>
              <tr>
                <th scope="row">Название метка</th>
                <td class="form-group">
                  <input id="myInput" type="text" name="name" class="form-control form-control-sm" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-sm btn-primary">{{ __('messages.save') }}</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  $('#createTermModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })
</script>
@endpush
