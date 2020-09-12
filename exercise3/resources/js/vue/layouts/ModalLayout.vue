<template>
  <div class="modal-layout">
    <slot></slot>
  </div>
</template>

<script>
  export default {
    name: "ModalLayout"
  }
</script>

<style scoped>
  .modal-layout {
    position: absolute;
    top: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background: #0000004b;
  }
</style>