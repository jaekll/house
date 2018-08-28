import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Main from '@/views/Main'
import Login from '@/views/login/Login'
import UserList from '@/views/user/List'
import MenuList from '@/views/system/menu/List'
import MenuAdd from '@/views/system/menu/List'
import MenuEdit from '@/views/system/menu/List'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: '主页',
      component: Home,
      iconCls:'el-icon-message',
      children:[
        {path:'/main',component:Main,name:'主业'},
      ]
    },
    {
      path: '/',
      name:'菜单',
      iconCls:'el-icon-menu',
      component: Home,
      children: [
        { path: 'menu/list', component: MenuList, name: 'MenuList', meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }},
        { path: 'menu/add', component: MenuAdd, name: 'MenuAdd', meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }},
        { path: 'menu/edit/:id', component: MenuEdit, name: 'MenuEdit', meta: { hideLeft: false, module: 'Administrative', menu: 'menu' }}
      ]
    },
    {
        path: '/',
        name:'用户管理',
        iconCls:'el-icon-setting',
        component: Home,
        children: [
           {path:'user/list',component:UserList,name:'用户列表'}
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
