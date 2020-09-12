<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div class="draft-list">
    <div class="draft-list-header">
      <CloseButton
          :symbol="'x'"
          :action="closeDraftList"
      />
    </div>
    <WideButton>
      <template v-slot:icon="">
        <CircleIcon
            :symbol="isFetchingDrafts ? null : drafts.length"
            :style="{backgroundColor: '#90CAF9', marginRight: '10px', fontSize: '12px'}"
        />
      </template>
      <template v-slot:title="">
        Ваши черновики
      </template>
    </WideButton>
    <div class="draft-list-scroller">
      <PostList
          :posts="drafts"
          :needOverflowText="true"
          :action="draftClick"
      />
    </div>
  </div>
</template>

<script>
  import CloseButton from "./CloseButton";
  import WideButton from "./WideButton";
  import CircleIcon from "./CircleIcon";
  import PostList from "./PostList";
  export default {
    name: "DraftListModal",
    components: {PostList, CircleIcon, WideButton, CloseButton},
    props: {
      drafts: Array,
      isFetchingDrafts: Boolean,
      closeDraftList: Function,
      draftClick: Function,
    }
  }
</script>

<style scoped>
  .draft-list {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: calc(100% - (15px*2) - (50px*2));
    max-width: 600px;
    background: white;
    border-radius: 2px;
    padding: 15px 20px;
  }
  .draft-list-header {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    margin-bottom: 20px;
  }
  .draft-list-scroller {
    overflow-y: auto;
    max-width: 600px;
    padding: 0 40px;
    margin-top: 5px;
  }
</style>