@extends('layouts/head')
@push('css')
    <link href="{{ mix('css/index.css') }}" rel="stylesheet">
@endpush

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          投稿一覧
      </h2>
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

