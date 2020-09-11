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
          <div class="profile-info" v-show="Object.keys(author).length">
            author: <span>${ author.lname } ${ author.fname }</span>
          </div>
          <div class="user-info" v-show="Object.keys(user).length">
            login: <span>${ user.name }</span>
            email: <span>${ user.email }</span>
          </div>
          <div
            class="home-header-exit h3"
            v-on:click="exitHandler"
          >Выход</div>
        </div>
      </div>
      <div class="home-content">
        <div class="home-content-wrapper">
          <div class="home-write-post">
            <div class="add-icon">+</div>
            <div class="write-post-btn" v-on:click="writeDraft">Написать пост</div>
          </div>
          <div class="home-posts-list">
            <div>Посты за последние 7 дней:</div>
            <div
              v-for="(item, index) in posts"
              key="index"
              class="post-item"
            >
              <div class="post-item-header">
                <div class="post-item-title">
                  ${ item.title }
                </div>
                <div class="post-item-rating">

                </div>
              </div>
              <div class="post-item-text">
                ${ item.text }
              </div>
              <div class="post-item-footer">
                <div class="post-item-created-at">
                  ${ item.created_at }
                </div>
                <div class="post-item-author">
                  ${ item.author.lname } ${ item.author.fname }
                </div>
              </div>
            </div>
            <div v-if="!isFetchingPosts && !posts.length" class="post-list-empty-text">
              <em>Отсутствуют</em>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const userIdHeader = 'x-user-id';

  const app = new Vue({
    delimiters: ['${', '}'],
    el: "#app",
    data: {
      user: {},
      author: {},
      draft: {title:"title",text:"text"},
      myDrafts: [],
      isFetchingPosts: true,
      posts: [],
    },
    methods: {
      exitHandler() {
        localStorage.clear();
        window.location = '/';
      },
      //unused
      fetchUser(userId) {
        return fetch('api/user/get', {
          method: 'GET',
          headers: {
            [userIdHeader]: userId,
          },
        }).then((res) => {
          if (res.status === 200) {
            return res.json();
          } else {
            throw new Error(res.statusText);
          }
        }).catch((err) => {
          alert(err.message);
        });
      },
      //
      fetchAuthor(userId) {
        return fetch('api/author/get', {
          method: 'GET',
          headers: {
            [userIdHeader]: userId,
          },
        }).then((res) => {
          if (res.status === 200) {
            return res.json();
          } else {
            throw new Error(res.statusText);
          }
        }).catch((err) => {
          alert(err.message);
        });
      },
      writeDraft() {
        fetch('api/post/write/draft', {
          method: 'POST',
          headers: {
            [userIdHeader]: this.user.id
          },
          body: JSON.stringify({
            authorId: this.author.id,
            title: this.draft.title,
            text: this.draft.text,
          })
        }).then(null);
      },
      getRecentPosts() {
        return fetch('api/post/get/posts/recent', {
          method: 'GET',
          headers: {
            [userIdHeader]: this.user.id
          }
        }).then((res) => {
          if (res.status === 200) {
            return res.json();
          } else {
            throw new Error(res.statusText);
          }
        }).catch((err) => {
          alert(err.message);
        });
      }
    },
    mounted() {
      const userId = localStorage.getItem('userId');

      this.fetchAuthor(userId).then((author) => {
        this.author = author;
        this.user = author.user;
      }).then(() => {
        this.getRecentPosts().then((posts) => {
          this.posts = posts;
          this.isFetchingPosts = false;
        });
      });
    },
  });
</script>
</body>
</html>
