<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <fragment>
    <div
        class="full-height"
        :style="{overflow: fixedScroll ? 'hidden' : 'unset'}"
    >
      <div class="home-view">
        <div class="home-header">
          <div class="home-header-title">
            <div class="h3">Главная</div>
          </div>
          <div class="home-header-info">
            <div class="profile-info" v-show="Object.keys(author).length">
              author: <span>{{ author.lname }} {{ author.fname }}</span>
            </div>
            <div class="user-info" v-show="Object.keys(user).length">
              login: <span>{{ user.name }}</span>
              email: <span>{{ user.email }}</span>
            </div>
            <div
                class="home-header-exit h3"
                v-on:click="exitHandler"
            >Выход</div>
          </div>
        </div>
        <div class="home-content">
          <div class="home-content-wrapper">
            <WideButton :action="clickNewPost">
              <template v-slot:icon="">
                <CircleIcon
                    :symbol="'+'"
                    :style="{backgroundColor: '#4CAF50', marginRight: '10px'}"
                />
              </template>
              <template v-slot:title="">
                Написать пост
              </template>
            </WideButton>
            <WideButton :action="openDraftList">
              <template v-slot:icon="">
                <CircleIcon
                    :symbol="isFetchingDrafts ? null : drafts.length"
                    :style="{backgroundColor: '#90CAF9', marginRight: '10px', fontSize: '12px'}"
                />
              </template>
              <template v-slot:title="">
                Ваши черновики
              </template>
            </WideButton>
            <div class="home-posts-list">
              <div class="home-posts-list-controls-wrapper">
                <div class="home-posts-list-filters-wrapper">
                  <div>Сортировка:</div>
                  <div
                      v-for="(order, key, index) in orders"
                      :key="index"
                      :class="['sort', {'sort-asc': order.count === 1, 'sort-desc': order.count === 2}]"
                      v-on:click="() => postOrderChange(key)"
                  >{{order.title}}</div>
                </div>
                <div
                    class="home-posts-list-refresh"
                    v-on:click="refreshPostList"
                >
                  <RefreshIcon :color="'#636b6f'"/>
                </div>
              </div>
              <div v-if="tags.length" class="home-tags-navigator">
                <div
                    v-for="(tag, index) in tags"
                    :key="index"
                    class="navigator-tag-item"
                    v-on:click="() => clickTagNavigatorItem(tag)"
                >
                  {{tag.name}}
                  <span>x</span>
                </div>
              </div>
              <div>Посты за последние 7 дней:</div>
              <PostList
                  v-if="!isFetchingPosts"
                  :posts="posts"
                  :needOverflowText="true"
                  :action="(item) => openPostView(item)"
                  :rateAction="{
                    likeAction: (item, value) => ratePost(item.id, value),
                    dislikeAction: (item, value) => ratePost(item.id, value),
                  }"
                  :tagAction="(item) => clickTag(item)"
              />
              <div v-else class="post-list-loading">
                <em>Загрузка...</em>
              </div>
              <div v-if="!isFetchingPosts && !posts.length" class="post-list-empty-text">
                <em>Отсутствуют</em>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalLayout v-if="showDraftEditor">
      <DraftEditorModal
          :draft="draft"
          :closeHandler="closeDraftEditor"
          :actionButtons="{
            'new': [
              {
                title: 'Сохранить как черновик',
                backgroundColor: '#90CAF9',
                action: writeDraft,
              },
              {
                title: 'Опубликовать',
                backgroundColor: '#81C784',
                action: writePost,
              }
            ],
            'edit': [
              {
                title: 'Удалить черновик',
                backgroundColor: '#f94b46',
                action: deleteDraft,
              },
              {
                title: 'Обновить черновик',
                backgroundColor: '#90CAF9',
                action: editDraft,
              },
              {
                title: 'Опубликовать черновик',
                backgroundColor: '#81C784',
                action: publishDraft,
              }
            ]
          }[editor.mode ? editor.mode : 'new']"
      />
    </ModalLayout>
    <ModalLayout v-if="showDraftList">
      <DraftListModal
          :drafts="drafts"
          :isFetchingDrafts="isFetchingDrafts"
          :closeDraftList="closeDraftList"
          :draftClick="(item) => clickDraft(item)"
      />
    </ModalLayout>
    <ModalLayout v-if="showPostView">
      <PostViewModal
          :post="post"
          :closePostView="closePostView"
          :ratePostAction="{
            likeAction: (item, value) => ratePost(item.id, value),
            dislikeAction: (item, value) => ratePost(item.id, value),
          }"
          :commentWriteAction="(postId, message, commentId) => writeComment(postId, message, commentId)"
          :rateCommentAction="{
            likeAction: (item, value) => rateComment(item.id, value),
            dislikeAction: (item, value) => rateComment(item.id, value),
          }"
          :editCommentAction="(item, value) => editComment(item.id, value)"
          :deleteCommentAction="(item) => deleteComment(item.id)"
      />
    </ModalLayout>
  </fragment>
</template>

<script>
  import Fragment from 'vue-fragment';
  import Vue from "vue";
  import ModalLayout from "../layouts/ModalLayout";
  import DraftEditorModal from "../components/DraftEditorModal";
  import CircleIcon from "../components/CircleIcon";
  import PostList from "../components/PostList";
  import WideButton from "../components/WideButton";
  import DraftListModal from "../components/DraftListModal";
  import PostViewModal from "../components/PostViewModal";
  import RefreshIcon from "../icons/RefreshIcon";
  import * as _ from "lodash";
  Vue.use(Fragment.Plugin);

  const userIdHeader = 'x-user-id';

  export default {
    name: "Home",
    components: {
      RefreshIcon,
      PostViewModal,
      DraftListModal,
      WideButton,
      PostList,
      CircleIcon,
      DraftEditorModal,
      ModalLayout
    },
    data: function() {
      return {
        user: {},
        author: {},
        showDraftEditor: false,
        draft: {},
        editor: {},
        isFetchingDrafts: true,
        showDraftList: false,
        drafts: [],
        isFetchingPosts: true,
        posts: [],
        viewedPostId: undefined,
        showPostView: false,
        orders: {
          "updated_at": {
            title: "по дате",
            count: 2,
          },
          "likes": {
            title: "по рейтингу",
            count: 0,
          },
        },
        tags: [],
        filters:[],
      };
    },
    computed: {
      fixedScroll() {
        return (
          this.showDraftEditor
          || this.showDraftList
          || this.showPostView
        );
      },
      post() {
        const post = this.posts.find(item => item.id === this.viewedPostId);

        return post ? post : {};
      },
    },
    methods: {
      exitHandler() {
        localStorage.clear();
        window.location = '/';
      },
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
      clickNewPost() {
        this.editor.mode = "new";
        this.openDraftEditor();
      },
      openDraftEditor(callback=()=>{}) {
        this.showDraftEditor = true;
        this.editor.callback = callback;
      },
      closeDraftEditor() {
        this.showDraftEditor = false;
        this.draft = {};
        this.editor.mode = undefined;
        this.editor.callback();
      },
      openDraftList() {
        this.showDraftList = true;
      },
      clickDraft(draft) {
        this.draft = {
          ...draft,
          tags: draft.tags.map(item => item.name).join(", ")
        };
        this.showDraftList = false;
        this.editor.mode = "edit";
        this.openDraftEditor(() => {
          this.showDraftList = true;
          this.editor.mode = undefined;
        });
      },
      closeDraftList() {
        this.showDraftList = false;
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
        /*
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
        */
        return fetch('api/post/get/posts/recent', {
          method: 'POST',
          headers: {
            [userIdHeader]: this.user.id
          },
          body: JSON.stringify({
            filters: this.filters,
            orders: Object.entries(this.orders).reduce((result, [key, value]) => {
              const orderDict = {
                0: undefined,
                1: 'asc',
                2: 'desc',
              };

              result[key] = orderDict[value.count];

              return result;
            },{}),
            tags: this.tags.map(item => item.id),
          })
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
      editDraft() {
        fetch("api/post/edit/draft", {
          method: "POST",
          headers: {
            [userIdHeader]: this.user.id,
          },
          body: JSON.stringify({
            postId: this.draft.id,
            title: this.draft.title,
            text: this.draft.text,
            tags: this.preparePostTags(this.draft.tags),
          }),
        }).then((res) => {
          if (res.status === 200) {
            this.closeDraftEditor();
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
      publishDraft() {
        fetch("api/post/publish/draft", {
          method: "POST",
          headers: {
            [userIdHeader]: this.user.id,
          },
          body: JSON.stringify({
            postId: this.draft.id,
            title: this.draft.title,
            text: this.draft.text,
            tags: this.preparePostTags(this.draft.tags),
          }),
        }).then((res) => {
          if (res.status === 200) {
            this.closeDraftEditor();
            this.getDrafts().then((drafts) => {
              this.drafts = drafts;
              this.isFetchingDrafts = false;
            });
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
      deleteDraft() {
        fetch("api/post/delete/draft", {
          method: "POST",
          headers: {
            [userIdHeader]: this.user.id,
          },
          body: JSON.stringify({
            postId: this.draft.id,
          }),
        }).then((res) => {
          if (res.status === 200) {
            this.closeDraftEditor();
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
      openPostView(post) {
        this.showPostView = true;
        this.viewedPostId = post.id;
      },
      closePostView() {
        this.showPostView = false;
        this.viewedPostId = undefined;
      },
      ratePost(postId, value) {
        fetch("api/post/rate/post", {
          method: "POST",
          headers: {
            [userIdHeader]: this.user.id,
          },
          body: JSON.stringify({
            postId: postId,
            value: value,
          }),
        }).then((res) => {
          if (res.status === 200) {
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
      postOrderChange(key) {
        this.orders[key].count = {
          0: 1,
          1: 2,
          2: 0,
        }[this.orders[key].count];
      },
      refreshPostList() {
        this.isFetchingPosts = true;
        this.getRecentPosts().then((posts) => {
          this.posts = posts;
          this.isFetchingPosts = false;
        });
      },
      clickTag(tag) {
        this.tags.push(tag);
        this.tags = _.uniqBy(this.tags, "id");
      },
      clickTagNavigatorItem(tag) {
        this.tags = this.tags.filter(item => item.id !== tag.id);
      },
      writeComment(postId, message, refId) {
        fetch("api/post/write/post/comment", {
          method: "POST",
          headers: {
            [userIdHeader]: this.user.id,
          },
          body: JSON.stringify({
            postId: postId,
            referenceId: refId,
            message: message,
          }),
        }).then((res) => {
          if (res.status === 200) {
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
      rateComment(commentId, value) {
        fetch("api/post/rate/post/comment", {
          method: "POST",
          headers: {
            [userIdHeader]: this.user.id,
          },
          body: JSON.stringify({
            commentId: commentId,
            value: value,
          }),
        }).then((res) => {
          if (res.status === 200) {
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
      editComment(commentId, message) {
      },
      deleteComment(commentId) {
      }
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
  };
</script>

<style scoped>
  .home-view {
    display: flex;
    flex-direction: column;
  }

  .home-header {
    display: flex;
    flex-direction: row;
    padding: 20px;
    background: #f9f9f9;
  }
  .home-header-title {
    display: flex;
  }
  .home-header-info {
    display: flex;
    flex: 1;
    justify-content: flex-end;
    align-items: center;
  }
  .profile-info,
  .user-info {
    margin-right: 20px;
    font-size: 13px;
  }
  .profile-info span,
  .user-info span {
    font-weight: 600;
  }
  .home-header-exit {
    cursor: pointer;
  }
  .home-header-exit:hover {
    color: #4c7dff;
  }

  .home-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    align-items: center;
    padding: 50px 0;
  }
  .home-content-wrapper {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 600px;
  }

  .home-posts-list {
    margin-top: 5px;
    padding: 0 40px;
  }
  .post-list-empty-text {
    margin-top: 20px;
    color: #ccc;
  }
  .post-list-loading {
    margin-top: 20px;
  }

  .home-posts-list-controls-wrapper {
    display: flex;
    flex-direction: row;
    margin-bottom: 15px;
  }

  .home-posts-list-filters-wrapper {
    display: flex;
    flex: 1;
    flex-direction: row;
    justify-content: space-between;
    padding: 15px 20px;
    margin-right: 10px;
    background: #f9f9f9;
    border-radius: 2px;
  }
  .home-posts-list-filters-wrapper > .sort {
    user-select: none;
    cursor: pointer;
  }
  .home-posts-list-filters-wrapper > .sort::after {
    content: '';
    font-size: 12px;
    margin-left: 17px;
  }
  .home-posts-list-filters-wrapper > .sort-asc::after {
    content: '▲';
    font-size: 12px;
    margin-left: 5px;
  }
  .home-posts-list-filters-wrapper > .sort-desc::after {
    content: '▼';
    font-size: 12px;
    margin-left: 5px;
  }
  .home-posts-list-filters-wrapper > .sort:hover {
    color: #4c7dff;
  }
  .home-posts-list-refresh {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 52px;
    height: 52px;
    background: #f9f9f9;
    border-radius: 2px;
    cursor: pointer;
  }
  .home-posts-list-refresh:hover {
    background: #cad9ff;
  }

  .home-tags-navigator {
    display: flex;
    flex-direction: row;
    padding: 15px 20px;
    margin-bottom: 15px;
    background: #f9f9f9;
    border-radius: 2px;
  }
  .navigator-tag-item {
    display: flex;
    align-self: flex-start;
    padding: 2px 8px;
    border-radius: 24px;
    background: #eee;
    font-size: 12px;
    margin-left: 10px;
    cursor: pointer;
  }
  .navigator-tag-item:hover {
    background: #4c7dff;
  }
  .navigator-tag-item > span {
    margin-left: 5px;
  }
  .navigator-tag-item:hover > span {
    color: white;
  }
</style>