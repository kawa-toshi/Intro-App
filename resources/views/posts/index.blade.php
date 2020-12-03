
@extends('layouts/master')

@push('css')
    <link href="{{ mix('css/post/index.css') }}" rel="stylesheet">
@endpush


@section('content')

<x-app-layout>

  <x-slot name="header">
    <div class="Flex">
      <h2 class="">
          投稿一覧
      </h2>
      <a href="{{ route('post') }}" class="Flex__top-menu">
          投稿一覧
      </a>
      <!-- ここifに変える -->
      @if($my_introduction)
      <a href="{{ route('create') }}"  class="Flex__top-menu">
          新規投稿
      </a>
      @else
      <a href="#" id="introduction_pop" class="Flex__top-menu">
          新規投稿(この機能を利用するにはプロフィール登録が必要です)
      </a>
      @endif
      <a href="/introductions/{{ $user->id }}" class="Flex__top-menu">
          マイページ
      </a>
      </div>
  </x-slot>
  <!-- プロフィール登録のポップアップ -->
  <div class="Profile-modal" id="js-modal">
    <div class="Profile-modal__bg" id="js-modal-close"></div>
    <div class="Profile-modal__content">
      <p class="Profile-modal__content-title">新規投稿するには簡単なプロフィールの登録が必要です！！</p>
      <div class="Profile-modal__content-btn-box" >
        <a id="js-modal-close" class="Profile-modal__content-back Btn-gradient--red" href="">閉じる</a>
        <a href="/introductions/create" class="Profile-modal__content-register Btn-gradient">プロフィール登録へ</a>
      </div>
    </div>
  </div>

  <div class="Flex">
  @foreach($posts as $post)
  
    <div class="Post-box">
      <div class="Post-box__image">
          @if($post->image_path)
          <img src="{{ $post->image_path }}" class="Post-box__image-content">
          @else
          <p class="Post-box__image-content-none">画像が登録されていません</p>
          @endif
      </div>
      <a href="/posts/{{ $post->id }}">
        <h2 class="Post-box__title">{{ $post -> title}}</h2>
      </a>
      <p class="Post-box__content">{{ $post -> content}}</p>
      <div class="Profile-box">
        <div class="Profile-box__content">
          <a href="/introductions/{{ $post->user->id }}">
            @if($post->introduction->profile_image_path)
            <img class="Profile-box__content-profile-image" src="{{ $post -> introduction -> profile_image_path }}" alt="{{ Auth::user()->name }}" />
            @else
            <p class="Profile-box__content-profile-image-none">画像がありません</p>
            @endif
            <p class="Profile-box__content-username">{{ $post -> user -> name}}</p>
          </a>
        </div>

        <div class="Profile-box__day">
          <p>投稿日時</p>
          <p class="">{{ $post->created_at->format('Y-m-d H:i') }}</p>
        </div>
        
        <div class="Profile-box__comment">
          <!-- コメントアイコンとコメント数 -->
          <p>コメント</p>
          <div class="Comment-box">
          <a href="/posts/{{ $post->id }}" class="">
            <i class="far fa-comment fa-fw"></i>
          </a>
          <a href="/posts/{{ $post->id }}" class="">
            <p class="mb-0 tex">{{ count($post->comments) }}</p>
          </a>
          </div>
          
        </div>

        <!-- いいねのajax処理 -->
        <div class="LikeBox">
        @if (in_array($user->id, array_column($post->favorites->toArray(), 'user_id'), TRUE))
          <p class="LikeBox__title">お気に入り</p>
          <div class="LikeBox__content">
            <a class="js-like-toggle loved" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="fas fa-heart"></i></a>
            <span class="likesCount">{{ count($post->favorites) }}</span>
          </div>
        @else
          <p class="LikeBox__title">お気に入り</p>
          <div class="LikeBox__content">
            <a class="js-like-toggle" href="{{ route('ajaxlike') }}" data-post_id="{{ $post->id }}"><i class="fas fa-heart"></i></a>
            <span class="likesCount">{{ count($post->favorites) }}</span>
          </div>
        @endif
        </div>

      </div>
    </div>
   
  @endforeach

  <!-- ページネーション -->
  <div class="Pagination">
  {{ $posts->links() }}
  </div>


  </div>
</x-app-layout>
@endsection

