@extends('layouts.master')

@section('content')
    <div class="single-post">
        <a href="{{ $post->link }}"><h3>{{ $post->title }}</h3></a>
        <p>
            Submitted by <a href="{{ route('profile', ['user' => $post->user->id]) }}" >{{$post->user->name}}</a> 
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
    @if(Auth::user())
    <div class="form-container">
        <h2>Create comment</h2>
        <form method="post" action="{{ route('commentsstore', ['post' => $post->id]) }}">
            {{ csrf_field() }}
            <textarea placeholder="Comment" name="comment"></textarea>
            <input type="submit" value="Create comment" />
        </form>
    </div>
    @endif
    <div class="comments-box">
        <h3>Comments {{ count($post->comments) }}</h3>
            @foreach($post->comments as $comment)
            <div class="single-comment">
                <p>
                    <a href="{{ route('profile', ['user' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                    {{ $comment->comment }}<br />
                    @if(Auth::user() && Auth::user() == $comment->user)
                        <a href="{{ route('commentdelete', ['comment' => $comment->id]) }}">delete</a>
                    @endif
                </p>
            </div>
            @endforeach
    </div>
    
    <script>
        var token = "{{ Session::token() }}";
        var url = "{{ route('vote') }}";
    </script>
@endsection
