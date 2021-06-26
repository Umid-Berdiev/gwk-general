@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {{ __('messages.changes in water reserves and levels') }}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidromet')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.change_water_reserves.accept')}}" method="post">
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
            <th scope="col" rowspan="2">№</th>
            <th scope="col" rowspan="2">{{ __('messages.Reservoir') }}</th>
            <th scope="col" rowspan="2">{{ __('messages.Average long-term water reserve of lakes') }}</th>
            <th scope="col" rowspan="2">{{ __('messages.Average long-term level of lakes in the NPU') }}</th>
            <th scope="col" colspan="3">{{ __('messages.Water supply') }}</th>
            <th scope="col" colspan="3">{{ __('messages.Water level') }}</th>
          </tr>
          <tr>
            <th>{{ str_replace('{year}', "01.01." . $selected_year, __('messages.to year')) }}</th>
            <th>{{ str_replace('{year}', "01.01." . ($selected_year + 1), __('messages.to year')) }}</th>
            <th>{{ __('messages.annual change') }}</th>
            <th>{{ str_replace('{year}', "01.01." . $selected_year, __('messages.to year')) }}</th>
            <th>{{ str_replace('{year}', "01.01." . ($selected_year + 1), __('messages.to year')) }}</th>
            <th>{{ __('messages.change per year') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($change_waters as $key=>$ground_water)
          <tr class="text-center">
            <td class="p-2">{{$key+1}}</td>
            <td class="p-2">{{$ground_water->lake}}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_water_volume', {{ $ground_water->id }})"
                value="{{$ground_water->average_water_volume}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_water_volume', {{ $ground_water->id }})"
                value="{{$ground_water->average_water_volume}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_long_term_level', {{ $ground_water->id }})"
                value="{{$ground_water->average_long_term_level}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_long_term_level', {{ $ground_water->id }})"
                value="{{$ground_water->average_long_term_level}}">
            </td>
            @endif
            <td class="p-2"></td>
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('water_supply', {{ $ground_water->id }})" value="{{$ground_water->water_supply}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('water_supply', {{ $ground_water->id }})" value="{{$ground_water->water_supply}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('annual_change', {{ $ground_water->id }})" value="{{$ground_water->annual_change}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('annual_change', {{ $ground_water->id }})" value="{{$ground_water->annual_change}}">
            </td>
            @endif
            <td class="p-2"></td>
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('water_level', {{ $ground_water->id }})" value="{{$ground_water->water_level}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('water_level', {{ $ground_water->id }})" value="{{$ground_water->water_level}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('change_for_year', {{ $ground_water->id }})"
                value="{{$ground_water->change_for_year}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('change_for_year', {{ $ground_water->id }})"
                value="{{$ground_water->change_for_year}}">
            </td>
            @endif
            @else
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_water_volume', {{ $ground_water->id }})"
                value="{{$ground_water->average_water_volume}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_water_volume', {{ $ground_water->id }})"
                value="{{$ground_water->average_water_volume}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_long_term_level', {{ $ground_water->id }})"
                value="{{$ground_water->average_long_term_level}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_long_term_level', {{ $ground_water->id }})"
                value="{{$ground_water->average_long_term_level}}">
            </td>
            @endif
            <td class="p-2"></td>
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('water_supply', {{ $ground_water->id }})" value="{{$ground_water->water_supply}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('water_supply', {{ $ground_water->id }})" value="{{$ground_water->water_supply}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('annual_change', {{ $ground_water->id }})" value="{{$ground_water->annual_change}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('annual_change', {{ $ground_water->id }})" value="{{$ground_water->annual_change}}">
            </td>
            @endif
            <td class="p-2"></td>
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('water_level', {{ $ground_water->id }})" value="{{$ground_water->water_level}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('water_level', {{ $ground_water->id }})" value="{{$ground_water->water_level}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('change_for_year', {{ $ground_water->id }})"
                value="{{$ground_water->change_for_year}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('change_for_year', {{ $ground_water->id }})"
                value="{{$ground_water->change_for_year}}">
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
        await axios.post("{{ route('resource.change_water_reserves.update') }}", {
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
