@extends('layouts.master')

@section('css')
<style>
  .bootstrap-select .dropdown-toggle .filter-option-inner-inner,
  .bootstrap-select .dropdown-menu li a span.text {
    font-size: 14px;
  }

  .bootstrap-select .btn {
    padding: 4px 10px !important;
  }

  .passwords-match {
    display: none;
  }
</style>
@endsection

@section('content')
<div id="user-instance" class="container-fluid pt-3">
  <div class="row">
    <div class="col-auto">
      <h4 class=" text-primary text-uppercase">{{ __('messages.Пользователи') }}</h4>
    </div>
    <div class="col-auto ml-auto">
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">Добавить</button>
    </div>
  </div>
  @include('partials.alerts')
  <div class="table-responsive">
    <table class="table table-striped small">
      <thead class="bg-primary text-white">
        <tr>
          <th>№ п.п</th>
          <th>Имя пользователя</th>
          <th>ФИО</th>
          {{-- <th>Роль</th> --}}
          <th>Уровень</th>
          <th>Подразделение</th>
          <th>Эл.почта</th>
          <th class="text-center"><i class="bi bi-list"></i></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $key => $user)
        <tr>
          <td>{{ (($key + 1) + $users->currentPage() * $users->perPage()) - $users->perPage() }}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->getFullname()}}</td>
          {{-- @foreach($user->getRoleNames() as $item)
          @if($item == 'Administrator')
          <td>{{__('messages.administrator')}}</td>
          @elseif($item == 'Editor')
          <td>{{__('messages.editor')}}</td>
          @elseif($item == 'Viewer')
          <td>{{__('messages.viewer')}}</td>
          @endif
          @endforeach --}}
          <td>{{$user->level && $user->level->level}}</td>
          <td>
            @foreach($user->user_attrs as $key => $item)
            @if (count($user->user_attrs) > 1)
            {{ $user->user_attrs[0]->minvodxoz_section->name . ', ...' }}<br>
            @break
            @else
            {{$item->minvodxoz_section->name}}<br>
            @endif
            @endforeach
          </td>
          <td>{{$user->user_email}}</td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-info waves-effect" data-toggle="modal"
              data-target="#editUserModal" @click="getUser({{$user->id}})">
              <i class="bi bi-pencil"></i>
            </button>

            <form class="d-inline" action="{{ route('users.destroy', $user->id) }}" method="POST">
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
    {{ $users->links() }}
  </div>
</div>
@endsection

@section('modal')
<!-- Modal for create -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form action="{{ route('users.store') }}" method="post" class="was-validated" onsubmit="return checkForm(this);">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="createUserModalLabel">{{ __("messages.Пользователь") }} -
            {{ __("messages.форма добавления") }}</h4>
        </div>
        <div class="modal-body">
          <div class="small">
            <div class="form-row">
              <div class="form-group col-auto">
                <label>{{ __("messages.Пользователь") }}</label>
                <input type="text" name="email" maxlength="100" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите логин пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Фамилия</label>
                <input type="text" name="lastname" maxlength="40" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите фамилию пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Имя</label>
                <input type="text" name="firstname" maxlength="40" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите имя пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Отчество</label>
                <input type="text" name="middlename" maxlength="40" class="form-control form-control-sm" required>
              </div>
              <div class="invalid-feedback">
                Укажите отчество пользователя
              </div>
              <div class="form-group col-auto">
                <label>Роль</label>
                <select class="custom-select custom-select-sm" name="roll_id" required>
                  @foreach($rolls as $roll)
                  <option value="{{ $roll->id }}">{{ $roll->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите роль для пользователя
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-auto">
                <label>Подразделение</label>
                <select class="selectpicker" name="division_id[]" multiple data-live-search="true"
                  data-selected-text-format="count > 2" title="{{ __('messages.choose') }}.." data-width='100%'
                  data-actions-box="true" required>
                  @foreach($divisions as $division)
                  <option value="{{$division->id}}">{{$division->name}}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите подразделения для пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Уровень</label>
                <select class="custom-select custom-select-sm" name="level_id" required>
                  <option value="" selected disabled hidden>{{ __('messages.choose') }}..</option>
                  @foreach($levels as $level)
                  <option value="{{$level->id}}">{{$level->level}}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите уровень для пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Область</label>
                <select class="custom-select custom-select-sm" name="regions" required>
                  <option value="" selected disabled hidden>{{ __('messages.choose') }}..</option>
                  @foreach($uz_regions as $region)
                  <option value="{{$region->regionid}}">{{$region->nameRu}}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите область
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-auto">
                <label>Эл.почта</label>
                <input type="email" name="user_email" maxlength="100" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите правильный формат эл.почты
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Пароль</label>
                <input type="password" name="password" id="password1" class="form-control form-control-sm" required
                  pattern="[A-Za-z0-9]{7,}">
                <div class="invalid-feedback">
                  Пароль, минимум 7 значений (A-Za-z0-9)
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Подтверждение пароля</label>
                <input type="password" name="confirm_password" id="confirm_password1"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback passwords-match">
                  Пароли не совподали
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-primary btn-sm px-5">{{ __('messages.save') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for edit -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form :action=`/admin/users/${user.id}` method="post" class="was-validated" onsubmit="return checkForm(this);">
        @csrf
        @method('put')

        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="editUserModalLabel">{{ __("messages.Пользователь") }} -
            {{ __("messages.форма изменения") }}</h4>
        </div>
        <div class="modal-body">
          <div class="small">
            <div class="form-row">
              <div class="form-group col-auto">
                <label>Имя пользователя</label>
                <input type="text" name="email" maxlength="100" v-model="user.email"
                  class="form-control form-control-sm" required>
                <input type="hidden" name="id" v-model="user.id" class="form-control form-control-sm">
                <div class="invalid-feedback">
                  Укажите логин пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Фамилия</label>
                <input type="text" name="lastname" maxlength="40" v-model="user.lastname"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите фамилию пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Имя</label>
                <input type="text" name="firstname" maxlength="40" v-model="user.firstname"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите имя пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Отчество</label>
                <input type="text" name="middlename" maxlength="40" v-model="user.middlename"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите отчество пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Роль</label>
                <select class="custom-select custom-select-sm" name="roll_id" required>
                  <option v-for="role in roles" :value="role.id" v-text="role.name"></option>
                  {{-- @foreach($rolls as $roll)
                  @if($roll->name == 'Administrator')
                  <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::__('messages.administrator')}}</option>
                  @elseif($roll->name == 'Editor')
                  <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::__('messages.editor')}}</option>
                  @elseif($roll->name == 'Viewer')
                  <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::__('messages.viewer')}}</option>
                  @endif
                  @endforeach --}}
                </select>
                <div class="invalid-feedback">
                  Выберите роль для пользователя
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-auto">
                <label>Подразделение</label>
                <select class="selectpicker" v-model="divisions" name="division_id[]" multiple data-live-search='true'
                  data-width="100%" data-selected-text-format="count > 2" data-actions-box="true" required>
                  @foreach($divisions as $division)
                  <option value="{{ $division->id }}">{{ $division->name }}</option>
                  @endforeach
                  {{-- <option v-for="division in divisions" :selected="division.id == " value="division.id" v-text="division.name"></option> --}}
                </select>
                <div class="invalid-feedback">
                  Выберите подразделения для пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Уровень</label>
                <select class="custom-select custom-select-sm" v-model="user.level_id" name="level_id" required>
                  <option value="" selected disabled hidden>{{ __('messages.choose') }}..</option>
                  @foreach($levels as $level)
                  <option value="{{$level->id}}">{{$level->level}}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите уровень для пользователя
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Области</label>
                <select class="custom-select custom-select-sm" v-model="user.region_id" name="regions" required>
                  <option value="" selected disabled hidden>{{ __('messages.choose') }}..</option>
                  @foreach($uz_regions as $region)
                  <option value="{{$region->regionid}}">{{$region->nameRu}}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите область
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-auto">
                <label>Эл.почта</label>
                <input type="email" name="user_email" maxlength="100" v-model="user.user_email"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите правильный формат эл.почты
                </div>
              </div>

              <div class="form-group col-auto">
                <label>Пароль</label>
                <input type="password" name="password" id="password2" class="form-control form-control-sm" required
                  pattern="[A-Za-z0-9]{7,}">
                <div class="invalid-feedback">
                  Пароль, минимум 7 значений (A-Za-z0-9)
                </div>
              </div>
              <div class="form-group col-auto">
                <label>Подтверждение пароля</label>
                <input type="password" name="confirm_password" id="confirm_password2"
                  class="form-control form-control-sm">
                <div class="invalid-feedback passwords-match">
                  Пароли не совподали
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-primary btn-sm px-5">{{ __('messages.save') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let results = [];

  const userInstance = new Vue({
    el: "#user-instance",
    data() {
      return {
        user: null,
      };
    },

    methods: {
      getUser(id) {
        axios
          .get("/admin/users/edit", {
            params: { id: id },
          })
          .then((response) => {
            editUserModal.user = response.data.user;
            editUserModal.roles = response.data.roles;
            editUserModal.divisions = response.data.divisions;
            editUserModal.$nextTick(() => {
              $(".selectpicker").selectpicker("refresh");
            });
          })
          .catch(function (error) {
            console.log(error);
          });
      },
    },
  });

  const editUserModal = new Vue({
    el: "#editUserModal",
    data() {
      return {
        user: {},
        roles: [],
        divisions: [],
      };
    },

    methods: {
      getPositions(id) {
        results = [];

        axios
          .get("/admin/users/get-division", {
            params: { id: id },
          })
          .then((response) => {
            results = response.data
              .filter(
                (item) =>
                  item.minvodxoz_division_id != null &&
                  item.minvodxoz_division_id
              )
              .map((item) => item.minvodxoz_division_id);

            this.divisions = results;
            editUserModal.$nextTick(() => {
              $(".selectpicker").selectpicker("refresh");
            });
          })
          .catch((error) => {
            console.log(error);
          });
      },
    },

    updated() {
      $(this.$el).find(".selectpicker").selectpicker("refresh");
    },

    destroyed() {
      console.log("editUserModal is destroyed");
      document.getElementById("password2").value = "";
      document.getElementById("confirm_password2").value = "";
    },
  });

  function checkForm(form) {
    if (form.password.value !== form.confirm_password.value) {
      let a = form.querySelector(".passwords-match");
      a.style.display = "block";
      form.confirm_password.style.borderColor = "#dc3545";
      form.confirm_password.style.borderShadow = "none";
      form.confirm_password.style.backgroundImage = "none";
      form.password.focus();
      return false;
    }
  }
</script>
@endpush
