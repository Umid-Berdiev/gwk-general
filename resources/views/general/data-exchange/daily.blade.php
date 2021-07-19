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
            <thead>
              <tr>
                <div id="graph-content" style="display:none; ">
                  <button class="btn btn-info btn-sm" id="close-graph" title="Закрыть график">
                    {{ __('messages.close') }}
                  </button>
                  <div id="chartContainer" style="height: 400px; width: 100%;"></div><br>
                </div>
              </tr>
              @isset($firstData)
              <tr class="bir">
                <th rowspan="2"><span>Число</span></th>
                @forelse($firstData as $data)
                <?php $colspan = 0; if($data['formObjectMorning']) $colspan++; if($data['formObjectPresent']) $colspan++; ?>
                <th colspan="{{$colspan}}" style="text-align: center!important;">{{ $data['object_name'] }}</th>
                @empty
                @endforelse
              </tr>
              <tr class="bir">
                @forelse($firstData as $data)
                <?php if($data['formObjectMorning']) {?><td style="text-align: center!important;">8 часов</td>
                <?php } ?>
                <?php if($data['formObjectPresent']) {?><td style="text-align: center!important;">ср</td><?php } ?>
                @empty
                @endforelse
              </tr>
              @endisset
            </thead>
            <tbody>
              @isset($allDatas)
              @forelse($allDatas as $key => $dayData)
              <tr>
                <td>{{ (int)$key + 1 }}</td>
                @foreach($dayData as $data)
                <?php if($data['formObjectMorning']) {?><td style="text-align: center!important;">{{ $data['morning'] }}
                </td><?php } ?>
                <?php if($data['formObjectPresent']) {?><td style="text-align: center!important;">{{ $data['present'] }}
                </td><?php } ?>
                @endforeach
              </tr>
              @empty
              @endforelse
              @endisset
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
