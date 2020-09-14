<template>
  <div class="post-view">
    <div class="post-view-header">
      <CloseButton
          :symbol="'x'"
          :action="closePostView"
      />
    </div>
    <div class="post-view-content">
      <fragment v-if="Object.keys(post).length">
        <PostItem
            :post="post"
            :needOverflowText="false"
            :likeAction="ratePostAction.likeAction"
            :dislikeAction="ratePostAction.dislikeAction"
            :style="{marginBottom: '20px'}"
            :styles="{
              //postItem: {flex: 1},
              //postItemText: {flex: 1},
              hover: false,
            }"
        />
        <div class="post-view-write-comment-wrapper">
          <label>
            <textarea
                ref="messageTextarea"
                class="post-view-write-comment-textarea"
                placeholder="Оставить комментарий..."
                rows="2"
                v-model="message"
            ></textarea>
          </label>
          <div
              class="post-view-write-comment-submit"
              v-on:click="() => clickCommentSubmit(null)"
          >
            Отправить
          </div>
        </div>
        <div class="comment-list-scroller">
          <CommentItem
              :comment="post.popular_comment[0]"
              :likeAction="rateCommentAction.likeAction"
              :dislikeAction="rateCommentAction.dislikeAction"
              :editAction="editCommentAction"
              :deleteAction="deleteCommentAction"
              :style="{border: '1px solid #CAD9FF'}"
          />
          <CommentList
              :comments="post.comments"
              :rateAction="{
                likeAction: rateCommentAction.likeAction,
                dislikeAction: rateCommentAction.dislikeAction,
              }"
              :editAction="editCommentAction"
              :deleteAction="deleteCommentAction"
          />
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
  import CommentList from "./CommentList";
  import CommentItem from "./CommentItem";
  export default {
    name: "PostViewModal",
    components: {CommentItem, CommentList, PostItem, CloseButton},
    props: {
      post: Object,
      closePostView: Function,
      ratePostAction: Object,
      commentWriteAction: Function,
      rateCommentAction: Object,
      editCommentAction: Function,
      deleteCommentAction: Function,
    },
    data() {
      return {
        message: "",
      }
    },
    methods: {
      clickCommentSubmit(commentId) {
        this.commentWriteAction(this.post.id, this.message, commentId);
        this.message = "";
      }
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
    flex: 1;
    overflow: hidden;
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
  .post-view-write-comment-textarea {
    font-family: 'Nunito', sans-serif;
    display: flex;
    flex: 1;
    padding: 10px;
    background: #f9f9f9;
    color: #636b6f;
    border: none;
    border-radius: 2px;
    outline: none;
    resize: none;
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
  .comment-list-scroller {
    overflow-y: auto;
    max-width: 600px;
    padding: 0 0 0 40px;
  }
</style>