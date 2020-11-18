@extends('layouts/head')
@push('css')
    <link href="{{ mix('css/introduction/introduction_show.css') }}" rel="stylesheet">
@endpush


<x-app-layout>

  <x-slot name="header">
    <nav class="Menu">
      <h1 class="font-semibold text-xl text-gray-800 leading-tight">
          マイページ
      </h1>
      <a href="{{ route('post') }}">
          投稿一覧
      </a>
      <a href="{{ route('create') }}">
          新規投稿
      </a>
      <a href="/introductions/{{ $user->id }}">
          マイページ
      </a>
      @unless($introduction_user)
      <a href="/introductions/create">
          プロフィール登録
      </a>
      @else
      <a href="/introductions/create">
          プロフィール編集
      </a>
      @endunless
    </nav>
  </x-slot>

  @if($introduction_user)
  <div class="Cover-image-area">
    <img src="{{ $profile_cover_photo_url }}" class="Cover-image-area__content">
  </div>
  <!-- プロフィール登録なしの場合 -->
  @else
  <div class="Cover-image-area">
    <p>画像が登録されていません</p>
  </div>
  @endif

  <div class="Profile-area">
  @if($introduction_user)
    <img class="Profile-area__left" src="{{ $profile_photo_url }}" alt="{{ Auth::user()->name }}" />
  @else
    <p>画像がありません</p>
  @endif
    <div class="Profile-area__right">
      <div class="User">
        <p class="User__name">{{ $user -> name}}</p>
        <button class="User__follow-btn"><i class="fas fa-user-plus"></i>フォロー</button>
      </div>
      <div class="User-detail">
        @if($user->introduction)
        <p class="User-detail__content">
        {{ $profile_message }}
        </p>
        @else
        <p class="User-detail__content">
        プロフィールの詳細が登録されていません
        </p>
        @endif
      </div>
      <div class="User-follow">
        <p class="User-follow__follow">87フォロー</p>
        <p class="User-follow__follower">100フォロワー</p>
      </div>
    </div>
  </div>

  <h2 class="Heading">{{ $user -> name}}の投稿一覧</h2>

  <div class="Flex">
  @foreach($posts as $post)

    <div class="Post-box">
      <div class="Post-box__image">
          <img src="{{ $post->image_path }}" class="Post-box__image-content">
      </div>
      <a href="/posts/{{ $post->id }}">
        <h2 class="Post-box__title">{{ $post -> title}}</h2>
      </a>
      <p class="Post-box__content">{{ $post -> content}}</p>
      <div class="Profile-box">
        <div class="Profile-box__content">
          <img class="h-8 w-8 rounded-full object-cover" src="{{ $post -> user ->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
          <p>{{ $post -> user -> name}}</p>
        </div>
        <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
        <div>
          <!-- コメントアイコンとコメント数 -->
          <a href="/posts/{{ $post->id }}">
            <i class="far fa-comment fa-fw"></i>
            <p class="mb-0 text-secondary">{{ count($post->comments) }}</p>
          </a>
        </div>

        <!-- いいねのajax処理 -->
        <div class="LikeBox">
        @if (in_array($user->id, array_column($post->favorites->toArray(), 'user_id'), TRUE))
          <a class="js-like-toggle loved" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="fas fa-heart"></i></a>
          <span class="likesCount">{{ count($post->favorites) }}</span>
        @else
          <a class="js-like-toggle" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="fas fa-heart"></i></a>
          <span class="likesCount">{{ count($post->favorites) }}</span>
        @endif
        </div>

      </div>
    </div>
  @endforeach

  </div>
</x-app-layout>

