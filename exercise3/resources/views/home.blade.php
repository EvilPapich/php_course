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
  <div
    class="full-height"
    :style="{overflow: (showDraftEditor || showDraftList) ? 'hidden' : 'unset'}"
  >
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
          <div class="home-write-post" v-on:click="showDraftEditor = true">
            <div class="circle-icon add-icon">+</div>
            <div class="write-post-btn">Написать пост</div>
          </div>
          <div class="home-drafts" v-on:click="showDraftList = true">
            <div class="circle-icon drafts-count">
              ${ isFetchingDrafts ? null : drafts.length }
            </div>
            <div class="drafts-btn">Ваши черновики</div>
          </div>
          <div class="home-posts-list">
            <div>Посты за последние 7 дней:</div>
            <div
              v-for="(post, postIndex) in posts"
              :key="postIndex"
              class="post-item"
            >
              <div class="post-item-header">
                <div class="post-item-title">
                  ${ post.title }
                </div>
                <div class="post-item-rating">

                </div>
              </div>
              <div class="post-item-text">
                ${ post.text }
              </div>
              <div class="post-item-footer">
                <div class="post-tags-list">
                  <div
                    v-for="(tag, tagIndex) in post.tags"
                    :key="tagIndex"
                    class="tag-item"
                  >
                    ${ tag.name }
                  </div>
                </div>
                <div class="post-info">
                  <div class="post-item-created-at">
                    ${ post.created_at }
                  </div>
                  <div class="post-item-author">
                    ${ post.author.lname } ${ post.author.fname }
                  </div>
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
  <div v-show="showDraftEditor" class="draft-editor-wrapper">
    <div class="draft-editor">
      <div class="draft-editor-header">
        <div class="circle-icon close-icon" v-on:click="showDraftEditor = false">x</div>
      </div>
      <div class="draft-editor-content">
        <label>
          <input
            name="title"
            type="text"
            v-model="draft.title"
            placeholder="Заголовок (обязательно)"
          />
        </label>
        <label>
          <textarea
            class="draft-editor-textarea"
            name="text"
            v-model="draft.text"
            placeholder="Текст (обязательно)"
            rows="5"
          ></textarea>
        </label>
        <label>
          <input
            name="tags"
            type="text"
            v-model="draft.tags"
            placeholder="Введите теги через запятую (не обязательно)"
          />
        </label>
      </div>
      <div class="draft-editor-footer">
        <div class="draft-editor-save-draft-btn"
             v-on:click="writeDraft"
        >
          Сохранить как черновик
        </div>
        <div class="draft-editor-save-post-btn"
             v-on:click="writePost"
        >
          Опубликовать
        </div>
      </div>
    </div>
  </div>
  <div v-show="showDraftList" class="draft-list-wrapper">
    <div class="draft-list">
      <div class="draft-list-header">
        <div class="circle-icon close-icon" v-on:click="showDraftList = false">x</div>
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
      showDraftEditor: false,
      draft: {},
      isFetchingDrafts: true,
      showDraftList: false,
      drafts: [],
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
      preparePostTags(tags="") {
        return tags.split(",").map(item => item.trim()).filter(item => item);
      },
      writeDraft() {
        fetch('api/post/write/draft', {
          method: 'POST',
          headers: {
            [userIdHeader]: this.user.id
          },
          body: JSON.stringify({
            title: this.draft.title,
            text: this.draft.text,
            tags: this.preparePostTags(this.draft.tags),
          })
        }).then((res) => {
          if (res.status === 200) {
            this.showDraftEditor = false;
            this.draft = {};
            this.getDrafts().then((drafts) => {
              this.drafts = drafts;
              this.isFetchingDrafts = false;
            });
          } else {
            throw new Error(res.statusText);
          }
        }).catch((err) => {
          alert(err.message);
        });
      },
      writePost() {
        fetch('api/post/write/post', {
          method: 'POST',
          headers: {
            [userIdHeader]: this.user.id
          },
          body: JSON.stringify({
            title: this.draft.title,
            text: this.draft.text,
            tags: this.preparePostTags(this.draft.tags),
          })
        }).then((res) => {
          if (res.status === 200) {
            this.showDraftEditor = false;
            this.draft = {};
            this.getRecentPosts().then((posts) => {
              this.posts = posts;
              this.isFetchingPosts = false;
            });
          } else {
            throw new Error(res.statusText);
          }
        }).catch((err) => {
          alert(err.message);
        });
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
      },
      getDrafts() {
        return fetch('api/post/get/drafts', {
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
      },
    },
    mounted() {
      const userId = localStorage.getItem('userId');

      this.fetchAuthor(userId).then((author) => {
        this.author = author;
        this.user = author.user;
      }).then(() => {
        this.getDrafts().then((drafts) => {
          this.drafts = drafts;
          this.isFetchingDrafts = false;
        });

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
