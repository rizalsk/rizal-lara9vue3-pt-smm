<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 ">
    <meta name="api-base-url" content="{{ url('api/v1') }}" />
    <title>VUE APP LOGISTIC</title>

    @vite([ 'resources/css/app.css'])
    @vite([ 'resources/sass/app.scss'])
    <script>
        window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data ?? null)) }}'));
    </script>
</head>

<body>
    <div id="app"></div>
    
    @vite([ 'resources/js/app.js'])
</body>

</html>