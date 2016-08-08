@extends('layouts.master')

@section('content')
    <div class="form-container">
        <h2>Sign in</h2>
        <form method="post" action="{{ route('signinprocess') }}">
            {{ csrf_field() }}
            <input type="email" name="email" placeholder="Email"/>
            <input type="password" name="password" placeholder="Password"/>
            <input type="submit" value="Sign in" />
        </form>
@endsection