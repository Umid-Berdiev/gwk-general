@extends('layouts.master')
@section('content')
<div class="py-3">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h6 class="text-uppercase font-weight-bold">{{ __('messages.Data exchange') }}
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
            @if(!empty($formObjects))
            <thead class="text-center">
              <tr>
                <div id="graph-content" style="display:none; ">
                  <button class="btn btn-info btn-sm" id="close-graph"
                    title="Закрыть график">{{ __('messages.close') }}</button>
                  <div id="chartContainer" style="height: 400px; width: 100%;"></div><br>
                </div>
              </tr>
              <tr>
                <!-- <th><input type="checkbox" id="markAll" value="1"></th> -->
                <th rowspan="3"><span>Число</span></th>
                @foreach($formObjects as $sirdForm)
                <th colspan="2">{{ $sirdForm['object']['name'] }}</th>
                @endforeach
              </tr>
              {{-- <tr>
                @dd($formObjects)
                @foreach($formObjects as $sirdForm)
                <th colspan="2">
                  {{ $sirdForm['object']['name_ru'] ? $sirdForm['object']['name_ru'] : $sirdForm['object']['name'] }}
              </th>
              @endforeach
              </tr> --}}
              <tr>
                @foreach($formObjects as $sirdForm)
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

                  $first = null;
                  $second = null;
                  if(isset($result[$key])) $first = $result[$key];
                  if(isset($result[$key . '_sr'])) $second = $result[$key . '_sr'];
                ?>
                <td>{{ $first }}</td>
                <td>{{ $second }}</td>
                @endforeach
                </tr>
                @endfor
            </tbody>
            @else
            <tr>
              <td class="text-center">
                {{ __('messages.Datas not found') }}
              </td>
            </tr>
            @endif
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
