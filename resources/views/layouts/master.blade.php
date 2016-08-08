<!DOCTYPE html>
<html>
    <head>
        <title>Laravel - reddit clone</title>
        <link rel="stylesheet" href="{{ URL::to('/src/css/normalize.css') }}" />
        <link rel="stylesheet" href="{{ URL::to('/src/css/styles.css') }}" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0">
    </head>
    <body>
        <div id="container">
                @include('includes.header')
            <div class="content">
                @yield('content')
            </div>
        </div>
        <script src="{{ URL::to('/src/js/script.js') }}"></script>
    </body>
</html>
