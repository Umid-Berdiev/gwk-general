<form id="data-exchange-form" action="{{ route('exchange.instance.element.data') }}" method="get">
  <div class="row">
    <div class="col-3">
      <select required class="form-control form-control-sm form_class text-capitalize"
        @change="getInstanceElements($event.target.value)" name="selected_instance" v-model="selectedInstance">
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
      <input v-if="selectedElement == 'Rejim Gidro' || selectedInstance === 'gidrogeologiya'" required type="number"
        min="1900" max="{{ date('Y') }}" value="{{ isset($selected_date) ? $selected_date : date('Y') }}"
        name="selected_date" class="form-control form-control-sm" placeholder="{{ __('messages.Year') }}" required>
      <input v-else required type="month" name="selected_date" class="form-control form-control-sm"
        @isset($selected_date) value={{ $selected_date }} @endisset>
    </div>

    <div class="col-auto">
      <button class="btn btn-sm btn-primary" type="submit">
        <i class="bi bi-filter"></i>
        {{ __('messages.Open') }}
      </button>
    </div>
  </div>
</form>

@push('scripts')
<script>
  const dataExchange = new Vue({
    el:"#data-exchange-form",
    data() {
      return {
        instanceElements: [],
        selectedInstance: "",
        selectedElement: "",
        selectedDate: null
      }
    },
    methods: {
      async getInstanceElements(instance) {
        this.selectedElement = ""
        await axios
          .get("{{ route('exchange.instance.elements') }}", {params: {instance: instance}})
          .then(response => this.instanceElements = response.data)
      }
    },
    mounted() {
      this.selectedDate = @if(isset($selected_date)) @json((int) $selected_date) @else null @endif;
      const selectedInstance = @if(isset($selected_instance)) @json($selected_instance) @else null @endif;
      if (!_.isEmpty(selectedInstance)) {
        this.selectedInstance = selectedInstance;
        this.getInstanceElements(selectedInstance);
      }
      this.selectedElement = @if(isset($selected_element)) @json($selected_element) @else "" @endif;
    }
  })
</script>
@endpush
