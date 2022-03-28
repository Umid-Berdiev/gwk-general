<div class="row">
  <div class="col-md-11">
    <form id="data-exchange-form" action="{{ route('exchange.instance.element.data') }}" method="get">
      <div class="row">
        <div class="col-3">
          <select required class="form-control form-control-sm form_class text-capitalize"
                  @change="getInstanceElements($event.target.value)" name="selected_instance">
            <option selected hidden>{{ __('messages.Select') }}</option>
            @foreach($instances as $value)
              <option value="{{ $value }}" @if(isset($selected_instance) && $selected_instance==$value) selected @endif>
                {{ $value }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-3">
          <select required class="form-control form-control-sm" id="elements_form" name="selected_element"
                  v-model="selectedElement">
            <option selected hidden value="">{{ __('messages.Select') }}</option>
            <option v-for="element in instanceElements" :value="element" v-text="element"
                    :selected="selectedElement == element">
            </option>
          </select>
        </div>

        <div class="col-2">
          <input v-if="selectedElement == 'Rejim Gidro'" required type="number" min="1900" max="{{ date('Y') }}"
                 value="{{ isset($selected_date) ? $selected_date : date('Y') }}" name="selected_date"
                 class="form-control form-control-sm" placeholder="{{ __('messages.Year') }}" required>
          <input v-else required type="month" name="selected_date" class="form-control form-control-sm"
                 @isset($selected_date) value={{ $selected_date }} @endisset>
        </div>

        <div class="col-md-3">
          <button class="btn btn-sm btn-primary" name="action" value="data-api" type="submit">
            <i class="bi bi-filter"></i>
            {{ __('messages.Выгрузка данных') }}
          </button>
          <button class="btn btn-sm btn-success" name="action" value="data-base" type="submit">
            <i class="bi bi-filter"></i>
            {{ __('messages.Поиск') }}
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-1">
    @if(isset($selected_element) && $selected_element && isset($action))
      <form action="{{route('exchange.save-history-data')}}" method="POST">
        @csrf
        <input type="hidden" name="allDatas" value="{{ json_encode($allDatas ?? '')}}">
        <input type="hidden" name="r_year" value="{{$r_year ?? ''}}">
        <input type="hidden" name="result" value="{{json_encode($result ?? '')}}">
        <input type="hidden" name="formObjects" value="{{json_encode($formObjects ?? '')}}">
        <input type="hidden" name="selected_element" value="{{ $selected_element ?? ''}}">
        <div class="col-md-12 px-1">
          <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{__('messages.Menu')}}
          </button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            @if(isset($action) && $action !='data-base')
              <button class="dropdown-item" type="submit">
                <i class="bi bi-save"></i>
                {{ __('messages.Сохранить') }}
              </button>
            @endif
            <a class="dropdown-item"
               href="{{route('exchange.data-logs',['selected_instance' => $selected_instance , 'selected_element' => $selected_element ,'selected_date' => $selected_date ,'action' => $action,'type' => getDataEchangeType($selected_element)])}}">
              <i class="bi bi-clock-history"></i>
              {{ __('messages.История') }}
            </a>
            <button onclick="exportExcel()" type="button" class="dropdown-item">
              <i class="bi bi-file-earmark-excel"></i>
              {{ __('messages.Export') }}
            </button>
          </div>
        </div>
      </form>
    @endif
  </div>

</div>

@push('scripts')
  <script>
    const dataExchange = new Vue({
      el: "#data-exchange-form",
      data() {
        return {
          instanceElements: [],
          selectedDate: null,
          selectedElement: ""
        }
      },
      computed: {},
      methods: {
        async getInstanceElements(instance) {
          this.selectedElement = ""
          await axios
            .get("{{ route('exchange.instance.elements') }}", {params: {instance: instance}})
            .then(response => this.instanceElements = response.data)
        }
      },
      mounted() {
        this.selectedDate = @if(isset($selected_date)) @json($selected_date) @else null @endif;
        const selectedInstance = @if(isset($selected_instance)) @json($selected_instance) @else null @endif;
        if (!_.isEmpty(selectedInstance)) {
          this.getInstanceElements(selectedInstance);
        }
        this.selectedElement = @if(isset($selected_element)) @json($selected_element) @else "" @endif;
      }
    })
  </script>
@endpush
