import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Login from '@/components/Login'
import Main from '@/components/Main'
import Table from '@/components/Table'
import Form from '@/components/Form'
import User from '@/components/User'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      iconCls:'el-icon-message',
      childer:[
        {path:'/main',component:Main,name:'主业',hidden:true},
        {path:'/table',component:Table,name:'表格',hidden:true},
        {path:'/from',component:Main,name:'表单',hidden:true},
        {path:'/user',component:User,name:'主用户业',hidden:true}
      ]
    },
    
    {
        path:'/login',
        name:Login,
        component:Login
    }
  ]
})
