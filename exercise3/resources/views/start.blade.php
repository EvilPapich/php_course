<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/start.css') }}" rel="stylesheet">
</head>
<body>
<div class="flex-center position-ref full-height">
  <div class="content">
    <div class="title m-b-md">
      Добро пожаловать
    </div>

    <div class="links">
      <a class="start-enter h2" href="/login">войти</a>
    </div>
  </div>
</div>
</body>
</html>
