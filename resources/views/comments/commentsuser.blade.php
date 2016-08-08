@extends('layouts.master')

@section('content')

    <div class="comments-box">
        <h3>Comments</h3>
        @foreach($comments as $comment)
        <div class="single-comment">
            <p>
                <a href="{{ route('post', ['post' => $comment->post->id]) }}">{{ $comment->post->title }}</a>
                <a href="{{ route('profile', ['user' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                {{ $comment->comment }}<br />
                @if(Auth::user() && Auth::user() == $comment->user)
                <a href="{{ route('commentdelete', ['comment' => $comment->id]) }}">delete</a>
                @endif
            </p>
        </div>
        @endforeach
    </div>

@endsection
