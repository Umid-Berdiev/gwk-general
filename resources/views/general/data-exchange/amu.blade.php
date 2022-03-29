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
            @if(isset($formObjects) && $formObjects)
              <table class="table table-bordered table-sm small" id="exportable_table">
                <thead class="text-center">
                <tr>
                  <div id="graph-content" style="display:none; ">
                    <button class="btn btn-info btn-sm" id="close-graph"
                            title="Закрыть график">{{ __('messages.close') }}</button>
                    <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                    <br>
                  </div>
                </tr>
                <tr>
                  <th rowspan="3">Число</th>
                  @forelse($formObjects as $index => $sirdForm)
                    <?php
                    $resTitle = $sirdForm['object']['name'];
                    $colspan = 2;
                    if (count($formObjects) > $index + 1) {
                      $next = $formObjects[$index + 1];
                      if ($next['order_number'] == $sirdForm['order_number']) {
                        $resTitle = explode(' ', $sirdForm['object']['name'])[0];
                        $colspan = 4;
                      }
                    }

                    $isHave = false;
                    if ($index > 0) {
                      $old = $formObjects[$index - 1];
                      if ($old['order_number'] == $sirdForm['order_number']) {
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
                    <?php $title = 'расход , м3/с'; if ($form['object']['unit_id'] == 4) $title = 'уровен , см'; ?>
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
                @for($day = 1; $day <= $r_days_in_month; $day++)
                  <tr>
                    <td class="text-center">{{ $day }}</td>
                    @foreach($formObjects as $form)
                      <?php
                      $monKey = $r_month;
                      $dayKey = $day;
                      if ($day < 10) $dayKey = '0' . $day;
                      if ($r_month < 10) $monKey = '0' . $r_month;
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
            @else
              <tr>
                  <div class="text-center">
                      Данные не найдены
                  </div>
              </tr>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
