<template>
  <svg
      xmlns="http://www.w3.org/2000/svg"
      x="0px" y="0px"
      :height="size"
      :width="size"
      viewBox="0 0 384 384"
      style="enable-background:new 0 0 384 384;"
      xml:space="preserve"
  >
  <g>
    <g>
      <g>
        <path
            :fill="color"
            d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"
        ></path>
        <polygon
            :fill="color"
            points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333"
        ></polygon>
      </g>
    </g>
  </g>
  </svg>
</template>

<script>
  export default {
    name: "TrashIcon",
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