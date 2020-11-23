
@extends('layouts/master')

@push('css')
    <link href="{{ mix('css/post/index.css') }}" rel="stylesheet">
@endpush


@section('content')

<x-app-layout>

  <x-slot name="header">
    <div class="Flex">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          投稿一覧
      </h2>
      <a href="{{ route('post') }}">
          投稿一覧
      </a>
      <a href="{{ route('create') }}">
          新規投稿
          (まずはプロフィール登録！！ホップアップウィンドウ出す！！)
      </a>
      <a href="/introductions/{{ $user->id }}">
          マイページ
      </a>
      </div>
  </x-slot>

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
          <a href="/introductions/{{ $post->user->id }}">
          <img class="h-8 w-8 rounded-full object-cover" src="{{ $post -> user ->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
          <p>{{ $post -> user -> name}}</p>
          <p>{{ $post -> introductions}}</p>
          </a>
        </div>
        <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
        <div class="Profile-box__comment">
          <!-- コメントアイコンとコメント数 -->
            <a href="/posts/{{ $post->id }}" class="">
              <i class="far fa-comment fa-fw"></i>
            </a>
            <a href="/posts/{{ $post->id }}" class="">
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
@endsection

