@extends('layouts/head')
@push('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endpush

<!-- ヘッダー -->
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          詳細画面
      </h2>
  </x-slot>

  <!-- 記事の詳細内容 -->
  <div class="Flex">
    <div class="Post-box">
      <h2 class="Post-box__title">{{ $post -> title}}</h2>
      <div class="Profile-box">
        <div class="Profile-box__content">
          <img class="Profile-img" src="{{ $post -> user ->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                  <p>{{ $post -> user -> name}}</p>
        </div>
        <div>
                  <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
                  <a class="js-like-toggle" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="far fa-heart heart-none"></i></a>
                  <span class="likesCount">{{ count($post->favorites) }}</span>
        </div>
      </div>
      <p class="Post-box__content">{{ $post -> content}}</p>
      @if ($post->user->id === Auth::user()->id)
      <div class="Btn-wrraper">
        <form method="POST" action="{{ route('delete', $post->id) }}">
          @csrf
          <button type="submit">
            削除
          </button>
        </form>
          <a  href="/posts/edit/{{ $post->id }}">
            <p>編集</p>
          </a>
      </div>
      @endif
    </div>
  </div>


  <!-- コメントの一覧 -->
  <h1 class="Heading">COMMENT</h1>
  @forelse($post->comments as $comment)
  <div class="Comment">
    <div class="Profile-box">
      <div class="Profile-box__content">
        <img class="Profile-img" src="{{ $comment -> user ->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
        <div>
          <p>{{ $comment -> user -> name}}</p>
          <p>{{ $comment->created_at->format('Y-m-d H:i') }}</p>
        </div>
      </div>
    </div>
    <div class="Comment__text">
      <p>{{ $comment -> text}}</p>
    </div>
    @if ($comment->user->id === Auth::user()->id)
    <div class="Btn-wrraper">
      <a href="#">
        <p>削除</p>
      </a>
      <a href="#">
        <p>編集</p>
      </a>
    </div>
    @endif
  </div>

  @empty
  <div class="Empty-message">
    <p>コメントはまだありません</p>
  </div>
  @endforelse

  <!-- コメントの投稿 -->
  <div class="Comment-post">
    <form method="POST" action="{{ route('comment-store') }}">
      @csrf
      <div class="Comment-post__content">
        <img src="{{ $user ->profile_photo_url }}" class="Profile-img" width="50" height="50">
        <p class="">{{ $user->name }}</p>
      </div>
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      <textarea class="Comment-post__textarea" name="text" required autocomplete="text" placeholder="コメント">{{ old('text') }}</textarea>
      <div class="Comment-submit">
        <button type="submit" class="Btn">
          コメントする
        </button>
      </div>
    </form>
  </div>
</x-app-layout>