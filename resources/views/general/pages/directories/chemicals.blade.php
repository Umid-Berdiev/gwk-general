@extends('layouts.master')
@section('content')
  <main class="py-3" id="main">
  <div class="container-fluid">
    <div class="row justify-content-between">
      <h4 class="w-100 ml-3 font-weight-bold text-primary">{{ __('messages.Chemistry list') }}</h4>
      <div class="col-auto">
        <ul class="list-inline small">
          @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
          <li class="list-inline-item">
            <a href="#" class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#exampleModal">
              <i class="fas fa-plus"></i> {{ __('messages.Add') }}
            </a>
          </li>
          @endif
        </ul>
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
      <table class="table table-striped small ">
        <thead class="bg-primary text-white text-center">
          <tr>
            <th scope="col">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1"></label>
              </div>
            </th>
            <th scope="col">№</th>
            <th scope="col">
              <form>
                <div class="form-group">
                  <label for="exampleInput2">{{ __('messages.Name list chemical composition') }}</label>
                  <input type="text" class="form-control form-control-sm" id="exampleInput2">
                </div>
              </form>
            </th>
            <th scope="col"><i class="fas fa-tasks fa-lg"></i></th>
          </tr>
        </thead>
        <tbody class="text-center">
          @foreach($directories as $key => $name)
          <tr>
            <th scope="row">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                <label class="form-check-label" for="defaultCheck2"></label>
              </div>
            </th>
            <td>{{ $key+1 }}</td>
            <td>{!! $name->name !!}</td>

            <td class="d-flex justify-content-center">
              @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
              <button onclick="getDataList({{ $name->id }})" data-toggle="modal" data-target="#chemicalEditModal"
                type="button" class="btn btn-sm btn-outline-info waves-effect">
                <i class="bi bi-pencil"></i>
              </button>
              @endif
              @if(auth()->user()->role->name == 'Administrator')
              <form action="{{ route('directories.chemicals.destroy', $name->id) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" onclick="return confirm('А Вы уверены?')" class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-x"></i>
                </button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $directories->links() }}
    </div>
  </div>
</main>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="{{route('directories.chemicals.store')}}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">{{ __('messages.Create') }}</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th scope="row">{{ __('messages.Name') }}</th>
                <td class="form-group">
                  <input type="text" required value="{{old('name')}}" name="name" class="form-control">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('messages.close') }}</button>
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <input type="submit" class="btn btn-primary btn-sm" value="{{ __('messages.Save') }}"></input>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="chemicalEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="{{route('directories.chemicals.update')}}" class="modal-content">
      @csrf
      <input type="hidden" name="id" id="hidden">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">{{ __('messages.Редактировать') }}</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th scope="row">{{ __('messages.Name') }}</th>
                <td class="form-group">
                  <input type="text" required value="{{old('name')}}" name="name" class="form-control" id="name_edit">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('messages.close') }}</button>
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <button type="submit"  class="btn btn-sm btn-primary">{{ __('messages.save') }}</button>
        @endif
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let id = 0;

  function getDataList(id) {
    this.id = id;
    axios
      .get("{{ route('directories.chemicals.edit') }}", { params: { id } })
      .then(response => {
        console.log(response);
        $('#name_edit').val(response.data.name);
        $('#hidden').val(response.data.id);
      })
      .catch(function (error) {
        console.log(error);
      })
  }
</script>
@endpush
