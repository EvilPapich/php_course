<template>
  <div class="comment-item">
    <div class="comment-item-content">
      <div
          v-if="!isEdit"
          ref="messageDiv"
          class="comment-item-message"
      >
        {{comment.message}}
      </div>
      <label
          v-else
          class="comment-item-message-input"
      >
        <textarea
            :placeholder="comment.message"
            v-model="message"
            :rows="textareaRows"
        ></textarea>
      </label>
      <EditButton
          v-if="!isEdit"
          :color="'#ccc'"
          :hoverColor="'#4C7DFF'"
          :style="{marginLeft: '10px'}"
          :action="clickToEdit"
      />
      <div
          v-else
          class="comment-item-editor-controls"
      >
        <DoneButton
            :color="'#ccc'"
            :hoverColor="'#4CAF50'"
            :style="{marginLeft: '10px'}"
            :action="clickEditDone"
        />
      </div>
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
  import EditButton from "./EditButton";
  import DoneButton from "./DoneButton";
  export default {
    name: "CommentItem",
    components: {DoneButton, EditButton, RatingBar},
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
      editAction: {
        default: ()=>{},
        type: Function,
      },
    },
    data() {
      return {
        message: this.comment.message,
        isEdit: false,
        textareaRows: 1,
      };
    },
    methods: {
      clickToEdit() {
        this.isEdit = true;
        const el = this.$refs.messageDiv;
        this.textareaRows = Math.ceil(el.offsetHeight / 22);
      },
      clickEditDone() {
        this.editAction(this.comment, this.message);
        this.isEdit = false;
      },
    },
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
  .comment-item-content {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-right: 5px;
    margin-bottom: 5px;
  }
  .comment-item-message {
  }
  .comment-item-message-input {
    display: flex;
    flex: 1;
  }
  .comment-item-message-input > textarea {
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
    display: flex;
    flex: 1;
    padding: 0;
    color: #636b6f;
    background: white;
    border-radius: 2px;
    border: none;
    outline: none;
    resize: none;
  }
  .comment-item-message-input > textarea::placeholder {
    color: #ccc;
    font-style: italic;
  }
  .comment-item-editor-controls {
    display: flex;
    flex-direction: column;
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