
@extends('layouts/head')
@push('css')
  <link href="{{ asset('css/top-page.css') }}" rel="stylesheet">
@endpush

<body>
  <div class="Wrapper">
    <div class="header">
      <p class="header__title"><img src="/assets/images/logo3.png" width="100" height="80"></p>
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
      <h1 class="Main__text-heading">Let's Share App!!</h1>
    </div>

    <!-- フッター -->
    <div class="Footer">
      <p class="Footer__title">intro-app © 2020</p>
    </div>
  </div>
</body>
</html>
