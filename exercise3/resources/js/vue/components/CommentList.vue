<template>
  <div class="comment-list">
    <CommentItem
        v-for="(comment, index) in comments"
        :key="index"
        :comment="comment"
        :likeAction="rateAction.likeAction"
        :dislikeAction="rateAction.dislikeAction"
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
    }
  }
</script>

<style scoped>
  .comment-list {

  }
</style>