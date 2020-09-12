<template>
  <div
      class="circle-icon"
      v-on:click="action"
  >{{ symbol }}</div>
</template>

<script>
  export default {
    name: "CircleIcon",
    props: {
      symbol: [String, Number],
      action: {
        default: ()=>{},
        type: Function
      },
    }
  }
</script>

<style scoped>
  .circle-icon {
    width: 20px;
    height: 20px;
    border-radius: 100%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
  }
</style>