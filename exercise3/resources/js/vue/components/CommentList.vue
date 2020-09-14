<template>
  <div class="comment-list">
    <CommentItem
        v-for="(comment) in comments"
        :key="comment.id"
        :comment="comment"
        :likeAction="rateAction.likeAction"
        :dislikeAction="rateAction.dislikeAction"
        :editAction="editAction"
        :deleteAction="deleteAction"
        :refAction="refAction"
    />
  </div>
</template>

<script>
  import CommentItem from "./CommentItem";
  export default {
    name: "CommentList",
    components: {CommentItem},
    props: {
      comments: Array,
      rateAction: {
        default: () => ({}),
        type: Object,
      },
      editAction: Function,
      deleteAction: Function,
      refAction: Function,
    }
  }
</script>

<style scoped>
  .comment-list {

  }
</style>