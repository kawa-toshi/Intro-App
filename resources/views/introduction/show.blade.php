@extends('layouts/master')
@push('css')
    <link href="{{ mix('css/introduction/introduction_show.css') }}" rel="stylesheet">
@endpush

@section('content')

<x-app-layout>

  <x-slot name="header">
    <nav class="Menu">
      <h1 class="Menu__item--bold">
          マイページ
      </h1>
      <a href="{{ route('post') }}" class="Menu__item">
          投稿一覧
      </a>
      <a href="{{ route('create') }}" class="Menu__item">
          新規投稿
      </a>
      <a href="/introductions/{{ $user->id }}" class="Menu__item">
          マイページ
      </a>
      
      @unless($introduction_user)
      <a href="/introductions/create" class="Menu__item">
          プロフィール登録
      </a>
      @else
        @if($follow_show)
          <a href="/introductions/edit/{{ $user->id }}" class="Menu__item">
            プロフィール編集
          </a>
        @endif
      @endunless
    </nav>
  </x-slot>
  @if($my_introduction)
    @if($profile_cover_photo_url)
    <div class="Cover-image-area">
      <img src="{{ $profile_cover_photo_url }}" class="Cover-image-area__content">
    </div>
    <!-- プロフィール登録なしの場合 -->
    @else
    <div class="Cover-image-area">
      <p>カバー画像が登録されていません</p>
    </div>
    @endif
  @else
  <div class="Cover-image-area">
    <p>カバー画像が登録されていません</p>
  </div>
  @endif

  <div class="Profile-area">
  @if($my_introduction)
    @if($profile_photo_url)
      <img class="Profile-area__left" src="{{ $profile_photo_url }}" alt="{{ Auth::user()->name }}" />
    @else
      <p class="Profile-area__left-none">画像がありません</p>
    @endif
  @else
    <p class="Profile-area__left-none">画像がありません</p>
  @endif
    <div class="Profile-area__right">
    <!-- フォローされていますのメッセージ まず自分のマイページかどうか判定-->
    @if(!$follow_show)
      @if($is_followed)
      <p class="Profile-area__right-followed">このユーザーにフォローされています</p>
      @endif
    @endif
      <div class="User">
        <!-- ここを修正 -->
        @if($follow_show)
        <p class="User__name">{{ $user -> name}}</p>
        @else
        <p class="User__name">{{ $your_user -> name}}</p>
        @endif
        <!-- ここからフォロー関連 -->
        <!-- 自分のページだけは表示させないようにしたい -->
        @if(!$follow_show)
        @if($is_following)
          <form action="{{ route('unfollow')}}" method="POST">
              @csrf
              {{ method_field('DELETE') }}
              <input type="hidden" name="follower_id" value="{{ $follower_id }}">
              <button type="submit" class="User__follow-btn-none"><i class="fas fa-user-plus"></i>フォロー解除</button>
          </form>
        @else
          <form action="{{ route('follow')}}" method="POST">
              @csrf
              <input type="hidden" name="follower_id" value="{{ $follower_id }}">

              <button type="submit" class="User__follow-btn"><i class="fas fa-user-plus"></i>フォロー</button>
          </form>
        @endif
        @endif
        <!-- <button class="User__follow-btn"><i class="fas fa-user-plus"></i>フォロー</button> -->
      </div>
      <div class="User-detail">
        @if($my_introduction)
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
      <!-- 自分自身のマイページかどうかでフォロー数フォロワー数場合わけ -->
      @if($follow_show)
        <p class="User-follow__follow"><span>{{ $my_following_count }}</span>フォロー</p>
        <p class="User-follow__follower"><span>{{ $my_followed_count }}</span>フォロワー</p>
      @else
        <p class="User-follow__follow"><span>{{ $your_following_count }}</span>フォロー</p>
        <p class="User-follow__follower"><span>{{ $your_followed_count }}</span>フォロワー</p>
      @endif
      </div>
    </div>
  </div>

  <h2 class="Heading">{{ $user -> name}}の投稿一覧</h2>

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
          @if($post->introduction->profile_image_path)
          <img class="Profile-box__content-profile-image" src="{{ $post -> introduction -> profile_image_path }}" alt="{{ Auth::user()->name }}" />
          @else
          <p class="Profile-box__content-profile-image-none">画像が登録されていません</p>
          @endif
          <p class="Profile-box__content-username">{{ $post -> user -> name}}</p>
        </div>

        <div class="Profile-box__day">
        <p>投稿日時</p>
        <p>{{ $post->created_at->format('Y-m-d H:i') }}</p>
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

  </div>
</x-app-layout>

@endsection

