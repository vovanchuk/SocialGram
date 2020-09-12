/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
window._ = require('lodash');
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*import VueRouter from 'vue-router'
import 'es6-promise/auto';
import axios from 'axios';
import VueAuth from '@websanova/vue-auth';
import VueAxios from 'vue-axios';
import auth from './auth';
import router from "./router";
import vuetify from "./plugins/vuetify";
import store from "./store";

Vue.router = router
Vue.use(VueRouter)
Vue.use(VueAxios, axios);
axios.defaults.baseURL = 'http://social.test/api';
Vue.use(VueAuth, auth);
Vue.component('index', require('./Index').default);

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify
});*/

import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import router from './router'
import store from './store'

import 'es6-promise/auto';
import VueAuth from '@websanova/vue-auth';
import axios from 'axios';
import VueAxios from 'vue-axios';
import auth from './auth';
import toastification from './plugins/vue-toastification';

Vue.router = router;
Vue.use(VueAxios, axios);
axios.defaults.baseURL = 'http://social.test/api';

// axios.interceptors.response.use(null, error => {
//     let path = '/error';
//     switch (error.response.status) {
//         case 401: path = '/login'; break;
//         case 404: path = '/404'; break;
//     }
//     router.push(path);
//     return Promise.reject(error);
// });

Vue.prototype.$swap = function(arr, a, b) {
    let temp1 = arr[a];
    let temp2 = arr[b];

    Vue.set(arr,a,temp2);
    Vue.set(arr,b,temp1);
}

Vue.use(VueAuth, auth);

Vue.config.productionTip = false

new Vue({
  vuetify,
  router,
  store,
  render: h => h(App)
}).$mount('#app')

