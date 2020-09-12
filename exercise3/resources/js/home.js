window.Vue = require('vue');

import App from './components/views/Home.vue';

const app = new Vue({
  el: '#app',
  components: {
    App
  },
  render: h => h(App)
});