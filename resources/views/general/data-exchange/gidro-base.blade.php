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
          @if(isset($allDatas[0]) && $allDatas[0])
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
                  <td>{{ $data['january'] ??  ''  }}</td>
                  <td>{{ $data['february'] ??  ''  }}</td>
                  <td>{{ $data['march'] ??  ''  }}</td>
                  <td>{{ $data['april'] ??  ''  }}</td>
                  <td>{{ $data['may'] ??  ''  }}</td>
                  <td>{{ $data['june'] ??  ''  }}</td>
                  <td>{{ $data['july'] ??  ''  }}</td>
                  <td>{{ $data['august'] ??  ''  }}</td>
                  <td>{{ $data['september'] ??  ''  }}</td>
                  <td>{{ $data['october'] ??  ''  }}</td>
                  <td>{{ $data['november'] ??  ''  }}</td>
                  <td>{{ $data['decamber'] ??  ''  }}</td>
                </tr>
                @empty
                @endforelse
              </tbody>
            </table>
          @else
              <tr>
                  <div class="text-center">
                      Данные не найдены
                  </div>
              </tr>
          @endif
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
