window.Vue = require('vue');

import App from './vue/views/Home.vue';

const app = new Vue({
  el: '#app',
  components: {
    App
  },
  render: h => h(App)
});