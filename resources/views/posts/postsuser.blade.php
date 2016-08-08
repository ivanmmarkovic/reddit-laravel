@extends('layouts.master')

@section('content')

    @foreach($posts as $post)
    <div class="single-post">
        <a href="{{ $post->link }}"><h3>{{ $post->title }}</h3></a>
        <p>
            Submitted by <a href="{{ route('profile', ['user' => $post->user->id]) }}" >{{$post->user->name}}</a> |
            <a href="{{ route('post', ['post' => $post->id]) }}">{{ count($post->comments) }} comments</a> 
            @if(Auth::user() == $post->user)
                | <a href="{{ route('postdelete', ['post' => $post->id]) }}">delete post</a>
            @endif
        </p>
        @if (Auth::user())
            @if(Auth::user() != $post->user)
            <div class="votes-area" data-postid="{{ $post->id }}" data-userid="{{ Auth::user()->id }}">
                <span class="vote" data-votetype="up">{{ $post->votes_up }}</span>
                <span>{{ $post->result }}</span>
                <span class="vote" data-votetype="down">{{ $post->votes_down }}</span>
            </div>
            @endif
        @else
            <div class="votes-area">
                <span onclick="alert('Only registered users can vote');">{{ $post->votes_up }}</span>
                <span onclick="alert('Only registered users can vote');">{{ $post->result }}</span>
                <span onclick="alert('Only registered users can vote');">{{ $post->votes_down }}</span>
            </div>
        @endif
    </div>
    @endforeach
    <script>
        var token = "{{ Session::token() }}";
        var url = "{{ route('vote') }}";
    </script>
@endsection
