<template>
  <svg
      :height="size"
      :width="size"
      viewBox="0 -22 512 511"
      xmlns="http://www.w3.org/2000/svg"
  >
    <path
        :fill="color"
        d="m512 233.820312-212.777344-233.320312v139.203125h-45.238281c-140.273437 0-253.984375 113.710937-253.984375 253.984375v73.769531l20.09375-22.019531c68.316406-74.851562 164.980469-117.5 266.324219-117.5h12.804687v139.203125zm0 0"
    ></path>
  </svg>
</template>

<script>
  export default {
    name: "ReferIcon",
    props: {
      color: String,
      size: {
        default: 16,
        type: Number,
      }
    }
  }
</script>

<style scoped>

</style>