@extends('layouts/head')
@push('css')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endpush
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      新規投稿画面
    </h2>
  </x-slot>

<div class="Wrapper">
  <div class="Wrapper__title">CREATE</div>
    <div class="Post-box">
      <form method="POST" action="{{ route('store')}}" >
        @csrf
        <div class="Post-box__user">
          <img class="Post-box__img" src="{{ $user ->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
          <p class="Post-box__user-name">{{ $user->name }}</p>
        </div>
        <div class="Post-box__content">
          <input type="text" class="Post-box__content-title" name="title" placeholder="アプリ名" required autocomplete="text" rows="4"></input>
          @if ($errors->has('title'))
          <div>
            {{ $errors->first('title')}}
          </div>
          @endif
          <textarea class="Post-box__content-text" name="content" placeholder="内容" required autocomplete="text" rows="4"></textarea>
          @if ($errors->has('title'))
          <div>
            {{ $errors->first('content')}}
          </div>
          @endif
          <p class="">140文字以内</p>
        </div>

          <div class="">
              <div class="Flex">
                  <a href="{{ route('post')}}" type="submit" class="Btn">
                      キャンセル
                  </a>
                  <button type="submit" class="Btn">
                      投稿する
                  </button>
              </div>
          </div>
      </form>
    </div>
</div>

</x-app-layout>
