@extends('layouts/head')
@push('css')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
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
                <i class="far fa-comment fa-fw"></i>
                <p class="mb-0 text-secondary">{{ count($post->comments) }}</p>
                @if(!in_array($user->id,array_column($post->favorites->toArray(), 'user_id')))
                    <form method="POST" action="{{ route('favorite-store') }}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit"><i class="far fa-heart fa-fw"></i></button>
                    </form>
                @else
                    <form method="POST" action="{{ route('favorite-delete', ['id' => $post->id]) }}">
                        @csrf
                        
                        <input type="hidden" name="favorite_id" value="{{ $post-> favorites}}">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit"><i class="fas fa-heart fa-fw"></i></button>
                    </form>
                @endif
                <p class="">{{ count($post->favorites) }}</p>
            </div>
        </div>
    
    @endforeach
    
    </div>
    

</x-app-layout>

