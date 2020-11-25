<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>intro-app</title>
  <!-- 本番ではsecure_asset -->
  <!-- <link rel="stylesheet" href="{{ secure_asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/footer.css') }}"> -->
  @stack('css')
  <script src="{{ mix('js/app.js') }}" defer></script>
  <script src="//code.jquery.com/jquery-3.3.1.min.js" defer></script>
  <!-- <script src="{{ mix('js/ajaxComment.js') }}" defer></script>
  <script src="{{ mix('js/ajaxCommentDelete.js') }}" defer></script> -->
  <!-- <script src="{{ mix('js/imagePreview.js') }}" defer></script>
  <script src="{{ mix('js/profile_image_preview.js') }}" defer></script>
  <script src="{{ mix('js/cover_image_preview.js') }}" defer></script> -->
  <!-- <script src="{{ mix('js/ajaxlike.js') }}" defer></script> -->
</head>

<body>

@yield('content')

<footer class="Footer">
    <p class="Footer__title">intro-app © 2020</p>
</footer>
</body>
</html>