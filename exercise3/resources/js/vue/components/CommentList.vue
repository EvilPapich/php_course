<template>
  <div
      class="comment-list"
      :style="{
        borderLeft: deep ? '1px solid #ccc' : undefined,
        transform: !([0,1].includes(deep)) ? 'translate(20px, 0)' : undefined,
      }"
  >
    <CommentItem
        v-for="(comment) in levelComments"
        :key="comment.id"
        :comment="comment"
        :refered="calcReferedComments(comment.id)"
        :original="originalComments"
        :deep="deep"
        :likeAction="rateAction.likeAction"
        :dislikeAction="rateAction.dislikeAction"
        :editAction="editAction"
        :deleteAction="deleteAction"
        :refAction="refAction"
    />
  </div>
</template>

<script>
  import * as _ from "lodash";

  export default {
    name: "CommentList",
    components: {
      CommentItem: () => import("./CommentItem")
    },
    props: {
      comments: Array,
      original: {
        default: () => ([]),
        type: Array,
      },
      deep: {
        default: 0,
        type: Number
      },
      rateAction: {
        default: () => ({}),
        type: Object,
      },
      editAction: Function,
      deleteAction: Function,
      refAction: Function,
    },
    computed: {
      levelComments() {
        return this.deep ? this.comments : this.comments.filter((item) => !item.pivot.reference_id);
      },
      originalComments() {
        return this.original.length ? this.original : _.cloneDeep(this.comments);
      }
    },
    methods: {
      calcReferedComments(commentId) {
        return this.originalComments.filter((item) => item.pivot.reference_id === commentId);
      },
    }
  }
</script>

<style scoped>
  .comment-list {
    margin-bottom: 5px;
  }
</style>