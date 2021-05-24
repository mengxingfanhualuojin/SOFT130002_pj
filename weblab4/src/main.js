import Vue from 'vue'
import App from './App.vue'
import {router} from "../router";
import qs from 'qs'
import VueRouter from 'vue-router';
Vue.use(VueRouter)

Vue.config.productionTip = false

var axios = require('axios')
// Axios挂载到prototype，全局可以使用this.$axios访问
Vue.prototype.$axios = axios
axios.defaults.baseURL = '/api'
axios.defaults.withCredentials = true
axios.defaults.headers = {
  'Content-type': 'application/x-www-form-urlencoded'
}
//axios.defaults.headers.post['Content-Type'] = "application/json;charset=UTF-8"

Vue.prototype.$qs = qs;

new Vue({
  render: h => h(App),
  router
}).$mount('#app')
