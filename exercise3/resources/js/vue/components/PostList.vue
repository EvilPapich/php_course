<template>
  <div class="posts-list">
    <PostItem
        v-for="(post, postIndex) in posts"
        :key="postIndex"
        :post="post"
        :needOverflowText="needOverflowText"
        :action="() => action(post)"
        :likeAction="rateAction.likeAction"
        :dislikeAction="rateAction.dislikeAction"
        :tagAction="tagAction"
    />
  </div>
</template>

<script>
  import LikeIcon from "../icons/LikeIcon";
  import LikeCounter from "./LikeCounter";
  import overflowText from "../utils/overflowText";
  import PostItem from "./PostItem";
  export default {
    name: "PostList",
    components: {PostItem, LikeCounter, LikeIcon},
    props: {
      posts: Array,
      needOverflowText: Boolean,
      action: Function,
      rateAction: {
        default: () => ({}),
        type: Object,
      },
      tagAction: Function,
    },
    methods: {
      overflowText,
    }
  }
</script>

<style scoped>
  .posts-list {

  }
</style>