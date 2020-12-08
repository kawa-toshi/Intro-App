<!-- デプロイした場合secure_asset -->
@extends('layouts/master')
<link rel="stylesheet" href="{{ secure_asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">
@push('css')
  <link href="{{ mix('css/top-page.css') }}" rel="stylesheet">
@endpush
@section('content')
<body>
  <div class="Wrapper">
    <div class="header">
      <p class="header__title"><img src="/assets/images/logo3.png"></p>
      @if (Route::has('login'))
      <div class="header__nav">
        @auth
          <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">投稿一覧</a>
        @else
          <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">ログイン</a>

          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">新規会員登録</a>
          @endif
        @endif
      </div>
      @endif
    </div>


    <div class="Main">
      <div class="Main__text">
        <h1 class="Main__text-heading">おすすめのアプリを共有しよう！！</h1>
        <p class="Main__text-content">intro-appは、おすすめのアプリを紹介しあうサービスです。<br>
        あなたのおすすめアプリを共有しましょう。<br>
        新しいアプリを発見できるかもしれません。</p>
      </div>
      @if (Route::has('login'))
      <div class="">
        @auth
        <a href="{{ url('/dashboard') }}" class="">Dashboard</a>
        @else
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="Btn">intro-appに登録する</a>
        @endif
        @endif
      </div>
        @endif
      <h1 class="Main__text-sub-heading">Let's Share App!!</h1>

      <!-- レスポンシブ ボタン -->
      <div class="Btn-small-wrapper">
      @auth
        <a href="{{ url('/dashboard') }}" class="Btn-small-wrapper__btn">投稿一覧</a>
        @else
        <a href="{{ route('login') }}" class="Btn-small-wrapper__btn">ログイン</a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="Btn-small-wrapper__btn">新規会員登録</a>
        @endif
      @endif
      </div>
    </div>
  </div>
@endsection
</body>
</html>
