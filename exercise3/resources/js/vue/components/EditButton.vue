<template>
  <div
      v-on:mouseover="hover=true"
      v-on:mouseout="hover=false"
      v-on:click="($event) => {
        $event.stopPropagation();
        action();
      }"
  >
    <EditIcon
        class="edit-icon"
        :color="hover ? hoverColor : color"
    />
  </div>
</template>

<script>
  import EditIcon from "../icons/EditIcon";
  export default {
    name: "EditButton",
    components: {EditIcon},
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
  .edit-icon {
    cursor: pointer;
  }
</style>