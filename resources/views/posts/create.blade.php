@extends('layouts/master')
@push('css')
    <link href="{{ asset('css/post/create.css') }}" rel="stylesheet">
@endpush

@section('content')

<x-app-layout>


  <x-slot name="header">
    <nav class="Menu">
      <h2 class="Menu__item--bold">
          新規投稿
      </h2>
      <a href="{{ route('post') }}" class="Menu__item">
          投稿一覧
      </a>
      <!-- ここifに変える -->
      @if($my_introduction)
      <a href="{{ route('create') }}"  class="Menu__item">
          新規投稿
      </a>
      @else
      <a href="#" id="introduction_pop" class="Menu__item">
          新規投稿(この機能を利用するにはプロフィール登録が必要です)
      </a>
      @endif
      <a href="/introductions/{{ $user->id }}" class="Menu__item">
          マイページ
      </a>
    </nav>
  </x-slot>


<div class="Wrapper">
  <div class="Wrapper__title">CREATE</div>
    <div class="Post-box">
      <form method="POST" action="{{ route('store')}}" enctype="multipart/form-data">
        @csrf
        <div class="Post-box__user">
          @if($profile_image_path)
          <img class="Post-box__img" src="{{ $profile_image_path }}" alt="{{ Auth::user()->name }}" />
          @else
          <p class="Post-box__img-none">画像がありません</p>
          @endif
          <p class="Post-box__user-name">{{ $user->name }}</p>
        </div>

        <div id="PreviewArea"></div>
        <div class="Post-box__top">
          <label for="Post-image" class="Image-field simple_square_btn">
            <i class="fas fa-camera"></i>
            トップ画像を投稿できます
            <input type="file" name="image_path"  id="Post-image">
          </label>
        </div>

        <div class="Post-box__content">
          <div class="App-name">
            
            <input type="text" class="Post-box__content-title" name="title" placeholder="アプリ名" required autocomplete="text" rows="4"></input>
            @if ($errors->has('title'))
            <div>
              {{ $errors->first('title')}}
            </div>
          @endif
          </div>
          <div class="App-overview">
            
            <textarea class="Post-box__content-text" name="content" placeholder="内容" required autocomplete="text" rows="4"></textarea>
            @if ($errors->has('title'))
            <div>
              {{ $errors->first('content')}}
            </div>
            @endif
          </div>
        </div>

          <div class="">
              <div class="Flex">
                  <a href="{{ route('post')}}" type="submit" class="Btn-gradient--red">
                      キャンセル
                  </a>
                  <button type="submit" class="Btn-gradient">
                      投稿する
                  </button>
              </div>
          </div>
      </form>
    </div>
</div>

</x-app-layout>

@endsection
