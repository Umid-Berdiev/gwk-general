@extends('layouts.master')

@section('content')
<div class="py-3">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h6 class="text-uppercase font-weight-bold">{{ __('messages.Data exchange') }}
            </h6>
          </div>
        </div>
        <!-- search form -->
        @include('general.data-exchange.exchange-form')
        <!-- end search form -->
        @include('general.data-exchange.export-form')
      </div>

      <div class="card-body">
        <div class="table-responsive" id="data-exchange-table">
          <div v-if="isLoading" class="spinner-grow position-absolute"
            style="width: 3rem; height: 3rem; left: 50%; top: 50%;" role="status">
          </div>
          <table class="table table-bordered table-sm small" id="exportable_table">
            <thead>
              <tr class="bir">
                <th>
                  {{-- <input type="checkbox" id="markAll" value="1"> --}}
                  <input type="checkbox" v-model="mainCheckbox">
                </th>
                <th>{{ __('messages.Name') }}</th>
                <th>{{ __('messages.Parameter') }}</th>
                <?php for($m = 1; $m <= 12; $m++) { ?>
                <th>{{ App\Components\Month::name($m) }}</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody class="text-right">
              @forelse($allDatas as $data)
              {{-- @dd($data) --}}
              <tr>
                <td class="text-center">
                  <input type="checkbox" v-model="checkList" value="{{ $data['id'] }}">
                </td>
                <td class="text-left">
                  <pre>{{ $data['station'] ? $data['station']['station_name'] : '' }}</pre>
                </td>
                <td class="text-left">{{ $data['parameter'] ? $data['parameter']['param_name'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['I'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['II'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['III'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['IV'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['V'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['VI'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['VII'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['VIII'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['IX'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['X'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['XI'] : '' }}</td>
                <td>{{ $data['gidromet_average'] ? $data['gidromet_average']['XII'] : '' }}</td>
              </tr>
              @empty
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const dataExchangeTable = new Vue({
    el:"#data-exchange-table",
    data() {
      return {
        isLoading: false,
        checkList: [],
        reestrData: []
      }
    },
    computed: {
      mainCheckbox: {
        get() {
          return this.reestrData ? this.checkList.length && this.checkList.length == this.reestrData.length : false;
        },

        set(value) {
          let selected = [];
          if (value) this.reestrData.forEach(item => selected.push(item.id));
          this.checkList = selected;
        }
      },
    },
    mounted() {
      this.reestrData = @if(isset($allDatas)) @json($allDatas) @else [] @endif;
    }
  })
</script>
@endpush
