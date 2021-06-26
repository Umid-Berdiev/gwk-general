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
      </div>
    </div>
  </div>
</div>
@endsection



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
//form_id : @if($postAttr ){{ $postAttr['form'] }}@endif,
//year : @if($postAttr ){{ $r_year }}@endif,
//month : @if($postAttr ){{ $r_month }}@endif,
selects : selected.join(",")
}
var url = "{{route('gvk-export-information')}}?" + $.param(query)
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

  th span {
    -ms-writing-mode: tb-rl;
    -webkit-writing-mode: vertical-rl;
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    white-space: nowrap;
  }
</style>
@endsection --}}
