<!DOCTYPE html>
<html lang="ru">
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Inputmask CSS -->
  {{-- <link rel="stylesheet" href="{{asset('css/inputmask.css')}}"> --}}

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">

  <!-- custom css -->
  <link rel="stylesheet" href="{{asset('css/dashboard.css')}}" />
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

  @yield('css')
</head>

<body>
  <div id="header" class="container-fluid bg-primary">
    <div class="row align-items-center">
      <div class="col-lg-2 col-3 border-right border-white text-center">
        @include('blocks.left-header')
      </div>
      <div class="col-lg-10 col-9">
        @include('blocks.header')
      </div>
    </div>
  </div>

  <div id="content" class="container-fluid">
    @include('blocks.sidebar')
    <main id="main-content" class="px-0 w-100 ml-auto">
      <div class="container">
        <div class="row">
          <div class="col-auto position-absolute" style="z-index: 1001; right: 0;">
            @include('partials.alerts')
          </div>
        </div>
      </div>
      @yield('content')
    </main>
  </div>

  @yield('modal')

  <!-- js scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/bootstrap-custom-file-input.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/vue.js') }}"></script>

  <!-- Inputmask JS -->
  {{-- <script src="{{ asset('js/inputmask.min.js') }}"></script> --}}

  {{-- <script>
    $(":input").inputmask();
    bsCustomFileInput.init();
  </script> --}}
  @stack('scripts')
</body>

</html>
