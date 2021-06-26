@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {{ __('messages.General Resource table 4') }}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidromet')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.river_recources.accept')}}" method="post">
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
            <th scope="col" rowspan="2">{{ __('messages.River') }}</th>
            <th scope="col" rowspan="2">{{ __('messages.Plot') }}</th>
            <th scope="col" colspan="3" rowspan="1">{{ __('messages.Characteristics of long-term runoff') }}</th>
            <th scope="col" rowspan="2" colspan="1">{{ __('messages.Observed runoff in the downstream section') }}
            </th>
            <th scope="col" colspan="2">{{ __('messages.Total flow change') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.River') }}средний</th>
            <th scope="col">{{ __('messages.maximal') }}</th>
            <th scope="col">{{ __('messages.minimal') }}</th>
            <th scope="col">{{ __('messages.location on') }}</th>
            <th scope="col">{{ __('messages.cumulative total') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($river_recourses as $river_recourse)
          <tr class="text-center">
            <td>{{$river_recourse->region_name}}</td>
            <td>{{$river_recourse->place}}</td>
            @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('average', {{ $river_recourse->id }})" value="{{$river_recourse->average}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('average', {{ $river_recourse->id }})" value="{{$river_recourse->average}}">
            </td>
            @endif
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('greatest', {{ $river_recourse->id }})" value="{{$river_recourse->greatest}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('greatest', {{ $river_recourse->id }})" value="{{$river_recourse->greatest}}">
            </td>
            @endif
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm " step="0.01" type="number"
                @change="changes('least', {{ $river_recourse->id }})" value="{{$river_recourse->least}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('least', {{ $river_recourse->id }})" value="{{$river_recourse->least}}">
            </td>
            @endif
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('lower_target', {{ $river_recourse->id }})" value="{{$river_recourse->lower_target}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('lower_target', {{ $river_recourse->id }})" value="{{$river_recourse->lower_target}}">
            </td>
            @endif
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('location', {{ $river_recourse->id }})" value="{{$river_recourse->location}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('location', {{ $river_recourse->id }})" value="{{$river_recourse->location}}">
            </td>
            @endif
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" step="0.01" type="number"
                @change="changes('cumulative', {{ $river_recourse->id }})" value="{{$river_recourse->cumulative}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" step="0.01" type="number"
                @change="changes('cumulative', {{ $river_recourse->id }})" value="{{$river_recourse->cumulative}}">
            </td>
            @endif
            @else
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('average', {{ $river_recourse->id }})" value="{{$river_recourse->average}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('average', {{ $river_recourse->id }})" value="{{$river_recourse->average}}">
            </td>
            @endif

            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('greatest', {{ $river_recourse->id }})" value="{{$river_recourse->greatest}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('greatest', {{ $river_recourse->id }})" value="{{$river_recourse->greatest}}">
            </td>
            @endif

            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('least', {{ $river_recourse->id }})" value="{{$river_recourse->least}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('least', {{ $river_recourse->id }})" value="{{$river_recourse->least}}">
            </td>
            @endif

            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('lower_target', {{ $river_recourse->id }})" value="{{$river_recourse->lower_target}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('lower_target', {{ $river_recourse->id }})" value="{{$river_recourse->lower_target}}">
            </td>
            @endif

            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('location', {{ $river_recourse->id }})" value="{{$river_recourse->location}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('location', {{ $river_recourse->id }})" value="{{$river_recourse->location}}">
            </td>
            @endif
            @if($river_recourse->is_approve)
            <td class="p-2">
              <input class="form-control form-control-sm" disabled step="0.01" type="number"
                @change="changes('cumulative', {{ $river_recourse->id }})" value="{{$river_recourse->cumulative}}">
            </td>
            @else
            <td class="p-2">
              <input class="form-control form-control-sm alert-danger" disabled step="0.01" type="number"
                @change="changes('cumulative', {{ $river_recourse->id }})" value="{{$river_recourse->cumulative}}">
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
        await axios.post("{{ route('resource.river_recources.update') }}", {
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
