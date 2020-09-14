<template>
<fragment>
  <div class="comment-item-wrapper">
    <div
        class="comment-item"
        :style="{
          ...styles.commentItem,
          ...{transform: deep ? 'translate(20px, 0)' : undefined}
        }"
    >
      <div class="comment-item-content">
        <div
            v-if="!isEdit"
            ref="messageDiv"
            class="comment-item-message"
        >{{comment.message}}</div>
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
        <div
            v-if="!isEdit"
            class="comment-item-controls"
        >
          <IconButton
              :color="'#ccc'"
              :hoverColor="'#4C7DFF'"
              :style="{marginLeft: '10px'}"
              :action="clickToEdit"
          >
            <template slot-scope="props">
              <EditIcon :color="props.color"/>
            </template>
          </IconButton>
          <IconButton
              :color="'#ccc'"
              :hoverColor="'#4C7DFF'"
              :style="{marginLeft: '10px'}"
              :action="() => refAction(comment)"
          >
            <template slot-scope="props">
              <ReferIcon :color="props.color"/>
            </template>
          </IconButton>
        </div>
        <div
            v-else
            class="comment-item-editor-controls"
        >
          <IconButton
              :color="'#ccc'"
              :hoverColor="'#4CAF50'"
              :style="{marginLeft: '10px'}"
              :action="clickEditDone"
          >
            <template slot-scope="props">
              <DoneIcon :color="props.color"/>
            </template>
          </IconButton>
          <IconButton
              :color="'#ccc'"
              :hoverColor="'#F94B46'"
              :style="{marginLeft: '10px'}"
              :action="clickToDelete"
          >
            <template slot-scope="props">
              <TrashIcon :color="props.color"/>
            </template>
          </IconButton>
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
  </div>
  <CommentList
    v-if="refered.length"
    :comments="refered"
    :original="original"
    :deep="deep+1"
    :rateAction="{
      likeAction: likeAction,
      dislikeAction: dislikeAction,
    }"
    :editAction="editAction"
    :deleteAction="deleteAction"
    :refAction="refAction"
  />
</fragment>
</template>

<script>
  import RatingBar from "./RatingBar";
  import IconButton from "./IconButton";
  import EditIcon from "../icons/EditIcon";
  import DoneIcon from "../icons/DoneIcon";
  import TrashIcon from "../icons/TrashIcon";
  import ReferIcon from "../icons/ReferIcon";
  export default {
    name: "CommentItem",
    components: {
      ReferIcon, TrashIcon, DoneIcon, EditIcon, IconButton, RatingBar,
      CommentList: () => import("./CommentList"),
    },
    props: {
      comment: Object,
      refered: {
        default: () => ([]),
        type: Array,
      },
      original: {
        default: () => ([]),
        type: Array,
      },
      deep: {
        default: 0,
        type: Number
      },
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
      deleteAction: {
        default: ()=>{},
        type: Function,
      },
      refAction: {
        default: ()=>{},
        type: Function,
      },
      styles: {
        default: () => ({}),
        type: Object
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
      clickToDelete() {
        this.deleteAction(this.comment);
        this.isEdit = false;
      },
    },
  }
</script>

<style scoped>
  .comment-item-wrapper {
    display: flex;
    flex-direction: row;
  }
  .comment-item {
    display: flex;
    flex-direction: column;
    flex: 1;
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
    white-space: pre-wrap;
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
  .comment-item-controls {
    display: flex;
    flex-direction: column;
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