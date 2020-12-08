@extends('layouts/master')
@push('css')
    <link href="{{ asset('css/post/create.css') }}" rel="stylesheet">
@endpush

@section('content')
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      新規投稿画面
    </h2>
  </x-slot>


<div class="Wrapper">
  <div class="Wrapper__title">EDIT</div>
    <div class="Post-box">
      <form method="POST" action="{{ route('update')}}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $post->id }}">
        <div class="Post-box__user">
        @if($profile_image_path)
          <img class="Post-box__img" src="{{ $profile_image_path }}" alt="{{ Auth::user()->name }}" />
          @else
          <p class="Post-box__img-none">画像がありません</p>
          @endif
          <p class="Post-box__user-name">{{ $user->name }}</p>
        </div>

        <div id="PreviewArea">
          @if($post -> image_path)
          <img src="{{ $post->image_path }}" id="PreviewArea__previous">
          @endif
        </div>
        <div class="Post-box__top">
          <label for="Post-image" class="Image-field">トップ画像を投稿できます
            <input type="file" name="image_path"  id="Post-image">
          </label>
        </div>

        <div class="Post-box__content">
        <div class="App-name">
            <input type="text" class="Post-box__content-title" value="{{ $post->title}}" name="title" placeholder="アプリ名" required autocomplete="text" rows="4"></input>
            @if ($errors->has('title'))
            <div>
              {{ $errors->first('title')}}
            </div>
          @endif
          </div>
          
          <div class="App-overview">
            <textarea class="Post-box__content-text" name="content" placeholder="アプリの概要">{{ $post->content}}</textarea>
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
                      編集する
                  </button>
              </div>
          </div>
      </form>
    </div>
</div>

</x-app-layout>

@endsection
