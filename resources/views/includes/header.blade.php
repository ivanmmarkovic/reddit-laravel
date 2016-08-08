
<header>
    <a href="{{ route('welcome') }}">Home</a>
    @if(!Auth::user())
        <a href="{{ route('userscreate') }}">Sign up</a>
        <a href="{{ route('signin') }}">Sign in</a>
    @endif
    @if(Auth::user())
        <a href="{{ route('profile', ['user' => Auth::user()->id]) }}">Profile</a>
        <a href="{{ route('logout') }}">Logout</a>
        <a href="{{ route('postscreate') }}">Create post</a>
    @else
    <a href="#" onclick="alert('Only registered users can create posts')">Create post</a>
    @endif
</header>

@if(count($errors) > 0 || Session::has('message'))
    <div class="content-info">
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        @endif

        @if(Session::has('message'))
            <p>{{ Session::get('message') }}</p>
        @endif
    </div>
@endif
