@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="ml-12 mb-12 font-weight-bold text-primary text-uppercase">
          {{ __('messages.General Resource table 3') }}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidromet')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.water_uses.accept')}}" method="post">
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
      <table class="table table-bordered small ">
        <thead class="text-center bg-light">
          <tr>
            <th rowspan="2" scope="col">{{ __('messages.Region') }}</th>
            <th scope="col" colspan="5">{{ __('messages.Water taken') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.total km') }}<sup>3</sup></th>
            <th scope="col">{{ __('messages.from the river network') }}</th>
            <th scope="col">{{ __('messages.from inland rivers') }}</th>
            <th scope="col">{{ __('messages.from underground sources') }}</th>
            <th scope="col">{{ __('messages.from collectors') }}</th>
          </tr>
          <tr class="text-center">
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($water_uses as $water_use)
          <tr class="text-center">
            <td class="p-2">{{$water_use->region_name}}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('total_km', {{$water_use->id}})" value="{{$water_use->total_km}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('total_km', {{$water_use->id}})" value="{{$water_use->total_km}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm " step="0.01" type="number"
                @change="changes('river_network', {{$water_use->id}})" value="{{$water_use->river_network}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('river_network', {{$water_use->id}})" value="{{$water_use->river_network}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('inland_rivers', {{$water_use->id}})" value="{{$water_use->inland_rivers}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('inland_rivers', {{$water_use->id}})" value="{{$water_use->inland_rivers}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('underground_sources', {{$water_use->id}})"
                value="{{$water_use->underground_sources}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('underground_sources', {{$water_use->id}})"
                value="{{$water_use->underground_sources}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('from_collector', {{$water_use->id}})" value="{{$water_use->from_collector}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('from_collector', {{$water_use->id}})" value="{{$water_use->from_collector}}">
            </td>
            @endif

            @else
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('total_km', {{$water_use->id}})" value="{{$water_use->total_km}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('total_km', {{$water_use->id}})" value="{{$water_use->total_km}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('river_network', {{$water_use->id}})" value="{{$water_use->river_network}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('river_network', {{$water_use->id}})" value="{{$water_use->river_network}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('inland_rivers', {{$water_use->id}})" value="{{$water_use->inland_rivers}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('inland_rivers', {{$water_use->id}})" value="{{$water_use->inland_rivers}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm " disabled step="0.01" type="number"
                @change="changes('underground_sources', {{$water_use->id}})"
                value="{{$water_use->underground_sources}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('underground_sources', {{$water_use->id}})"
                value="{{$water_use->underground_sources}}">
            </td>
            @endif
            @if($water_use->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('from_collector', {{$water_use->id}})" value="{{$water_use->from_collector}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('from_collector', {{$water_use->id}})" value="{{$water_use->from_collector}}">
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
        await axios.post("{{ route('resource.water_uses.update') }}", {
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
