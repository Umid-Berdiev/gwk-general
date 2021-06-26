@extends('layouts.master')

@section('content')
<div class="py-3">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h6 class="text-uppercase font-weight-bold" style="color: #007bff;">{{ __('messages.Data exchange') }}
            </h6>
          </div>
        </div>
        <!-- search form -->
        @include('general.data-exchange.exchange-form')
        <!-- end search form -->
        @include('general.data-exchange.export-form')
      </div>

      <div class="card-body">
        <div class="table-responsive" id="data-exchange-table">
          <div v-if="isLoading" class="spinner-grow position-absolute"
            style="width: 3rem; height: 3rem; left: 50%; top: 50%;" role="status">
          </div>
          <table class="table table-bordered table-sm small" id="exportable_table">
            <thead>
              <tr class="bir">
                <th>
                  {{-- <input type="checkbox" id="markAll" value="1"> --}}
                  <input type="checkbox" v-model="mainCheckbox">
                </th>
                <th>{{ __('messages.Name') }}</th>
                <th>{{ __('messages.Parameter') }}</th>
                <?php for($m = 1; $m <= 12; $m++) { ?>
                <th>{{ App\Components\Month::name($m) }}</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody class="text-right">
              @forelse($allDatas as $data)
              {{-- @dd($data) --}}
              <tr>
                <td class="text-center">
                  <input type="checkbox" v-model="checkList" value="{{ $data['id'] }}">
                  {{-- <input type="checkbox" name="object[]" class="gr-obj-class" data-status="0"
                    data-name="{{ $data['station']['station_name'] }}" value="{{ $data['station_id'] }}"> --}}
                </td>
                <td class="text-left">
                  <pre>{{ $data['station'] ? $data['station']['station_name'] : '' }}</pre>
                </td>
                <td class="text-left">{{ $data['parameter'] ? $data['parameter']['param_name'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['I'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['II'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['III'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['IV'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['V'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['VI'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['VII'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['VIII'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['IX'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['X'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['XI'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['XII'] : '' }}</td>
              </tr>
              @empty
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const dataExchangeTable = new Vue({
    el:"#data-exchange-table",
    data() {
      return {
        isLoading: false,
        checkList: [],
        reestrData: []
      }
    },
    computed: {
      mainCheckbox: {
        get() {
          return this.reestrData ? this.checkList.length && this.checkList.length == this.reestrData.length : false;
        },

        set(value) {
          let selected = [];
          if (value) this.reestrData.forEach(item => selected.push(item.id));
          this.checkList = selected;
        }
      },
    },
    mounted() {
      this.reestrData = @if(isset($allDatas)) @json($allDatas) @else [] @endif;
    },
    methods: {
      // exportExcel() {
      //   this.isLoading = true;
      //   setTimeout(() => {
      //     const elt = this.$refs.exportable_table;
      //     const wb = XLSX.utils.table_to_book(elt, {
      //       sheet: "Sheet JS"
      //     });
      //     this.isLoading = false;
      //     return XLSX.writeFile(wb, 'GidroTableExport.xlsx');
      //   }, 1000);
      // }
    }
  })
</script>
@endpush

{{-- @section('scripts')
<script>
  $(".two-decimals").change(function(){
          this.value = parseFloat(this.value).toFixed(2);
        });

        $(document).ready(function(){

          $('.form_class').on('change',function(){
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
           $.ajax({

            'url':"{{ route ('ajax-select-element') }}",
'method':'POST',
'data':{
value:$(this).val(),
},success:function (data) {
$( "#elements_form" ).html( data);
},error:function () {
alert('ajax error');
}
})
});

$('.gr-obj-class').click(function(){
let st = $(this).attr('data-status');
if(st == 0){
$(this).attr('data-status',1).addClass('selected-obj')
}
if(st == 1){
$(this).attr('data-status',0).removeClass('selected-obj')
}
});
});

$('#markAll').change(function(){
if($(this).is(":checked")){
$(':checkbox').attr('class', 'gr-obj-class selected-obj');
$(':checkbox').attr('checked', true);
$(':checkbox').attr('data-status', 1);
}
else{
$(':checkbox').attr('class', 'gr-obj-class');
$(':checkbox').attr('data-status', 0);
$(':checkbox').attr('checked', false);
}
});

$("#btnClick").click(function () {
var selected = new Array();
$("input[type=checkbox]:checked").each(function () {
selected.push(this.value);
});

if (selected.length > 0) {
//alert("Selected values: " + selected.join(","));
var query = {
year : @if($year ){{ $year }} @else null @endif,
selects : selected.join(",")
}
var url = "http://213.230.126.118:8080/export-decadares-gidromet?" + $.param(query)
window.location = url;
}
else alert('Выберите объект');
});

</script>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="{{ asset('\js\jquery.canvasjs.min.js') }}"></script>
<script type='text/javascript'>
  $(document).ready(function(){
                $('input').keydown(function(e) {
                    if(e.keyCode == 13) {
                        var str = $(this).attr('id');
                        res = str.split("-");
                        var nextId = parseInt(res[0]) + 1;
                        var next = '#' + nextId + '-' + res[1];
                        if ($(next).length) $(next).focus();
                        else {
                          next = '#1' + '-' + (parseInt(res[1]) + 1);
                          $(next).focus();
                        }
                        return false;
                    }
                });
            });
</script>
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

  input .form-control {
    height: 24px !important;
  }

  pre {
    margin-bottom: 0px !important;
    height: 11px;
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
    top: -4px;

  }

  .gorizontal {
    position: sticky !important;
    left: 0;
    top: 25px;
    background-color: #fff !important;
  }
</style>
@endsection --}}
