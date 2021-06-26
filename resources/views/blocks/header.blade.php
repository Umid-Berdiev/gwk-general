<div id="header" class="bg-primary">
  <div class="row align-items-center py-2">
    <div style="cursor: pointer" onclick="window.location.href='{{route('dashboard')}}'" class="text-white col-auto">
      <h3 class="font-weight-bold">{{ __("messages.Unified Water Cadastre") }}</h3>
      <p>{{ __("messages.Common base") }}</p>
    </div>
    <div class="col-auto px-1 ml-auto">
      <form class="my-auto" action="{{ route('lang.set') }}">
        <select class="custom-select custom-select-sm" name="lang" onchange="this.form.submit()">
          @foreach($languages as $lang)
          <option {{ $lang->language_prefix == app()->getLocale() ? 'selected' : '' }}>
            {{$lang->language_prefix}}
          </option>
          @endforeach
        </select>
      </form>
    </div>
    <div class="col-auto px-1">
      <a class="btn btn-primary" href="{{ route('map') }}"><i class="bi bi-map"></i>
        {{ __("messages.карта") }}</a>
    </div>

    @if(auth()->user()->role->name = 'Administrator')
    <div class="col-auto px-1">
      <a class="btn btn-primary" href="{{ route('admin') }}"><i class="bi bi-gear"></i></a>
    </div>
    @endif

    <div class="col-auto px-1">
      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-person"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        @if(auth()->user())
        <p class="dropdown-item fullname ">
          {{ auth()->user()->getFullname() }}
        </p>
        <p class="dropdown-item">{{ auth()->user()->user_email }}</p>
        <form method="post" action="{{ route('logout') }}">
          @csrf
          <button class="dropdown-item">
            <i class="bi bi-box-arrow-left"></i>
            {{ __("messages.Выход") }}
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>
</div>
