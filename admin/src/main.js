import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "@/styles/index.less";

/* elemet-ui */
import "element-ui/lib/theme-chalk/index.css";
import ElementUI from "@/assets/js/element-config";
Vue.use(ElementUI);

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
