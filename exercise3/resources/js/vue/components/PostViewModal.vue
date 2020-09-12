<template>
  <div class="post-view">
    <div class="post-view-header">
      <CloseButton
          :symbol="'x'"
          :action="closePostView"
      />
    </div>
    <div class="post-view-content" :style="{flex: 1}">
      <PostItem
          v-if="Object.keys(post).length"
          :post="post"
          :needOverflowText="false"
          :likeAction="likeAction"
          :dislikeAction="dislikeAction"
          :styles="{
            postItem: {flex: 1},
            postItemText: {flex: 1},
            hover: false,
          }"
      />
      <div v-else>
        <em>Такой публикации не существует</em>
      </div>
    </div>
  </div>
</template>

<script>
  import CloseButton from "./CloseButton";
  import PostItem from "./PostItem";
  export default {
    name: "PostViewModal",
    components: {PostItem, CloseButton},
    props: {
      post: Object,
      closePostView: Function,
      likeAction: Function,
      dislikeAction: Function,
    }
  }
</script>

<style scoped>
  .post-view {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: calc(100% - (15px*2) - (50px*2));
    max-width: 600px;
    background: white;
    border-radius: 2px;
    padding: 15px 20px;
  }
  .post-view-header {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    margin-bottom: 20px;
  }
  .post-view-content {
    display: flex;
    flex-direction: column;
  }
</style>