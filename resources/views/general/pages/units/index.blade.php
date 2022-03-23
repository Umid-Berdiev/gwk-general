@extends('layouts.master')

@section('content')
<main id="main" class="py-3">
  <div class="container-fluid">
    <div class="row justify-content-between">
      <div class="col-auto">
        <div class="row align-items-center">
          <div class="col-auto">
            <h4 class="float-right font-weight-bold text-primary text-uppercase">{{ __('messages.Единицы измерения') }}
            </h4>
          </div>
          <div class="col-auto">
          </div>
        </div>
      </div>
      <div class="col-auto">
        @hasanyrole('Administrator|Editor')
        <ul class="list-inline small">
          <li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#exampleModal"
              class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> {{ __('messages.Добавить') }}</a></li>
        </ul>
        @endhasanyrole

      </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="table-responsive">
      <table id="" class="table table-striped small reestr-tables">
        <thead class="bg-primary text-white text-center">
          <tr>
            <th scope="col">№</th>
            <th scope="col">
              <div class="form-group">
                <label for="exampleInput2">Название</label>
                <input type="text" name="name" class="form-control form-control-sm" id="exampleName">
              </div>
            </th>
            <th scope="col"><i class="bi bi-list-task"></i></th>
          </tr>
        </thead>
        <tbody id="tbody_objectType">
          @foreach($units as $key=>$unit)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $unit->name }}</td>
            <td class="text-center d-flex">
              <button data-toggle="modal" data-target="#exampleModalView{{$unit->id}}"
                class="btn btn-sm btn-outline-warning waves-effect"><i class="bi bi-eye"></i></button>
              @hasanyrole('Administrator|Editor')
              <button data-toggle="modal" data-target="#exampleModal{{$unit->id}}"
                class="btn btn-sm btn-outline-info waves-effect"><i class="bi bi-pencil"></i></button>
              @endhasanyrole
              @hasanyrole('Administrator')
              <button onclick="if (confirm('Вы уверены, что хотите удалить эту вещь в базе данных?')) {
                                    window.location.href='{{route('units-delete',$unit->id)}}'
                                    } else {
                                    }" type="button" class="btn btn-sm btn-outline-danger waves-effect"><i
                  class="bi bi-x"></i></button>
              @endhasanyrole

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $units->links() }}
    </div>
  </div>
</main>
@endsection

@section('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="{{route('units-store')}}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Ед.из - форма добавления</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table id="" class="table table-striped table-bordered adding-forms">
            <tbody>
              <tr>
                <th scope="row">Название</th>
                <td class="form-group">
                  <input type="text" class="form-control" name="name">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-5" data-dismiss="modal">Закрыть</button>
        @hasanyrole('Administrator|Editor')
        <button type="submit" class="btn btn-sm btn-primary">{{ __('messages.save') }}</button>
        @endhasanyrole

      </div>
    </form>
  </div>
</div>

@foreach($units as $key=>$unit)
<div class=" modal fade" id="exampleModal{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="{{route('units-update')}}" class="modal-content">
      @csrf
      <input type="hidden" class="form-control" name="id" placeholder="" value="{{$unit->id}}">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">Ед.из - форма обновить</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table id="" class="table table-striped table-bordered adding-forms">
            <tbody>
              <tr>
                <th scope="row">Название</th>
                <td class="form-group">
                  <input type="text" class="form-control" name="name" placeholder="" value="{{$unit->name}}">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-5" data-dismiss="modal">Закрыть</button>
        @hasanyrole('Administrator|Editor')
        <button type="submit" class="btn btn-sm btn-primary">{{ __('messages.save') }}</button>
        @endhasanyrole

      </div>
    </form>
  </div>
</div>
@endforeach

@foreach($units as $key=>$unit)
<div class=" modal fade" id="exampleModalView{{$unit->id}}" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">Ед.из - форма посмотреть</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table id="" class="table table-striped table-bordered adding-forms">
            <tbody>
              <tr>
                <th scope="row">Название</th>
                <td class="form-group">
                  {{$unit->name}}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-5" data-dismiss="modal">Закрыть</button>
      </div>
    </form>
  </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
            let tbody_objectType = document.getElementById('tbody_objectType');
            let tr = tbody_objectType.getElementsByTagName('tr');
            $('#exampleName').on('input', function (e) {
                let str = e.target.value.toLowerCase();

                for(let i = 0; i < tr.length; i++){
                    if(tr[i].getElementsByTagName('td')[1].innerHTML.toLowerCase().search(str) == -1){
                        tr[i].setAttribute('hidden','true');
                    }else{
                        tr[i].removeAttribute('hidden');
                    }
                }

            });

        });
</script>
@endpush