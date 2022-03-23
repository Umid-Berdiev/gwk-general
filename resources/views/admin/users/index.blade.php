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
           <th>Роль</th>
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
          <td>{{ (isset($user->role->name)) ?  __('messages.'.$user->role->name) : ''}}</td>
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
      <form action="{{ route('users.store') }}" method="post" class="was-validated" >
        @csrf
        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="createUserModalLabel">{{ __("messages.Пользователь") }} -
            {{ __("messages.форма добавления") }}</h4>
        </div>
        <div class="modal-body">
          <div class="small">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>{{ __("messages.Пользователь") }}</label>
                <input type="text" name="email" maxlength="100" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите логин пользователя
                </div>
              </div>
              <div class="form-group col-md-3">
                <label>Фамилия</label>
                <input type="text" name="lastname" maxlength="40" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите фамилию пользователя
                </div>
              </div>
              <div class="form-group col-md-3">
                <label>Имя</label>
                <input type="text" name="firstname" maxlength="40" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите имя пользователя
                </div>
              </div>
              <div class="form-group col-md-3">
                <label>Отчество</label>
                <input type="text" name="middlename" maxlength="40" class="form-control form-control-sm" required>
              </div>
              <div class="invalid-feedback">
                Укажите отчество пользователя
              </div>
              <div class="form-group col-md-3">
                <label>Роль</label>
                <select class="custom-select custom-select-sm" name="roll_id" required>
                  @foreach($rolls as $roll)
                  <option value="{{ $roll->id }}">{{  __('messages.'.$roll->name) }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Выберите роль для пользователя
                </div>
              </div>
              <div class="form-group col-md-3">
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
              <div class="form-group col-md-3">
                <label>Эл.почта</label>
                <input type="email" name="user_email" maxlength="100" class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите правильный формат эл.почты
                </div>
              </div>
              <div class="form-group col-md-3">
                <label>Пароль</label>
                <input type="password" name="password" id="password1" class="form-control form-control-sm" required
                       pattern="[A-Za-z0-9]{7,}">
                <div class="invalid-feedback">
                  Пароль, минимум 7 значений (A-Za-z0-9)
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
      <form :action=`/admin/users/${user.id}` method="post" class="was-validated">
        @csrf
        @method('put')

        <div class="modal-header bg-primary text-white">
          <h4 class="modal-title" id="editUserModalLabel">{{ __("messages.Пользователь") }} -
            {{ __("messages.форма изменения") }}</h4>
        </div>
        <div class="modal-body">
          <div class="small">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Имя пользователя</label>
                <input type="text" name="email" maxlength="100" v-model="user.email"
                  class="form-control form-control-sm" required>
                <input type="hidden" name="id" v-model="user.id" class="form-control form-control-sm">
                <div class="invalid-feedback">
                  Укажите логин пользователя
                </div>
              </div>
              <div class="form-group  col-md-3">
                <label>Фамилия</label>
                <input type="text" name="lastname" maxlength="40" v-model="user.lastname"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите фамилию пользователя
                </div>
              </div>
              <div class="form-group  col-md-3">
                <label>Имя</label>
                <input type="text" name="firstname" maxlength="40" v-model="user.firstname"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите имя пользователя
                </div>
              </div>
              <div class="form-group  col-md-3">
                <label>Отчество</label>
                <input type="text" name="middlename" maxlength="40" v-model="user.middlename"
                  class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите отчество пользователя
                </div>
              </div>
              <div class="form-group col-md-3">
                <label>Роль</label>
                <select class="custom-select custom-select-sm" name="roll_id" required>
                  "<option v-for="role in roles" :selected="user.role_id == role.id" :value="role.id" v-text="getRoleName(role.name)"></option>
                </select>
                <div class="invalid-feedback">
                  Выберите роль для пользователя
                </div>
              </div>
              <div class="form-group col-md-3">
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
              <div class="form-group col-md-3">
                <label>Эл.почта</label>
                <input type="email" name="user_email" maxlength="100" v-model="user.user_email"
                       class="form-control form-control-sm" required>
                <div class="invalid-feedback">
                  Укажите правильный формат эл.почты
                </div>
              </div>

              <div class="form-group col-md-3">
                <label>Новий пароль</label>
                <input type="password" name="new_password" id="password2" class="form-control form-control-sm"
                       pattern="[A-Za-z0-9]{7,}">
                <div class="invalid-feedback">
                  Пароль, минимум 7 значений (A-Za-z0-9)
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

      getRoleName(name){
        if(name == 'Administrator') return "{{__('messages.Administrator')}}";
        if(name == 'Viewer') return "{{__('messages.Viewer')}}";
        if(name == 'Editor') return "{{__('messages.Editor')}}";
        if(name == 'Author') return "{{__('messages.Author')}}";
        if(name == 'Data_exchange') return "{{__('messages.Data_exchange')}}";
      },
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
