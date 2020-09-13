<template>
  <div class="post-view">
    <div class="post-view-header">
      <CloseButton
          :symbol="'x'"
          :action="closePostView"
      />
    </div>
    <div class="post-view-content" :style="{flex: 1}">
      <fragment v-if="Object.keys(post).length">
        <PostItem
            :post="post"
            :needOverflowText="false"
            :likeAction="likeAction"
            :dislikeAction="dislikeAction"
            :style="{marginBottom: '20px'}"
            :styles="{
              //postItem: {flex: 1},
              //postItemText: {flex: 1},
              hover: false,
            }"
        />
        <div class="post-view-write-comment-wrapper">
          <label>
            <input
                class="post-view-write-comment-input"
                type="text"
                placeholder="Оставить комментарий..."
            />
          </label>
          <div class="post-view-write-comment-submit">
            Отправить
          </div>
        </div>
      </fragment>
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

  .post-view-write-comment-wrapper {
    display: flex;
    flex-direction: row;
    padding: 15px 20px;
    background: #f9f9f9;
    border-radius: 2px;
    margin-bottom: 15px;
  }
  .post-view-write-comment-wrapper > label {
    display: flex;
    flex: 1;
  }
  .post-view-write-comment-input {
    font-family: 'Nunito', sans-serif;
    display: flex;
    flex: 1;
    padding: 10px;
    background: #f9f9f9;
    color: #636b6f;
    border: none;
    border-radius: 2px;
    outline: none;
  }
  .post-view-write-comment-submit {
    padding: 5px 10px;
    margin-left: 20px;
    border-radius: 2px;
    color: white;
    font-weight: unset;
    display: flex;
    align-self: center;
    cursor: pointer;
    border: none;
    outline: none;
    background: #90CAF9;
  }
</style>