<template>
  <div class="draft-editor">
    <div class="draft-editor-header">
      <CloseButton
          :symbol="'x'"
          :action="closeHandler"
      />
    </div>
    <div class="draft-editor-content">
      <label>
        <input
            name="title"
            type="text"
            v-model="draft.title"
            placeholder="Заголовок (обязательно)"
        />
      </label>
      <label>
            <textarea
                class="draft-editor-textarea"
                name="text"
                v-model="draft.text"
                placeholder="Текст (обязательно)"
                rows="5"
            ></textarea>
      </label>
      <label>
        <input
            name="tags"
            type="text"
            v-model="draft.tags"
            placeholder="Введите теги через запятую (не обязательно)"
        />
      </label>
    </div>
    <div class="draft-editor-footer">
      <div class="draft-editor-btn-wrapper">
        <div
            v-for="(button, index) in actionButtons"
            :key="index"
            class="draft-editor-btn"
            :style="{backgroundColor: button.backgroundColor}"
            v-on:click="button.action"
        >
          {{ button.title }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import CloseButton from "./CloseButton";
  export default {
    name: "DraftEditorModal",
    components: {CloseButton},
    props: {
      draft: Object,
      closeHandler: Function,
      actionButtons: {
        default: function () { return [] },
        type: Array,
      },
    }
  }
</script>

<style scoped>
  .draft-editor {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 600px;
    background: white;
    border-radius: 2px;
    padding: 15px 20px;
  }
  .draft-editor-header {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    margin-bottom: 20px;
  }
  .draft-editor-content {
    display: flex;
    flex-direction: column;
    margin: 0 50px;
  }
  .draft-editor-content label {
    display: flex;
  }
  .draft-editor-content input[name="title"],
  .draft-editor-content input[name="tags"],
  .draft-editor-textarea {
    font-family: 'Nunito', sans-serif;
    display: flex;
    flex: 1;
    margin-bottom: 20px;
    padding: 10px;
    background: #f9f9f9;
    color: #636b6f;
    border: none;
    border-radius: 2px;
    outline: none;
  }
  .draft-editor-content input[name="title"] {
    font-weight: 600;
  }
  .draft-editor-textarea {
    resize: none;
  }
  .draft-editor-content input[name="tags"],
  .draft-editor-textarea {
    font-weight: 400;
  }
  .draft-editor-footer {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    margin-top: 20px;
  }
  .draft-editor-btn-wrapper {
    display: flex;
    flex-direction: row;
  }
  .draft-editor-btn {
    padding: 5px 10px;
    margin-left: 20px;
    background: transparent;
    border-radius: 2px;
    color: white;
    font-weight: unset;
    display: flex;
    align-self: center;
    cursor: pointer;
    border: none;
    outline: none;
  }
</style>