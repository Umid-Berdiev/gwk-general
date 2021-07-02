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
            <thead>
              <tr class="bir">
                <th><input type="checkbox" id="markAll" value="1"></th>
                <th>{{ __('messages.Name') }}</th>
                <th>{{ __('messages.Cadaster number') }}</th>
                <th>{{ __('messages.Groundwater resource') }}</th>
                <th>{{ __('messages.Reserve') }}</th>
                <th>{{ __('messages.Year') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($allDatas as $data)
              <tr>
                <td>
                  <input type="checkbox" name="object[]" class="gr-obj-class" data-status="0"
                    data-name="{{ $data['name'] }}" value="{{ $data['name'] }}">
                </td>
                <td>{{ $data['name'] }}</td>
                <td>{{ $data['code'] }}</td>
                <td>{{ $data['groundwater_resource'] }}</td>
                <td>{{ $data['selection_from_approved_groundwater_reserves'] }}</td>
                <td>{{ $data['year'] }}</td>
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
