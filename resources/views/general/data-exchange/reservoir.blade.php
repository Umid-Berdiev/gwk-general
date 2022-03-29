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
          @if(isset($allDatas) && $allDatas)
            <table class="table table-bordered table-sm small" id="exportable_table">
              <thead>
                <tr class="bir">
                  <th rowspan="3"><input type="checkbox" id="markAll" value="1"></th>
                  <th rowspan="3">{{ __('messages.Name') }}</th>
                  <th colspan="36">{{ $r_year }}</th>
                </tr>
                <tr class="ikki">
                  <?php for($m = 1; $m <= 12; $m++) { ?>
                  <th colspan="3">{{ App\Components\Month::name($m) }}</th>
                  <?php } ?>
                </tr>
                <tr class="uch">
                  <?php for($m = 1; $m <= 12; $m++) { ?>
                  <th>
                    <div style="width: 60px;">I</div>
                  </th>
                  <th>
                    <div style="width: 60px;">II</div>
                  </th>
                  <th>
                    <div style="width: 60px;">III</div>
                  </th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                @foreach($allDatas as $data)
                {{-- @dd($data) --}}
                <tr>
                  <td>
                    <input type="checkbox" name="object[]" class="gr-obj-class" data-status="0"
                      data-name="{{ $data['object_name'] }}" value="{{ $data['object_id'] }}">
                  </td>
                  <td>
                    <pre>{{ $data['object_name'] }}</pre>
                  </td>

                  @foreach($data['object_datas'] as $key => $monthValue)
                    @if(!in_array($key,['id','year','object_id']))
                      <td>{{ $monthValue }}</td>
                    @endif
                  @endforeach
                </tr>
                @endforeach
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
