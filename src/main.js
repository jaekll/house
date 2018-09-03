// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Lockr from 'lockr'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App'
import router from './router'
//本地调试数据
// import Mock from './mock'
// Mock.bootstrap()
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import '@/assets/scss/base.scss'


Vue.config.productionTip = false
Vue.use(ElementUI)

router.beforeEach((to,from,next)=>{
  NProgress.start()
  next()
})

window.Lockr = Lockr

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  render:h=>h(App)
})
