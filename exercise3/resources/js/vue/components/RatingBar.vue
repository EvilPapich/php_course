<template>
  <div class="rating-bar">
    <LikeCounter
        v-if="likes !== undefined"
        :count="likes"
        :color="likes ? '#4CAF50' : '#ccc'"
        :hoverColor="'#4C7DFF'"
        :orientation="'top'"
        :action="() => likeAction(1)"
    />
    <LikeCounter
        v-if="dislikes !== undefined"
        :count="dislikes"
        :color="dislikes ? '#F94B46' : '#ccc'"
        :hoverColor="'#4C7DFF'"
        :orientation="'bottom'"
        :action="() => dislikeAction(0)"
    />
  </div>
</template>

<script>
  import LikeCounter from "./LikeCounter";
  export default {
    name: "RatingBar",
    components: {LikeCounter},
    props: {
      likes: Number,
      likeAction: {
        default: ()=>{},
        type: Function,
      },
      dislikes: Number,
      dislikeAction: {
        default: ()=>{},
        type: Function,
      },
    }
  }
</script>

<style scoped>
  .rating-bar {
    display: flex;
    flex-direction: row;
  }
</style>