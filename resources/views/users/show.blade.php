@extends('layouts.master')

@section('content')
    <div class="single-post">
        <h3>{{ $user->name }}</h3>
        <p>
            <a href="{{ route('postsuser', ['user' => $user->id]) }}">Posts : {{count($user->posts)}}</a> |
            <a href="{{ route('commentsuser', ['user' => $user->id]) }}">Comments : {{count($user->comments)}}</a>
        </p>
    </div>
@endsection
