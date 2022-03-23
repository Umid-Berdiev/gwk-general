@extends('layouts.master')

@section('content')
<div class="container-fluid py-3">
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
            <tr class="bir">
              <th><input type="checkbox" id="markAll" value="1"></th>
              <th>{{ __('messages.Number auther') }}</th>
              <th>{{ __('messages.Cadaster number') }}</th>
              <th>{{ __('messages.Mineralization') }}</th>
              <th>{{ __('messages.Wells type') }}</th>
              <th>{{ __('messages.Year') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($allDatas as $data)
            <tr>
              <td>
                <input type="checkbox" name="object[]" class="gr-obj-class" data-status="0"
                  data-name="{{ $data['number_auther'] }}" value="{{ $data['number_auther'] }}">
              </td>
              <td>{{ $data['number_auther'] ?? '' }}</td>
              <td>{{ $data['cadaster_number'] ?? '' }}</td>
              <td>{{ $data['mineralization'] ?? '' }}</td>
              <td>{{ $data['well_type']['name'] ?? ($data['type_name'] ?? '') }}</td>
              <td>{{ $data['year'] ?? '' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
