<template>
  <svg
      xmlns="http://www.w3.org/2000/svg"
      :height="size"
      :width="size"
      x="0px" y="0px"
      viewBox="0 0 528.9 528.9"
      style="enable-background:new 0 0 528.9 528.9;"
      xml:space="preserve"
  >
    <g>
      <path
          :fill="color"
          d="M328.9,89.1l107.6,107.6L164.1,469.1L56.6,361.5L328.9,89.1z M518.1,63.2l-48-48c-18.5-18.5-48.7-18.5-67.3,0l-46,46
        l107.6,107.6l53.6-53.6C532.5,100.8,532.5,77.6,518.1,63.2z M0.3,512.7c-2,8.8,6,16.7,14.8,14.6L135,498.2L27.5,390.6L0.3,512.7z"
      ></path>
    </g>
    <path
        :fill="color"
        d="M507.6,527.6h-497V485h497c11.8,0,21.3,9.5,21.3,21.3v0C528.9,518.1,519.4,527.6,507.6,527.6z"
    ></path>
  </svg>
</template>

<script>
  export default {
    name: "EditIcon",
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