<template>
  <div class="wide-button" v-on:click="action">
    <slot name="icon"/>
    <slot name="title"/>
  </div>
</template>

<script>
  export default {
    name: "WideButton",
    props: {
      action: {
        default: ()=>{},
        type: Function,
      },
    }
  }
</script>

<style scoped>
  .wide-button {
    display: flex;
    flex-direction: row;
    padding: 15px 20px;
    background: #f9f9f9;
    border-radius: 2px;
    margin-bottom: 15px;
  }
  .wide-button:hover {
    cursor: pointer;
    background: #cad9ff;
  }
</style>