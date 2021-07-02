<div id="sidebar-menu" class="col-md-3 col-lg-2 d-none bg-primary p-0">
  <div class="sidebar-sticky">
    @if(!starts_with(Route::current()->uri, 'admin'))
    <nav class="navbar flex-column p-0">
      <a class="nav-link {{ url()->current() == route('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
        @click="persist('anotherOne')">
        {{ __('messages.Dashboard') }}
      </a>

      <a class="nav-link" type="button" :class="{'active' : isShown1}" @click="persist('isShown1')">
        {{ __("messages.Datas") }}
        <i class="float-right bi" :class="{ 'bi-chevron-down' : !isShown1, 'bi-chevron-up' : isShown1 }"></i>
      </a>

      <div v-show="isShown1" class="navbar-collapse">
        <nav class="navbar-nav flex-column pl-4">
          <a href="{{route('resource')}}"
            class="nav-link {{ starts_with(Route::current()->uri, 'resources') ? 'active' : '' }}">{{ __("messages.Resources") }}</a>
          <a href="{{route('exchange-index')}}"
            class="nav-link {{ starts_with(Route::current()->uri, 'data-exchange') ? 'active' : '' }}">{{ __("messages.Data exchange") }}</a>
        </nav>
      </div>

      <a class="nav-link text-white bg-primary" :class="{'active' : isShown2}" type="button"
        @click="persist('isShown2')">
        {{ __("messages.Directories") }}
        <i class="float-right bi" :class="{ 'bi-chevron-down' : !isShown2, 'bi-chevron-up' : isShown2 }"></i>
      </a>

      <div v-show="isShown2" class="navbar-collapse">
        <nav class="navbar-nav flex-column pl-4">
          <a href="{{ route('directories.list_posts') }}"
            class="nav-link {{ url()->current() == route('directories.list_posts') ? 'active' : '' }}">
            {{ __("messages.List of posts on rivers and canals") }}
          </a>
          <a href="{{ route('directories.chemicals') }}"
            class="nav-link {{ url()->current() == route('directories.chemicals') ? 'active' : '' }}">
            {{ __("messages.List of chemical compositions") }}
          </a>
        </nav>
      </div>

      <a class="nav-link {{ url()->current() == route('report.index') ? 'active' : '' }}"
        href="{{route('report.index')}}" @click="persist('anotherOne')">
        {{ __("messages.Reports") }}
      </a>

      <a class="nav-link" href="#" @click="persist('anotherOne')">{{ __("messages.References") }}</a>
    </nav>
    @else
    <nav class="navbar flex-column p-0">
      <a id="users" class="nav-link {{ starts_with(Route::current()->uri, 'admin/users') ? 'active' : '' }}"
        href="{{ route('users.index') }}" @click="persist('anotherOne')">{{ __('messages.users') }}</a>
      <a class="nav-link" :class="{'active' : langs}" @click="persist('langs')"
        type="button">{{ __('messages.translations') }}
        <i class="float-right bi" :class="{ 'bi-chevron-down' : !langs, 'bi-chevron-up' : langs }"></i></a>
      <div v-show="langs" class="navbar-collapse">
        <nav class="navbar-nav flex-column pl-4">
          <a class="nav-link {{ starts_with(Route::current()->uri, 'admin/languages') ? 'active' : '' }}"
            href="{{ route('languages.index') }}">{{ __("messages.langs") }}</a>
          <a class="nav-link {{ starts_with(Route::current()->uri, 'admin/terms') ? 'active' : '' }}"
            href="{{ route('terms.index') }}">{{ __("messages.Terms") }}</a>
        </nav>
      </div>
    </nav>
    @endif
  </div>
</div>

@push('scripts')
<script>
  $('.navbar-collapse').on('shown.bs.collapse', function () {
    $(this).parent().find(".bi-chevron-down").removeClass("bi-chevron-down").addClass("bi-chevron-up");
  }).on('hidden.bs.collapse', function () {
    $(this).parent().find(".bi-chevron-up").removeClass("bi-chevron-up").addClass("bi-chevron-down");
  });
</script>
@endpush
