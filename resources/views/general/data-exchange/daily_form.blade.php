@extends('layouts.master')

@section('content')
<div class="py-3">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <!-- search form -->
        @include('general.data-exchange.exchange-form')
        <!-- end search form -->
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm small">
            <thead>
              <tr class="bir">
                <th>№</th>
                <th>
                  {{ $metki->where('id_column','Наименование')->first() ? $metki->where('id_column','Наименование')->first()->only('mark_name')['mark_name'] : 'Наименование'}}
                </th>
                <th>
                  {{ $metki->where('id_column','Наименование (ру)')->first() ? $metki->where('id_column','Наименование (ру)')->first()->only('mark_name')['mark_name'] : 'Наименование (ру)'}}
                </th>
                <th>
                  {{ $metki->where('id_column','Год формы')->first() ? $metki->where('id_column','Год формы')->first()->only('mark_name')['mark_name'] : 'Год формы'}}
                </th>
                <th>
                  {{ $metki->where('id_column','Показать/Скрыть')->first() ? $metki->where('id_column','Показать/Скрыть')->first()->only('mark_name')['mark_name'] : 'Показать/Скрыть'}}
                </th>
                <th>
                  {{ $metki->where('id_column','ср')->first() ? $metki->where('id_column','ср')->first()->only('mark_name')['mark_name'] : 'ср'}}
                </th>
                <th>
                  {{ $metki->where('id_column','08')->first() ? $metki->where('id_column','08')->first()->only('mark_name')['mark_name'] : '08'}}
                </th>
                <th>
                  {{ $metki->where('id_column','Сортировка')->first() ? $metki->where('id_column','Сортировка')->first()->only('mark_name')['mark_name'] : 'Сортировка'}}
                </th>
                <th>
                  {{ $metki->where('id_column','Удалить')->first() ? $metki->where('id_column','Удалить')->first()->only('mark_name')['mark_name'] : 'Удалить'}}
                </th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1;?>
              @foreach($forms as $form)
              <tr>
                <td> {{ $i }} </td>
                <td>
                  <input type="text" class="form-control object-day-value2 obj1-{{ $form->gvk_object_id }}"
                    style="width: 100%!important; font-size: 12px!important; height: 15px !important;"
                    data-id="{{ $form->id }}" data-year="{{ $year }}" data-object-id="{{ $form->gvk_object_id }}"
                    name="date_info2" value="{{ $form->objects[0]->name }}" data-names="name">
                </td>
                <td>
                  <input type="text" class="form-control object-day-value2 obj1-{{ $form->gvk_object_id }}"
                    style="width: 100%!important; font-size: 12px!important; height: 15px !important;"
                    data-id="{{ $form->id }}" data-year="{{ $year }}" data-object-id="{{ $form->gvk_object_id }}"
                    name="date_info1" value="{{ $form->objects[0]->name_ru }}" data-names="name_ru">
                </td>
                <td> {{ $form->year }} </td>
                <td>
                  <input type="checkbox" data-names="check" name="checking[]" class="object-day-value1 gr-obj-class"
                    <?php if($form->check == 1) echo 'checked="checked"'; ?>
                    data-name="check_{{ $form->gvk_object_id }}" value="{{ $form->check }}" data-id="{{ $form->id }}">
                </td>
                <td>
                  <input type="checkbox" data-names="present" name="checking_present[]"
                    class="object-day-value1 gr-obj-class" <?php if($form->present == 1) echo 'checked="checked"'; ?>
                    data-name="check_{{ $form->gvk_object_id }}" value="{{ $form->present }}" data-id="{{ $form->id }}">
                </td>
                <td>
                  <input type="checkbox" data-names="morning" name="checking_morning[]"
                    class="object-day-value1 gr-obj-class" <?php if($form->morning == 1) echo 'checked="checked"'; ?>
                    data-name="check_{{ $form->gvk_object_id }}" value="{{ $form->morning }}" data-id="{{ $form->id }}">
                </td>
                <td>
                  <input type="number" step="0.01"
                    class="two-decimals form-control object-day-value obj-{{ $form->gvk_object_id }}"
                    style="width: 100%!important; font-size: 12px!important; text-align: center; height: 15px !important;"
                    data-id="{{ $form->id }}" data-year="{{ $year }}" data-object-id="{{ $form->gvk_object_id }}"
                    name="date_info" value="{{ $form->order_number }}" data-day="@php $i += 1; @endphp {{ $i }}">
                </td>
                <td>
                  <form action="{{ route('post-delete-object-from-daily', ['id' => $form->id ]) }}" method="POST">
                    @csrf
                    <button type="submit"><i class="bi bi-trash text-danger"></i></button>
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
</div>
@endsection

<!-- Modal -->
@section('modal')

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{ route('post-add-object-res') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header ">
          <h5 class="modal-title">
            {{ $metki->where('id_column','Добавить объект')->first() ? $metki->where('id_column','Добавить объект')->first()->only('mark_name')['mark_name'] : 'Добавить объект' }}
          </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="background-color:#fafafa;">
          <div class="row">
            <div class="col-md-8" id="old_object">
              <label>{{ $metki->where('id_column','Объект')->first() ? $metki->where('id_column','Объект')->first()->only('mark_name')['mark_name'] : 'Объект' }}</label>
              <select class="selectpicker form-control form-control-sm" data-live-search="true" name="new_object">
                <option value="">Выберите</option>
                @foreach($existObject as $obj)
                <option value="{{ $obj->id }}">{{ $obj->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <br><br>
              <label>{{ $metki->where('id_column','Новый объект')->first() ? $metki->where('id_column','Новый объект')->first()->only('mark_name')['mark_name'] : 'Новый объект' }}</label>
              <input type="checkbox" name="is_new_object" class="is_new_object" value="1">
            </div>
          </div>
          <hr>
          <div class="row" id="new_object" style="display: none;">
            <div class="col-md-8">
              <label class="text-danger" style="font-weight:bold;">
                {{ $metki->where('id_column','Наименование')->first() ? $metki->where('id_column','Наименование')->first()->only('mark_name')['mark_name'] : 'Наименование' }}
              </label>
              <input type="text" class="form-control" required="" value="Введите" name="name">
            </div>
            <div class="col-md-4">
              <label class="text-danger" style="font-weight:bold;">
                {{ $metki->where('id_column','Ед. изм.')->first() ? $metki->where('id_column','Ед. изм.')->first()->only('mark_name')['mark_name'] : 'Ед. изм.' }}
              </label>
              <select required class="selectpicker form-control form-control-sm" data-live-search="true"
                name="unitsList">
                @foreach($unitsList as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <br>
              <label class="text-danger" style="font-weight:bold;">
                {{ $metki->where('id_column','Наименование(ру)')->first() ? $metki->where('id_column','Наименование(ру)')->first()->only('mark_name')['mark_name'] : 'Наименование(ру)' }}
              </label>
              <input type="text" class="form-control" required="" value="Введите" name="name_ru">
            </div>
            <div class="col-md-12">
              <br>
              <label class="text-danger" style="font-weight:bold;">
                {{ $metki->where('id_column','Форма')->first() ? $metki->where('id_column','Форма')->first()->only('mark_name')['mark_name'] : 'Форма' }}
              </label>
              <select required class="selectpicker form-control form-control-sm" data-live-search="true"
                name="allForms">
                @foreach($allForms as $form)
                <option value="{{ $form->id }}">{{ $form->name }}</option>
                @endforeach
              </select>
            </div>
            <input type="hidden" name="type_id" value="2">
            <input type="hidden" name="in_from" value="daily">
            <input type="hidden" name="year" value="{{ $year }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" form="modal-form" class="btn btn-sm btn-primary">{{ __('messages.save') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

{{-- @section('scripts')

<script>
  $(document).ready(function(){
            $('.is_new_object').on('click',function(){
                var ff = 0;
                if(this.checked == true) ff = 1;
                $('#old_object').hide(); $('#new_object').hide();
                if(ff == 0) $('#old_object').show();
                if(ff == 1) $('#new_object').show();

            });

            $('.object-day-value1').on('click',function(){
                var ff = 0;
                if(this.checked == true) ff = 1;
                $.ajaxSetup({
                    headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    'url':"{{ route ('ajax-change-sird') }}",
'method':'POST',
'data':{
id:$(this).attr('data-id'),
value:ff,
page : 'daily',
field: $(this).attr('data-names'),
},
success:function (data) { },
error:function () { alert('ajax error'); }
})
});

$('.object-day-value').on('change',function(){
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
'url':"{{ route ('ajax-change-sird') }}",
'method':'POST',
'data':{
id:$(this).attr('data-id'),
value:$(this).val(),
page : 'daily',
field:'order_number'
},
success:function (data) { },
error:function () { alert('ajax error'); }
})
});

$('.object-day-value2').on('change',function(){
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
'url':"{{ route ('ajax-change-sird') }}",
'method':'POST',
'data':{
id:$(this).attr('data-id'),
value:$(this).val(),
page : 'daily',
field: $(this).attr('data-names'), //'name_ru'
},
success:function (data) { },
error:function () { alert('ajax error'); }
})
});
});
</script>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="{{ asset('\js\jquery.canvasjs.min.js') }}"></script>
<style>
  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    border: none;
    background: transparent;
  }

  input[type="number"] {
    -moz-appearance: textfield;
    border: none;
    background: transparent;
  }

  input[type="text"]::-webkit-outer-spin-button,
  input[type="text"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    border: none;
    background: transparent;
  }

  input[type="text"] {
    -moz-appearance: textfield;
    border: none;
    background: transparent;
  }

  input .form-control {
    height: 24px !important;
  }

  pre {
    margin-bottom: 0px !important;
    text-align: left !important;
  }

  .table td {
    text-align: center !important;
    font-size: 12px !important;
    padding: 0.30rem !important;
  }

  .btn-light {
    background-color: #ffffff !important;
    border-color: #ffffff !important;
  }

  th {
    background-color: #fff !important;
    text-align: center !important;
    padding: 0.30rem !important;
  }

  .tableFixHead {
    overflow: auto;
  }

  .bir th {
    position: sticky;
    top: 0;
  }
</style>
@endsection --}}
