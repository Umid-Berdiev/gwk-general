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
        <div class="table-responsive">
          <table class="table table-bordered table-sm small" id="exportable_table">
            <thead class="text-center">
              <tr>
                <div id="graph-content" style="display:none; ">
                  <button class="btn btn-info btn-sm" id="close-graph"
                    title="Закрыть график">{{ __('messages.close') }}</button>
                  <div id="chartContainer" style="height: 400px; width: 100%;"></div><br>
                </div>
              </tr>
              <tr>
                <th rowspan="3">Число</th>
                @forelse($formObjects as $index => $sirdForm)
                <?php
                  $resTitle = $sirdForm['object']['name'];
                  $colspan = 2;
                  if(count($formObjects) > $index + 1) {
                    $next = $formObjects[$index + 1];
                    if($next['order_number'] == $sirdForm['order_number'] ) {
                      $resTitle = explode(' ', $sirdForm['object']['name'])[0];
                      $colspan = 4;
                    }
                  }

                  $isHave = false;
                  if($index > 0) {
                    $old = $formObjects[$index - 1];
                    if($old['order_number'] == $sirdForm['order_number'] ) {
                      $resTitle = $old['order_number'] . ' - ' . $sirdForm['order_number'];
                      $isHave = true;
                    }
                  }
                ?>
                @if(!$isHave)
                <th colspan="{{ $colspan }}">{{ $resTitle }}</th>
                @endif
                @empty
                @endforelse
              </tr>
              <tr>
                @foreach($formObjects as $form)
                <?php $title = 'расход , м3/с'; if($form['object']['unit_id'] == 4) $title = 'уровен , см'; ?>
                <td colspan="2">{{ $title }}</td>
                @endforeach
              </tr>
              <tr>
                @foreach($formObjects as $form)
                <td>8 часов</td>
                <td>ср</td>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @for($day = 1; $day <= $r_days_in_month; $day++) <tr>
                <td class="text-center">{{ $day }}</td>
                @foreach($formObjects as $form)
                <?php
                  $monKey = $r_month;
                  $dayKey = $day;
                  if($day < 10) $dayKey = '0' . $day;
                  if($r_month < 10) $monKey = '0' . $r_month ;
                  $key = $form['gvk_object_id'] . '_' . $dayKey . '_' . $monKey . '_' . $r_year;
                ?>
                <td>
                  {{ isset($result[$key]) ? $result[$key] : null }}
                </td>
                <td>
                  {{ isset($result[$key . '_sr']) ? $result[$key . '_sr'] : null }}
                </td>
                @endforeach
                </tr>
                @endfor
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


{{-- @section('scripts')

<script>
  $(".two-decimals").change(function () {
    this.value = parseFloat(this.value).toFixed(2);
  });

  $(document).ready(function () {
    $('.form_class').on('change', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({

        'url': "{{ route ('ajax-select-element') }}",
'method': 'POST',
'data': {
value: $(this).val(),
},
success: function (data) {
$("#elements_form").html(data);
},
error: function () {
alert('ajax error');
}
})
});

$('.object-day-value').on('change', function () {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({

'url': "http://213.230.126.118:8080/add-info-gidromet",
'method': 'GET',
'data': {
id: $(this).attr('data-id'),
type: $(this).attr('data-type'),
value: $(this).val(),
},
success: function (data) {

},
error: function (data) {
alert(data);
}
})
});
$('.gr-obj-class').click(function () {
let st = $(this).attr('data-status');
if (st == 0) {
$(this).attr('data-status', 1).addClass('selected-obj')
}
if (st == 1) {
$(this).attr('data-status', 0).removeClass('selected-obj')
}
});
});

$('.btn-graph').click(function () {
let object = $('.selected-obj');
let data_array = [];
$.each($(object), function (i, v) {
let day_val = [];
let days = $('.obj-' + $(this).val());

$.each($(days), function (i, v) {
if (!parseInt($(this).val())) {
data_val = '';
} else {
data_val = parseInt($(this).val())
}
day_val.push({
x: parseInt($(this).attr('data-day')),
y: data_val
})
});

data_array.push({
//visible: false,
type: "line",
showInLegend: true,
name: $(this).attr('data-name'),
lineDashType: "dash",
yValueFormatString: "#,##0",
dataPoints: day_val
});
});

let options = {
animationEnabled: true,
theme: "light2",
title: {
text: " "
},
axisX: {
title: "@if($r_month ){{ App\Components\Month::name($r_month) }}@endif",
interval: 1,
//suffix: "K",
//minimum: 0,
maximum: "@if($r_days_in_month){{ $r_days_in_month }}@endif"
},
axisY: {
title: "Значение",
//suffix: "K",
//minimum: 0
},
toolTip: {
content: "{name}: {y}",
},
legend: {
cursor: "pointer",
verticalAlign: "center",
horizontalAlign: "right",
dockInsidePlotArea: false,
itemclick: toogleDataSeries
},
data: data_array

};
$('#graph-content').show();
$("#chartContainer").CanvasJSChart(options);

function toogleDataSeries(e) {
if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
e.dataSeries.visible = false;
} else {
e.dataSeries.visible = true;
}
e.chart.render();
}
});
$('#close-graph').click(function () {
$('#graph-content').hide();
});

$('#markAll').change(function () {
if ($(this).is(":checked")) {
$(':checkbox').attr('class', 'gr-obj-class selected-obj');
$(':checkbox').attr('checked', true);
$(':checkbox').attr('data-status', 1);
} else {
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
selects: selected.join(",")
}
var url = "{{route('gvk-export-information')}}?" + $.param(query)
window.location = url;
} else alert('Выберите объект');
});

</script>
@endsection --}}
