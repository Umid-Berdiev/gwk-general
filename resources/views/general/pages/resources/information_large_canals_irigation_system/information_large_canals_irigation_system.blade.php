@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {{ __('messages.information about large canals') }}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidromet')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.information_large_canals_irigation_system.accept')}}" method="post">
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
            <th scope="col">{{ __('messages.River') }}</th>
            <th scope="col">{{ __('messages.Distance from the river km') }}</th>
            <th scope="col">{{ __('messages.River') }}canale name</th>
            <th scope="col">{{ __('messages.Channel bandwidth') }}</th>
            <th scope="col">{{ __('messages.Average annual water') }}</th>
            <th scope="col">{{ __('messages.Water withdrawn') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($information_large_canals as $key=>$ground_water)
          <tr class="text-center">
            <td class="p-2">{{$ground_water->river}}</td>
            <td class="p-2">{{$ground_water->distance_river}}</td>
            <td class="p-2">{{$ground_water->name_canal}}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('canal_bandwidth', {{ $ground_water->id }})"
                value="{{$ground_water->canal_bandwidth}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('canal_bandwidth', {{ $ground_water->id }})"
                value="{{$ground_water->canal_bandwidth}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_water', {{ $ground_water->id }})" value="{{$ground_water->average_water}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_water', {{ $ground_water->id }})" value="{{$ground_water->average_water}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('canal_main_structures', {{ $ground_water->id }})"
                value="{{$ground_water->canal_main_structures}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('canal_main_structures', {{ $ground_water->id }})"
                value="{{$ground_water->canal_main_structures}}">
            </td>
            @endif
            @else
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('canal_bandwidth', {{ $ground_water->id }})"
                value="{{$ground_water->canal_bandwidth}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('canal_bandwidth', {{ $ground_water->id }})"
                value="{{$ground_water->canal_bandwidth}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_water', {{ $ground_water->id }})" value="{{$ground_water->average_water}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_water', {{ $ground_water->id }})" value="{{$ground_water->average_water}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('canal_main_structures', {{ $ground_water->id }})"
                value="{{$ground_water->canal_main_structures}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('canal_main_structures', {{ $ground_water->id }})"
                value="{{$ground_water->canal_main_structures}}">
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
        await axios.post("{{ route('resource.information_large_canals_irigation_system.update') }}", {
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
