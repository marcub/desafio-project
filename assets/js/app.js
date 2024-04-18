import Vue from 'vue';
import VueRouter from 'vue-router';
import App from "./components/App";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import Home from "./components/Home";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);

Vue.config.productionTip = false;

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
      }
];

const router = new VueRouter({
    mode: "history",
    routes
})

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')

