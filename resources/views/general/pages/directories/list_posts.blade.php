@extends('layouts.master')
@section('content')
<main class="py-3" id="main">
  <div class="container-fluid">
    <div class="row justify-content-between">
      <h4 class="w-100 ml-3 font-weight-bold text-primary">{{ __('messages.Post list') }}</h4>
      <div class="col-auto">
        <ul class="list-inline small">
          @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
          <li class="list-inline-item">
            <a href="#" class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#exampleModal">
              <i class="fas fa-plus"></i>{{ __('messages.Add') }}
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
                  <label for="exampleInput2">{{ __('messages.Name of the water body') }}</label>
                  <input type="text" class="form-control form-control-sm" id="exampleInput2">
                </div>
              </form>
            </th>
            <th scope="col">
              <form>
                <div class="form-group">
                  <label for="exampleInput2">{{ __('messages.Post title locations') }}</label>
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
            <td>{{ $name->order }}</td>
            <td class="text-left">{{$name->name}}</td>
            <td class="text-left">{{$name->post_place}}</td>
            <td>
              {{-- <button onclick="getId({{$name->id}})" data-toggle="modal" data-target="#exampleModal1" type="button"
              class="btn btn-sm btn-outline-warning waves-effect"><i class="bi bi-eye"></i></button> --}}
              @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
              <button onclick="getId({{$name->id}})" data-toggle="modal" data-target="#exampleModal1" type="button"
                class="btn btn-sm btn-outline-info waves-effect"><i class="bi bi-pencil"></i></button>
              @endif
              @if(\Auth::user()->role->name == 'Administrator')

              <button onclick="if ({{ __('messages.Are you sure you want to delete this thing into the database?') }}) {
                                        window.location.href='{{route('directories.list_posts.destroy',$name->id)}}'
                                        }" type="button" class="btn btn-sm btn-outline-danger waves-effect"><i
                  class="bi bi-trash"></i></button>
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
    <form method="post" action="{{route('directories.list_posts.store')}}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">{{ __('messages.List post add form') }}</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th scope="row">№</th>
                <td class="form-group">
                  <input type="number " value="{{old('order')}}" name="order" class="form-control">
                </td>
              </tr>
              <tr>
                <th scope="row">{{ __('messages.Name of the water body') }}</th>
                <td class="form-group">
                  <input type="text" value="{{old('name')}}" name="name" class="form-control">
                </td>
              </tr>
              <tr>
                <th scope="row">{{ __('messages.Post title locations') }}</th>
                <td class="form-group">
                  <input type="text" value="{{old('post_place')}}" name="post_place" class="form-control">
                </td>
              </tr>
              <tr>
                <th scope="row">{{ __('messages.Mark') }}</th>
                <td class="form-group">
                  <input type="checkbox" checked name="isFavotire" class="form-control" @php old('post_place_edit')==1
                    ? 'checked=""' : '' @endphp>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('messages.close') }}</button>
        @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
        <input type="submit" class="btn btn-primary px-5" value="{{ __('messages.Save') }}"></input>
        @endif
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form method="post" action="{{route('directories.list_posts.update')}}" class="modal-content">
      @csrf
      <input type="hidden" name="id" id="hidden">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">{{ __('messages.List post add form') }}</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th scope="row">{{ __('messages.Name of the water body') }}</th>
                <td class="form-group">
                  <input type="text" value="{{old('name_edit')}}" name="name_edit" class="form-control" id="name_edit">
                </td>
              </tr>
              <tr>
                <th scope="row">{{ __('messages.Post title locations') }}</th>
                <td class="form-group">
                  <input type="text" value="{{old('post_place_edit')}}" name="post_place_edit" class="form-control"
                    id="post_place_edit">
                </td>
              </tr>
              <tr>
                <th scope="row">{{ __('messages.Mark') }}</th>
                <td class="form-group">
                  <input type="checkbox" name="isFavotire_edit" value="1" class="form-control" id="isFavotire_edit" @php
                    old('post_place_edit')==1 ? 'checked=""' : '' @endphp>
                </td>
              </tr>
            </tbody>
          </table>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('messages.close') }}</button>
        @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
        <input type="submit" class="btn btn-primary px-5" value="{{ __('messages.Save') }}"></input>
        @endif
      </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
<script>
  var id = 0;
        function getId(id)
        {
            this.id = id;
            axios.get('{{route('directories.list_posts.edit')}}',{
                params: {
                    id: id
                }
            })
                .then(function (response) {
                    $('#name_edit').val(response.data.name);
                    $('#post_place_edit').val(response.data.post_place);

                    if(response.data.isfavorite == true) {
                        $('#isFavotire_edit').prop('checked', true);
                    }
                    else {
                        $('#isFavotire_edit').prop('checked', false);
                    }
                    $('#hidden').val(response.data.id);
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        }
</script>
@endsection
