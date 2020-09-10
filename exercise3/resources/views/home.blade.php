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
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<div id="app">
  <div class="full-height">
    <div class="home-view">
      <div class="home-header">
        <div class="home-header-title">
          <div class="h3">Главная</div>
        </div>
        <div class="home-header-info">
          <div class="profile-info">
            Антонов Андрей
          </div>
          <div
            class="home-header-exit h3"
            v-on:click="exitHandler"
          >Выход</div>
        </div>
      </div>
      <div class="home-content">

      </div>
    </div>
  </div>
</div>
<script>
  var app = new Vue({
    el: "#app",
    data: {
      data: {},
    },
    methods: {
      exitHandler() {
        localStorage.clear();
        window.location = '/';
      }
    },
    mounted() {

    },
  });
</script>
</body>
</html>
