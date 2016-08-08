@extends('layouts.master')

@section('content')

    <div class="form-container">
        <h2>Sign up</h2>
        <form method="post" action="{{ route('usersstore') }}">
            {{ csrf_field() }}
            <input type="text" name="name" placeholder="Name"/><br />
            <input type="email" name="email" placeholder="Email"/><br />
            <input type="password" name="password" placeholder="Password"/><br />
            <input type="submit" value="Sign up" />
        </form>
    </div>
@endsection