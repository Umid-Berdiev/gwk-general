@extends('layouts.master')

@section('content')
<div id="resource" class="py-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 class="text-primary text-uppercase">
          {{ __('messages.Characteristics of the degree of pollution') }}
        </h4>
      </div>
    </div>
    @include('general.pages.resources.resource_form')
    @include('partials.alerts')
    <div class="row mb-3">
      <div class="col-auto ml-auto">
        @if(auth()->user()->org_name == 'gidromet')
        @if(auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Editor')
        <form action="{{route('resource.characteristics_water.accept')}}" method="post">
          @csrf
          <input type="hidden" name="year"
            value="{{ isset($last_update) && !is_null($last_update) ? $last_update->years : null }}">
          <input type="hidden" name="type" value="resource">
          <button type="submit" class="btn btn-warning btn-sm">{{ __("messages.Submit") }}</button>
        </form>
        @endif
        @endif
      </div>
      <div class="col-auto">
        <button class="btn btn-primary btn-sm" data-toggle="modal"
          data-target="#addModal">{{ __('messages.Add') }}</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered small ">
        <thead class="text-center bg-light">
          <tr>
            <th scope="col" rowspan="2">{{ __('messages.list of posts on rivers and canals') }}</th>
            <th scope="col" rowspan="2">{{ __('messages.Major pollutants') }}</th>
            <th scope="col" rowspan="2">{{ __('messages.Average annual excess of GDK') }}</th>
            <th scope="col" colspan="2">{{ __('messages.Maximum excess of MPC per year') }}</th>
          </tr>
          <tr>
            <th scope="col">{{ __('messages.observation date') }}</th>
            <th scope="col">{{ __('messages.multiplicity of excess of MPC') }}</th>
          </tr>
          <tr>
            <th>0</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($character_waters as $list)
          <tr class="text-center">
            <td class="p-2">{{$list->post_list->name}} - {{$list->post_list->post_place}} </td>
            <td class="p-2">{!! $list->chimicil_list->name !!}</td>
            <td class="p-2">{{$list->average_excess}}</td>
            <td class="p-2">{{$list->date_observation}}</td>
            <td class="p-2">{{$list->excess_ratio}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="addModalLabel">{{ __('messages.Adding form') }}</h4>
      </div>
      <div class="modal-body">
        <form id="modal-form" method="post" action="{{route('resource.characteristics_water.store')}}">
          @csrf
          <input type="hidden" name="selected_type_value" value="{{ $selected_type_value }}">
          <input type="hidden" name="selected_year" value="{{ $selected_year }}">
          <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <th>{{ __('messages.List of posts on rivers and canals') }}</th>
                <td class="form-group">
                  <select class="selectpicker form-control form-control-sm" data-live-search="true" name="post_place"
                    title="{{ __('messages.choose') }}.." data-width='100%'>
                    @foreach($posts_lists as $list)
                    <option value="{{$list->id}}">{{$list->name}} - {{$list->post_place}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>{{ __('messages.Chemistry list') }}</th>
                <td class="form-group">
                  <select class="selectpicker form-control form-control-sm" data-live-search="true" name="chemicals"
                    title="{{ __('messages.choose') }}.." data-width='100%'>
                    @foreach($chemicals as $list)
                    <option value="{{$list->id}}">{!! $list->name !!}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>{{ __('messages.Average annual excess of PDK') }}</th>
                <td>
                  <input type="number" step="0.1" name="average_excess"
                    value="{{old('average_excess', $average_excess)}}" class="form-control form-control-sm"
                    id="average_excess">
                </td>
              </tr>
              <tr>
                <th>{{ __('messages.observation date') }}</th>
                <td>
                  <input type="date" step="0.1" name="date_observation"
                    value="{{old('date_observation', $date_observation)}}" class="form-control form-control-sm"
                    id="date_observation">
                </td>
              </tr>
              <tr>
                <th>{{ __('messages.multiplicity of excess of MPC') }}</th>
                <td>
                  <input type="number" step="0.1" name="excess_ratio" value="{{old('excess_ratio', $excess_ratio)}}"
                    class="form-control form-control-sm" id="excess_ratio">
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('messages.close') }}</button>
        <button type="submit" form="modal-form" class="btn btn-sm btn-primary">{{ __('messages.save') }}</button>
      </div>
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
        await axios.post("{{ route('resource.characteristics_water.update') }}", {
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
