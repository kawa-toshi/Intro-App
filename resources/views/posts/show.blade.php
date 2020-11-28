@extends('layouts/master')
@push('css')
    <link href="{{ mix('css/post/show.css') }}" rel="stylesheet">
@endpush
<!-- ヘッダー -->

@section('content')

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          詳細画面
      </h2>
  </x-slot>

  <!-- 記事の詳細内容 -->
  <div class="Flex">
    <div class="Post-box">
      @if($post->image_path)
      <img src="{{ $post->image_path }}" class="Post-box__image-content">
      @else
      <p class="Post-box__image-content-none">画像が登録されていません</p>
      @endif
      <div class="Post-box__title-box">
        <h2 class="Post-box__heading">アプリ名</h2>
        @if ($post->user->id === Auth::user()->id)
        <div class="Btn-wrraper">
          <form method="POST" action="{{ route('delete', $post->id) }}">
            @csrf
            <button type="submit" class="Btn-gradient--red">
              この記事を削除
            </button>
          </form>
          <a  href="/posts/edit/{{ $post->id }}" class="Btn-gradient">
            <p>この記事を編集</p>
          </a>
        </div>
        @endif
      </div>
      <h2 class="Post-box__title">{{ $post -> title}}</h2>

      <div class="Profile-box">
        <div class="Profile-box__content">
          <img class="Profile-img" src="{{ $post -> introduction -> profile_image_path }}"  alt="{{ Auth::user()->name }}" />
          <p>{{ $post -> user -> name}}</p>
        </div>
        <div>
          <!-- 投稿日時 -->
          <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
          <!-- ajax いいね -->
          @if (in_array($user->id, array_column($post->favorites->toArray(), 'user_id'), TRUE))
            <a class="js-like-toggle loved" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="fas fa-heart"></i></a>
            <span class="likesCount">{{ count($post->favorites) }}</span>
          @else
            <a class="js-like-toggle" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="fas fa-heart"></i></a>
            <span class="likesCount">{{ count($post->favorites) }}</span>
          @endif
        </div>
      </div>
      <h2 class="Post-box__heading">アプリの概要</h2>
      <p class="Post-box__content">{{ $post -> content}}</p>
      <!-- @if ($post->user->id === Auth::user()->id)
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
      @endif -->
    </div>
  </div>


  <!-- コメントの一覧 -->
  <h1 class="Heading">COMMENT</h1>
    @forelse($post->comments as $comment)
    <div class="Comment">
      <div class="Profile-box">
        <div class="Profile-box__content">
          <img class="Profile-img" src="{{ $post -> introduction -> profile_image_path }}"  alt="{{ Auth::user()->name }}" />
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
        <form method="DELETE" action="{{ route('ajaxCommentDelete') }}">
        @csrf
            <button type="submit" id="commentDeleteBtn" data-comment_id="{{ $comment->id }}">
              削除
            </button>
        </form>
      </div>
      @endif
    </div>

  @empty
  <div class="Empty-message">
    <p>コメントはまだありません</p>
  </div>
  @endforelse

  <div id="Add-empty">
  </div>

  <div id="Add-comment">
  </div>

  <!-- コメントの投稿 -->
  <div class="Comment-post">
    <form method="POST" action="{{ route('ajaxComment') }}">
      @csrf
      <div class="Comment-post__content">
        <img src="{{ $post -> introduction -> profile_image_path }}"  class="Profile-img" width="50" height="50">
        <p class="">{{ $user->name }}</p>
      </div>
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      <textarea class="Comment-post__textarea" id="Comment-post__textarea" name="text" required autocomplete="text" placeholder="コメント">{{ old('text') }}</textarea>
      <div class="Comment-submit">
        <button type="submit" class="Comment-submit__btn" data-post_id="{{ $post->id }}">
          コメントする
        </button>
      </div>
    </form>
  </div>
</x-app-layout>

@endsection

