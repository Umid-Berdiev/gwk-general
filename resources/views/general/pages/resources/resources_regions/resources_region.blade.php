@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {{ __('messages.SURFACE AND UNDERGROUND WATER RESOURCES AND THEIR USE') }}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidromet')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.resource_regions.accept')}}" method="post">
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
    <div class="table-responsive mt-3">
      <table class="table table-bordered small">
        <thead class="text-center bg-light">
          <tr>
            <th rowspan="2" scope="col">{{ __('messages.Region') }}</th>
            <th scope="col" colspan="3">{{ __('messages.Long-term runoff') }}</th>
            <th scope="col" colspan="4" rowspan="1">
              {{ str_replace('{year}', $selected_year, __('messages.Water resources year')) }}</th>
            <th scope="col" rowspan="2" colspan="2">{{ __('messages.Total flow change') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.average value') }}</th>
            <th scope="col">{{ __('messages.maximal value') }}</th>
            <th scope="col">{{ __('messages.minimal value') }}</th>
            <th scope="col">{{ __('messages.Local runoff') }}</th>
            <th scope="col">{{ __('messages.inflow') }}</th>
            <th scope="col">{{ __('messages.ottosis outside the region') }}</th>
            <th scope="col">{{ __('messages.common resources') }}</th>
          </tr>
          <tr class="text-center">
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($resources as $resource)
          <tr class="text-center">
            <td class="p-2">{{ $resource->region_name }}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_values', {{ $resource->id }})" value="{{ $resource->average_values }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average_values', {{ $resource->id }})" value="{{ $resource->average_values }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('highest_values', {{ $resource->id }})" value="{{ $resource->highest_values }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('highest_values', {{ $resource->id }})" value="{{ $resource->highest_values }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('smallest_value', {{ $resource->id }})" value="{{ $resource->smallest_value }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('smallest_value', {{ $resource->id }})" value="{{ $resource->smallest_value }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('local_rows', {{ $resource->id }})" value="{{ $resource->local_rows }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('local_rows', {{ $resource->id }})" value="{{ $resource->local_rows }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('inflow', {{ $resource->id }})" value="{{ $resource->inflow }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('inflow', {{ $resource->id }})" value="{{ $resource->inflow }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('outflow_outside', {{ $resource->id }})" value="{{ $resource->outflow_outside }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('outflow_outside', {{ $resource->id }})" value="{{ $resource->outflow_outside }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('shared_resources', {{ $resource->id }})" value="{{ $resource->shared_resources }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('shared_resources', {{ $resource->id }})" value="{{ $resource->shared_resources }}">
            </td>
            @endif
            @if($resource->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('total_row', {{ $resource->id }})" value="{{ $resource->total_row }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('total_row', {{ $resource->id }})" value="{{ $resource->total_row }}">
            </td>
            @endif
            @else
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average_values', {{ $resource->id }})" value="{{ $resource->average_values }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('highest_values', {{ $resource->id }})" value="{{ $resource->highest_values }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('smallest_value', {{ $resource->id }})" value="{{ $resource->smallest_value }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('local_rows', {{ $resource->id }})" value="{{ $resource->local_rows }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('inflow', {{ $resource->id }})" value="{{ $resource->inflow }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('outflow_outside', {{ $resource->id }})" value="{{ $resource->outflow_outside }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('shared_resources', {{ $resource->id }})" value="{{ $resource->shared_resources }}">
            </td>
            <td class="p-2">
              <input disabled class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('total_row', {{ $resource->id }})" value="{{ $resource->total_row }}">
            </td>
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
        await axios.post("{{ route('resource.resource_regions.update') }}", {
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
