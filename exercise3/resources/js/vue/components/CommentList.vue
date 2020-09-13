<template>
  <div class="comment-list">
    <CommentItem
        v-for="(comment, index) in comments"
        :key="index"
        :comment="comment"
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
    }
  }
</script>

<style scoped>
  .comment-list {

  }
</style>