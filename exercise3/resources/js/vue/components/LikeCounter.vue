<template>
  <div
      class="like-counter-wrapper"
      v-on:mouseover="hover=true"
      v-on:mouseout="hover=false"
      v-on:click="($event) => {
        $event.stopPropagation();
        action();
      }"
  >
    <div
        class="like-icon"
        :style="{
          marginRight: '5px',
          ...{
            'top': {},
            'bottom': {display: 'flex', alignItems: 'center'},
          }[orientation]
        }"
    >
      <LikeIcon
          :color="hover ? hoverColor : color"
          :style="{
            'top': {transform: 'rotate(0deg)'},
            'bottom': {transform: 'rotate(180deg)'},
          }[orientation]"
      />
    </div>
    <div class="like-count" :style="{marginRight: '5px', color: hover ? hoverColor : color}">
      {{ count }}
    </div>
  </div>
</template>

<script>
  import LikeIcon from "../icons/LikeIcon";
  export default {
    name: "LikeCounter",
    components: {LikeIcon},
    props: {
      count: Number,
      color: String,
      hoverColor: String,
      orientation: {
        default: 'top',
        type: String
      },
      action: {
        default: ()=>{},
        type: Function
      }
    },
    data() {
      return {
        hover: false,
      }
    }
  }
</script>

<style scoped>
  .like-counter-wrapper {
    display: flex;
    flex-direction: row;
    cursor: pointer;
  }
  .like-icon {

  }
  .like-count {
    font-weight: 600;
  }
</style>