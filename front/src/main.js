import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./styles/index.less";

/* normalize */
import "normalize.css";

/* vue-awesome */
import "vue-awesome/icons/search";
import "vue-awesome/icons/spinner";
import "vue-awesome/icons/envelope";
import "vue-awesome/icons/clock";
import "vue-awesome/icons/book";
import "vue-awesome/icons/eye";
import "./assets/icons/github";
import "./assets/icons/weibo";
import Icon from "vue-awesome/components/Icon";
Vue.component("Icon", Icon);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
