<template>
  <div class="posts-list">
    <div
        v-for="(post, postIndex) in posts"
        :key="postIndex"
        class="post-item"
        v-on:click="action(post)"
    >
      <div class="post-item-header">
        <div class="post-item-title">
          {{ post.title }}
        </div>
        <div class="post-item-rating">
          <LikeCounter
              v-if="post.likes !== undefined"
              :count="post.likes"
              :color="post.likes ? '#4CAF50' : '#ccc'"
              :hoverColor="'#4C7DFF'"
              :orientation="'top'"
          />
          <LikeCounter
              v-if="post.dislikes !== undefined"
              :count="post.dislikes"
              :color="post.dislikes ? '#F94B46' : '#ccc'"
              :hoverColor="'#4C7DFF'"
              :orientation="'bottom'"
          />
        </div>
      </div>
      <div class="post-item-text">
        {{ post.text }}
      </div>
      <div class="post-item-footer">
        <div class="post-tags-list">
          <div
              v-for="(tag, tagIndex) in post.tags"
              :key="tagIndex"
              class="tag-item"
          >
            {{ tag.name }}
          </div>
        </div>
        <div class="post-info">
          <div class="post-item-status">
            <em>{{ post.status.name }}</em>
          </div>
          <div class="post-item-updated-at">
            {{ post.updated_at }}
          </div>
          <div class="post-item-author">
            {{ post.author.lname }} {{ post.author.fname }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import LikeIcon from "../icons/LikeIcon";
  import LikeCounter from "./LikeCounter";
  export default {
    name: "PostList",
    components: {LikeCounter, LikeIcon},
    props: {
      posts: Array,
      action: {
        default: ()=>{},
        type: Function,
      }
    }
  }
</script>

<style scoped>
  .posts-list {

  }
  .post-item {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
    background: #f9f9f9;
    border-radius: 2px;
    padding: 15px 20px;
  }
  .post-item:hover {
    background: #cad9ff;
    cursor: pointer;
  }
  .post-item-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-bottom: 15px;
  }
  .post-item-title {
    font-weight: 600;
  }
  .post-item-rating {
    display: flex;
    flex-direction: row;
  }
  .post-item-text {
    margin-bottom: 15px;
  }
  .post-item-footer {
    display: flex;
    flex-direction: column;
  }
  .post-info,
  .post-tags-list
  {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
  }
  .post-tags-list {
    margin-bottom: 5px;
  }
  .tag-item {
    display: flex;
    align-self: flex-start;
    padding: 2px 8px;
    border-radius: 24px;
    background: #eee;
    font-size: 12px;
    margin-left: 10px;
  }
  .post-item:hover > .post-item-footer > .post-tags-list > .tag-item {
    background: #eeeeee5c;
  }
  .post-item-status {
    margin-right: 15px;
  }
  .post-item-updated-at {
    color: #ccc;
    margin-right: 15px;
  }
  .post-item:hover > .post-item-footer > .post-info > .post-item-updated-at {
    color: #aaa;
  }
  .post-item-author {

  }
</style>