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
            ${ author.lname } ${ author.fname }
          </div>
          <div class="user-info">
            ${ user.name } ${ user.email }
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
    delimiters: ['${', '}'],
    el: "#app",
    data: {
      user: {},
      author: {},
    },
    methods: {
      exitHandler() {
        localStorage.clear();
        window.location = '/';
      }
    },
    mounted() {
      const userId = localStorage.getItem('userId');

      fetch('api/user/get', {
        method: 'GET',
        headers: {
          'x-user-id': userId,
        },
      }).then((res) => {
        if (res.status === 200) {
          return res.json();
        } else {
          throw new Error(res.statusText);
        }
      }).then((res) => {
        this.user = res;
      }).catch((err) => {
        alert(err.message);
      });

      fetch('api/author/get', {
        method: 'GET',
        headers: {
          'x-user-id': userId,
        },
      }).then((res) => {
        if (res.status === 200) {
          return res.json();
        } else {
          throw new Error(res.statusText);
        }
      }).then((res) => {
        this.author = res;
      }).catch((err) => {
        alert(err.message);
      });
    },
  });
</script>
</body>
</html>
