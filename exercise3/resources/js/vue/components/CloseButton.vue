<template>
  <CircleIcon
      :symbol="symbol"
      :action="action"
      class="close-icon"
  />
</template>

<script>
  import CircleIcon from "./CircleIcon";
  export default {
    name: "CloseButton",
    props: {
      symbol: String,
      action: Function
    },
    components: {CircleIcon}
  }
</script>

<style scoped>
  .close-icon {
    background: #ccc;
    cursor: pointer;
    padding: 0 0 1px 1px;
  }
  .close-icon:hover {
    background: #cad9ff;
  }
</style>