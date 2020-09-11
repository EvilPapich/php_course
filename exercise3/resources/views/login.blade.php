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
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<div id="app">
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="title m-b-md">
        Вход
      </div>

      <div class="login-form">
        <input
          class="h3"
          name="login"
          placeholder="логин"
          type="login"
          v-model="login"
        />
        <input
          class="h3"
          name="password"
          placeholder="пароль"
          type="password"
          v-model="password"
        />
        <button
          class="h2"
          name="submit"
          type="submit"
          v-on:click="loginHandler"
        >
          Войти
        </button>
      </div>
    </div>
  </div>
</div>
<script>
  var app = new Vue({
    el: "#app",
    data: {
      data: {},
      login: "",
      password: "",
    },
    methods: {
      loginHandler() {
        fetch('api/user/login', {
          method: 'POST',
          body: JSON.stringify({
            login: this.login,
            password: this.password
          })
        }).then((res) => {
          if (res.status === 200) {
            return res.json();
          } else {
            throw new Error(res.statusText);
          }
        }).then((res) => {
          if (res.result) {
            localStorage.setItem('userId', res.userId);
            window.location = '/home';
          } else {
            alert('Неверные данные');
          }
        }).catch((err) => {
          alert(err.message);
        });
      },
    },
    mounted() {
      const userId = localStorage.getItem('userId');
      if (userId) {
        window.location = '/home';
      }
    },
  });
</script>
</body>
</html>
