<div class="row">
  <div class="col-auto">
    @if(isset($last_update))
    <p class="small">
      {{ $last_update->user_id ? __('messages.Change') . $last_update->users->getFullname() .' |'  : '' }}
      {{ $last_update->updated_at}} | {{ __('messages.Status') }}:
      {{ $last_update->is_approve ? __('messages.Approved') : __('messages.Not approved') }}
    </p>
    @endif
  </div>
</div>
<form action="{{ route('resource.type') }}" method="get">
  <div class="row">
    <div class="col-auto">
      <select class="form-control form-control-sm" name="selected_type_value" required>
        <option disabled selected value="" hidden>{{ __('messages.select_form') }}</option>
        @foreach ($user_resource_types as $type)
        <option @if (isset($selected_type_value) && $selected_type_value==$type['value']) selected @endif
          value="{{ $type['value'] }}">
          {{ __('messages.' . $type['name']) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-auto">
      <input required type="number" min="1900" max="{{ date('Y') }}"
        value="{{ isset($selected_year) ? $selected_year : date('Y') }}" name="selected_year"
        class="form-control form-control-sm" placeholder="{{ __('messages.Year') }}" required>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary btn-sm">
        {{ __('messages.Open') }}
      </button>
    </div>
  </div>
</form>
