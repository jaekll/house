import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Main from '@/views/Main'
import Login from '@/views/login/Login'
import UserList from '@/views/user/List'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      iconCls:'el-icon-message',
      children:[
        {path:'/main',component:Main,name:'主业',hidden:true},
        {path:'/user',component:UserList,name:'用户列表'}
      ]
    },
    {
    path: '/home',
    component: Home,
    children: [
      { path: 'menu/list', component: menuList, name: 'menuList', meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }},
      { path: 'menu/add', component: menuAdd, name: 'menuAdd', meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }},
      { path: 'menu/edit/:id', component: menuEdit, name: 'menuEdit', meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }}
    ]
  },
    {
        path:'/login',
        name:Login,
        component:Login,
        hidden:true
    }
  ]
})
