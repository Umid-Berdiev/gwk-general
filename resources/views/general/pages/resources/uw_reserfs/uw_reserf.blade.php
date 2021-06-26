@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {!! str_replace('{year}', $selected_year, __('messages.Operational groundwater reserves as of year')) !!}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidrogeologiya')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.uw_reserf.accept')}}" method="post">
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
      <table class="table table-bordered small ">
        <thead class="text-center bg-light">
          <tr>
            <th rowspan="2" scope="col">{{ __('messages.Region') }}</th>
            <th scope="col" colspan="2">{{ __('messages.Long-term runoff') }}</th>
            <th scope="col" rowspan="2" colspan="2">{{ __('messages.Total flow change') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.average value') }}</th>
            <th scope="col">{{ __('messages.maximal value') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($uw_reserfs as $uw_reserf)
          <tr class="text-center">
            <td class="p-2">{{ $uw_reserf->region_name }}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($uw_reserf->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('total', {{ $uw_reserf->id }})" value="{{ $uw_reserf->total }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('total', {{ $uw_reserf->id }})" value="{{ $uw_reserf->total }}">
            </td>
            @endif
            @if($uw_reserf->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('surface_water', {{ $uw_reserf->id }})" value="{{ $uw_reserf->surface_water }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('surface_water', {{ $uw_reserf->id }})" value="{{ $uw_reserf->surface_water }}">
            </td>
            @endif
            @if($uw_reserf->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('ex_reserf', {{ $uw_reserf->id }})" value="{{ $uw_reserf->ex_reserf }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('ex_reserf', {{ $uw_reserf->id }})" value="{{ $uw_reserf->ex_reserf }}">
            </td>
            @endif
            @else
            @if($uw_reserf->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('total', {{ $uw_reserf->id }})" value="{{ $uw_reserf->total }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('total', {{ $uw_reserf->id }})" value="{{ $uw_reserf->total }}">
            </td>
            @endif
            @if($uw_reserf->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('surface_water', {{ $uw_reserf->id }})" value="{{ $uw_reserf->surface_water }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('surface_water', {{ $uw_reserf->id }})" value="{{ $uw_reserf->surface_water }}">
            </td>
            @endif
            @if($uw_reserf->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('ex_reserf', {{ $uw_reserf->id }})" value="{{ $uw_reserf->ex_reserf }}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('ex_reserf', {{ $uw_reserf->id }})" value="{{ $uw_reserf->ex_reserf }}">
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
        await axios.post("{{ route('resource.uw_reserf.update') }}", {
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
