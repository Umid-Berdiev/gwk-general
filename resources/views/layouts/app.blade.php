<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'ГОСУДАРСТВЕННЫЙ ВОДНЫЙ КАДАСТР РЕСПУБЛИКИ УЗБЕКИСТАН') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @yield('css')

</head>

<body class="bg-info">
  <div id="app">
    <main>
      @yield('content')
    </main>
  </div>

  <script>
    function togglePasswordVisible() {
      const passwordInput = document.getElementById("password");
      passwordInput.type === "password" ? passwordInput.type = "text" : passwordInput.type = "password";
    }
  </script>
</body>

</html>
