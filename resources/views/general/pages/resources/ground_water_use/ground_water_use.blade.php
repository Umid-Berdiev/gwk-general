@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {!! str_replace('{year}', $selected_year, __('messages.groundwater use year')) !!}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidrogeologiya')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.ground_water_use.accept')}}" method="post">
          @csrf
          <input type="hidden" name="year"
            value="{{ isset($last_update) && !is_null($last_update) ? $last_update->years : null }}">
          <input type="hidden" name="type" value="resource">
          <button type="submit" class="btn btn-warning btn-sm">{{ __("messages.Submit") }}</button>
        </form>
        @endif
        @endif
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered small">
        <thead class="text-center bg-light">
          <tr>
            <th scope="col" rowspan="3">{{ __('messages.Hydrogeological areas') }}</th>
            <th scope="col" colspan="2">{{ __('messages.Water taken from underground sources') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.total') }}</th>
            <th scope="col">{{ __('messages.including due to damage to river flow') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ground_water_uses as $key=>$ground_water)
          <tr>
            <td class="p-2">{{$ground_water->pool_name}} , {{$ground_water->region_name}}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('total', {{ $ground_water->id }})" value="{{$ground_water->total}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('total', {{ $ground_water->id }})" value="{{$ground_water->total}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('river_flow', {{ $ground_water->id }})" value="{{$ground_water->river_flow}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('river_flow', {{ $ground_water->id }})" value="{{$ground_water->river_flow}}">
            </td>
            @endif
            @else
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('total', {{ $ground_water->id }})" value="{{$ground_water->total}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('total', {{ $ground_water->id }})" value="{{$ground_water->total}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('river_flow', {{ $ground_water->id }})" value="{{$ground_water->river_flow}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('river_flow', {{ $ground_water->id }})" value="{{$ground_water->river_flow}}">
            </td>
            @endif
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let resource = new Vue({
    el: '#resource',
    methods: {
      async changes(func, id) {
        await axios.post("{{ route('resource.ground_water_use.update') }}", {
          func,
          id,
          param: event.target.value,
          _token: "{{ csrf_token() }}",
        })
      }
    }
  })
</script>
@endpush
