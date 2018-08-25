<template>
    <el-row class="panel m-w-1280">
        <el-col :span="24" class="panel-top">
            <el-col :span="4">
        <template v-if="logo_type == '1'">
          <img :src="img" class="logo">
        </template>
        <template v-else>
          <span class="p-l-20">{{title}}</span>
        </template>
            </el-col>
            <el-col :span="16" class="ofv-hd">
                <div class="fl p-l-20 p-r-20 top-menu" :class="{'top-active': menu.selected}" v-for="menu in topMenu" @click="switchTopMenu(menu)">{{menu.title}}</div>
            </el-col>
            <el-col :span="4" class="pos-rel">
                <el-dropdown @command="handleMenu" class="user-menu">
              <span class="el-dropdown-link c-gra" style="cursor: default">
                {{username}}&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="changePwd">修改密码</el-dropdown-item>
                <el-dropdown-item command="logout">退出</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
            </el-col>
        </el-col>
        <el-col :span="24" class="panel-center">
            <!--<el-col :span="4">-->
            <aside class="w-180 ovf-hd" v-show="!showLeftMenu">
                <leftMenu :menuData="menuData" :menu="menu" ref="leftMenu"></leftMenu>
            </aside>
            <section class="panel-c-c" :class="{'hide-leftMenu': hasChildMenu}">
                <div class="grid-content bg-purple-light">
                    <el-col :span="24">
                        <transition name="fade" mode="out-in" appear>
                            <router-view v-loading="showLoading"></router-view>
                        </transition>
                    </el-col>
                </div>
            </section>
        </el-col>

        <changePwd ref="changePwd"></changePwd>

    </el-row>
</template>
<style>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s
    }
    
    .fade-enter,
    .fade-leave-active {
        opacity: 0
    }
    
    .panel {
        position: absolute;
        top: 0px;
        bottom: 0px;
        width: 100%;
    }
    
    .panel-top {
        height: 60px;
        line-height: 60px;
        background: #1F2D3D;
        color: #c0ccda;
    }
    
    .panel-center {
        background: #324057;
        position: absolute;
        top: 60px;
        bottom: 0px;
        overflow: hidden;
    }
    
    .panel-c-c {
        background: #f1f2f7;
        position: absolute;
        right: 0px;
        top: 0px;
        bottom: 0px;
        left: 180px;
        overflow-y: scroll;
        padding: 20px;
    }
    
    .logout {
        background: url();
        background-size: contain;
        width: 20px;
        height: 20px;
        float: left;
    }
    
    .logo {
        width: 150px;
        float: left;
        margin: 10px 10px 10px 18px;
    }
    
    .tip-logout {
        float: right;
        margin-right: 20px;
        padding-top: 5px;
        cursor: pointer;
    }
    
    .admin {
        color: #c0ccda;
        text-align: center;
    }
    .hide-leftMenu {
        left: 0px;
    }
</style>

