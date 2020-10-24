

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>intro-app</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  @stack('css')
  <!-- <link rel="stylesheet" href="{{ asset('css/top-page.css') }}"> -->
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>



