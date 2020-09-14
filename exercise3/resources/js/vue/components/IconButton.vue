<template>
  <div
      class="icon-button"
      v-on:mouseover="hover=true"
      v-on:mouseout="hover=false"
      v-on:click="($event) => {
        $event.stopPropagation();
        action();
      }"
  >
    <slot :color="hover ? hoverColor : color"/>
  </div>
</template>

<script>
  export default {
    name: "IconButton",
    props: {
      color: String,
      hoverColor: String,
      action: {
        default: ()=>{},
        type: Function
      },
    },
    data() {
      return {
        hover: false,
      }
    }
  }
</script>

<style scoped>
  .icon-button {
    cursor: pointer;
  }
</style>