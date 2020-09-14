<template>
  <div class="comment-item">
    <div class="comment-item-message">
      {{comment.message}}
    </div>
    <div class="comment-item-footer">
      <div class="comment-info">
        <div class="comment-item-updated-at">
          {{comment.updated_at}}
        </div>
        <div>
          {{comment.author[0].lname}} {{comment.author[0].fname}}
        </div>
      </div>
      <RatingBar
          :likes="comment.likes"
          :likeAction="(value) => likeAction(comment, value)"
          :dislikes="comment.dislikes"
          :dislikeAction="(value) => dislikeAction(comment, value)"
      />
    </div>
  </div>
</template>

<script>
  import RatingBar from "./RatingBar";
  export default {
    name: "CommentItem",
    components: {RatingBar},
    props: {
      comment: Object,
      likeAction: {
        default: ()=>{},
        type: Function,
      },
      dislikeAction: {
        default: ()=>{},
        type: Function,
      },
    }
  }
</script>

<style scoped>
  .comment-item {
    display: flex;
    flex-direction: column;
    padding: 15px 20px;
    background: #f9f9f9;
    border-radius: 2px;
    margin-bottom: 5px;
  }
  .comment-item-footer {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
  }
  .comment-info {
    display: flex;
    flex-direction: row;
    margin-right: 15px;
  }
  .comment-item-updated-at {
    color: #ccc;
    margin-right: 15px;
  }
</style>