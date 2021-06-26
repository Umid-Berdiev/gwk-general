@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {!! str_replace('{year}', $selected_year, __('messages.water use for various needs in regions')) !!}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'minvodxoz')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.water_use_various_needs.accept')}}" method="post">
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
            <th scope="col" rowspan="3">{{ __('messages.Region') }}</th>
            <th scope="col" colspan="3">{{ __('messages.Water taken') }}</th>
            <th scope="col" colspan="6">{ __('messages.By industry sectors') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.from surface sources') }}</th>
            <th scope="col">{{ __('messages.from underground sources') }}</th>
            <th scope="col">{{ __('messages.total') }}</th>
            <th scope="col">{{ __('messages.irrigation') }}</th>
            <th scope="col">{{ __('messages.industry') }}</th>
            <th scope="col">{{ __('messages.communal services') }}</th>
            <th scope="col">{{ __('messages.fishery') }}</th>
            <th scope="col">{{ __('messages.irrevocably in energy') }}</th>
            <th scope="col">{{ __('messages.others') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($water_use_needs as $ground_water)
          <tr class="text-center">
            <td class="p-2">{{$ground_water->region_name}}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('from_surface_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_surface_sources}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('from_surface_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_surface_sources}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('from_underground_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_underground_sources}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('from_underground_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_underground_sources}}">
            </td>
            @endif
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
                @change="changes('irrigation', {{ $ground_water->id }})" value="{{$ground_water->irrigation}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('irrigation', {{ $ground_water->id }})" value="{{$ground_water->irrigation}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('industry', {{ $ground_water->id }})" value="{{$ground_water->industry}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('industry', {{ $ground_water->id }})" value="{{$ground_water->industry}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('utilities', {{ $ground_water->id }})" value="{{$ground_water->utilities}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('utilities', {{ $ground_water->id }})" value="{{$ground_water->utilities}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('fisheries', {{ $ground_water->id }})" value="{{$ground_water->fisheries}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('fisheries', {{ $ground_water->id }})" value="{{$ground_water->fisheries}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('irrevocably_energy', {{ $ground_water->id }})"
                value="{{$ground_water->irrevocably_energy}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('irrevocably_energy', {{ $ground_water->id }})"
                value="{{$ground_water->irrevocably_energy}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('other', {{ $ground_water->id }})" value="{{$ground_water->other}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('other', {{ $ground_water->id }})" value="{{$ground_water->other}}">
            </td>
            @endif
            @else
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('from_surface_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_surface_sources}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('from_surface_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_surface_sources}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('from_underground_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_underground_sources}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('from_underground_sources', {{ $ground_water->id }})"
                value="{{$ground_water->from_underground_sources}}">
            </td>
            @endif

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
                @change="changes('irrigation', {{ $ground_water->id }})" value="{{$ground_water->irrigation}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('irrigation', {{ $ground_water->id }})" value="{{$ground_water->irrigation}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('industry', {{ $ground_water->id }})" value="{{$ground_water->industry}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('industry', {{ $ground_water->id }})" value="{{$ground_water->industry}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('utilities', {{ $ground_water->id }})" value="{{$ground_water->utilities}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('utilities', {{ $ground_water->id }})" value="{{$ground_water->utilities}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('fisheries', {{ $ground_water->id }})" value="{{$ground_water->fisheries}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('fisheries', {{ $ground_water->id }})" value="{{$ground_water->fisheries}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('irrevocably_energy', {{ $ground_water->id }})"
                value="{{$ground_water->irrevocably_energy}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('irrevocably_energy', {{ $ground_water->id }})"
                value="{{$ground_water->irrevocably_energy}}">
            </td>
            @endif
            @if($ground_water->is_approve)
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('other', {{ $ground_water->id }})" value="{{$ground_water->other}}">
            </td>
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('other', {{ $ground_water->id }})" value="{{$ground_water->other}}">
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
        await axios.post("{{ route('resource.water_use_various_needs.update') }}", {
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
