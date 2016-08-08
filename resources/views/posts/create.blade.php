@extends('layouts.master')

@section('content')
    <div class="form-container">
        <h3>Create post</h3>
        <form method="post" action="{{ route('postsstore') }}">
            {{csrf_field()}}
            <input type="text" name="title" placeholder="Title"/><br />
            <input type="text" name="link" placeholder="Link"/><br />
            <textarea name="description" placeholder="Description"></textarea><br />
            <input type="submit" value="Create Post" />
        </form>
    </div>
@endsection
