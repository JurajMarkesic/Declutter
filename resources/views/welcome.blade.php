<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Declutter') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body id="landingBody">
    <div id="app">
        @include('partials.nav')
    </div>

    <h1 id="landingHeader">See what people <span class="font-weight-bold">can</span> live without and share your story.</h1>

    <form action="/search" method="get" class=" row form form-inline" id="bigSearchForm">
        <div>
            <input name="query" id="bigSearchInput" placeholder="Search for an item">
        </div>
        <button id="bigSearchButton" class="btn btn-dark" type="submit">SEARCH</button>
    </form>


    <!-- Scripts -->
<script>
    window.Laravel = <?php echo json_encode([   //globally available csrf token
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
