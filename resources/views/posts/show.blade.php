@extends('layouts/master')
@push('css')
    <link href="{{ mix('css/post/show.css') }}" rel="stylesheet">
@endpush
<!-- ヘッダー -->

@section('content')

<x-app-layout>
  
  <x-slot name="header">
    <nav class="Menu">
      <h2 class="Menu__item--bold">
          投稿詳細
      </h2>
      @if($my_introduction)
      <a href="{{ route('create') }}"  class="Menu__item">
          新規投稿
      </a>
      @else
      <a href="#" id="introduction_pop" class="Menu__item">
          新規投稿(プロフィール登録必須)
      </a>
      @endif
      <a href="{{ route('post') }}" class="Menu__item">
          投稿一覧
      </a>
      <a href="/introductions/{{ $user->id }}" class="Menu__item">
          マイページ
      </a>
    </nav>
  </x-slot>

  <!-- プロフィール登録モーダル -->
  <div class="Profile-modal" id="js-modal">
    <div class="Profile-modal__bg" id="js-modal-close"></div>
    <div class="Profile-modal__content">
      <p class="Profile-modal__content-title">簡単なプロフィールの登録が必要です！！</p>
      <div class="Profile-modal__content-btn-box" >
        <a id="js-modal-close" class="Profile-modal__content-back Btn-gradient--red" href="">閉じる</a>
        <a href="/introductions/create" class="Profile-modal__content-register Btn-gradient">プロフィール登録へ</a>
      </div>
    </div>
  </div>

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
      </div>
      <h2 class="Post-box__title">{{ $post -> title}}</h2>

      <div class="Profile-box">
        <div class="Profile-box__content">
          <!-- ここ修正 -->
          @if($post ->introduction->profile_image_path)
          <img class="Profile-img" src="{{ $post -> introduction -> profile_image_path }}"  alt="{{ Auth::user()->name }}" />
          @else
          <p class="Profile-img-none">画像がありません</p>
          @endif
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
      @if ($post->user->id === Auth::user()->id)
        <div class="Btn-wrraper">
          <a  href="/posts/edit/{{ $post->id }}" class="Btn-gradient">
            <p>この記事を編集</p>
          </a>
          <form method="POST" action="{{ route('delete', $post->id) }}">
            @csrf
            <button type="submit" class="Btn-gradient--red">
              この記事を削除
            </button>
          </form>
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
          <!-- プロフィール登録されていてかつ画像がない場合も記述必要 -->
          @if($my_introduction)
            @if($my_introduction->profile_image_path)
            <img src="{{ $comment -> introduction -> profile_image_path }}"  class="Profile-img" width="50" height="50">
            @else
            <p class="Profile-img-none">画像がありません</p>
            @endif
          @else
          <p class="Profile-img-none">画像がありません</p>
          @endif
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
            <button type="submit" id="commentDeleteBtn"   data-comment_id="{{ $comment->id }}">
            <i class="fas fa-trash"></i>
              削除する
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
  @if($my_introduction)
  <div class="Comment-post">
    <form method="POST" action="{{ route('ajaxComment') }}">
      @csrf
      <div class="Comment-post__content">
        @if($my_introduction)
          @if($my_introduction->profile_image_path)
          <img src="{{ $my_introduction -> profile_image_path }}"  class="Profile-img" width="50" height="50">
          @else
          <p class="Profile-img-none">画像がありません</p>
          @endif
        @else
        <p class="Profile-img-none">画像がありません</p>
        @endif
        <p class="">{{ $user->name }}</p>
      </div>
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      <textarea class="Comment-post__textarea" id="Comment-post__textarea" name="text" required autocomplete="text" placeholder="コメント">{{ old('text') }}</textarea>
      <div class="Comment-submit">
        <button type="submit" class="simple_square_btn" data-post_id="{{ $post->id }}">
        <i class="fas fa-comments"></i>
          コメントする
        </button>
      </div>
    </form>
  </div>
  @endif
</x-app-layout>

@endsection

