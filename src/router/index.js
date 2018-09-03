import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Main from '@/views/Main'
import Login from '@/views/login/Login'
import UserList from '@/views/user/List'
import MenuList from '@/views/system/menu/List'
import MenuAdd from '@/views/system/menu/Add'
import MenuEdit from '@/views/system/menu/Edit'
import SysConfig from '@/views/system/config/Add'
import RuleList from '@/views/system/rule/List'
import NotFound from '@/views/404'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: '主页',
      component: Home,
      iconCls:'el-icon-message',
      children:[
        {path:'/main',component:Main,name:'主页' },
      ]
    },
    {
      path: '/',
      name:'系统设置',
      iconCls:'el-icon-setting',
      component: Home,
      children: [
        { path: '/menu/list', component: MenuList, name: '菜单管理'},
        { path: '/menu/add', component: MenuAdd, name: '菜单添加',hidden:true},
        { path: '/config/add', component: SysConfig, name: '系统配置'},
        { path: '/rule/list', component: RuleList, name: '权限管理'}
      ]
    },
    {
        path: '/',
        name:'用户管理',
        iconCls:'el-icon-setting',
        component: Home,
        children: [
           {path:'/user/list',component:UserList,name:'用户列表'}
        ]
    },
    {
        path:'/login',
        name:'登录',
        component:Login,
        hidden:true
    },
    {
      path:'/404',
      component:NotFound,
      name:'未找到',
      hidden:true
    },
    // {
    //   path:'*',
    //   hidden:true,
    //   redirect:{path:'/404'}
    // }
  ]
})
