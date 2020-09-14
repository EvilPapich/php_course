<template>
  <div
      v-on:mouseover="hover=true"
      v-on:mouseout="hover=false"
      v-on:click="($event) => {
        $event.stopPropagation();
        action();
      }"
  >
    <DoneIcon
        class="done-icon"
        :color="hover ? hoverColor : color"
    />
  </div>
</template>

<script>
  import DoneIcon from "../icons/DoneIcon";
  export default {
    name: "DoneButton",
    components: {DoneIcon},
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
  .done-icon {
    cursor: pointer;
  }
</style>