<template>
  <el-scrollbar 
    wrap-class="scrollbar-wrapper" 
    class="sidebar-container">
    <el-menu 
      :default-active="$route.path"
      router>
      <el-submenu index="1">
        <template slot="title">
          <i class="el-icon-document"/>
          <span>文章管理</span>
        </template>
        <el-menu-item-group>
          <el-menu-item index="/articles">
            <i class="el-icon-document"/>
            <span>列表</span>
          </el-menu-item>
          <el-menu-item index="/articles/create">
            <i class="el-icon-edit"/>
            <span>新增</span>
          </el-menu-item>
        </el-menu-item-group>
      </el-submenu>
      <el-menu-item index="/categories">
        <i class="el-icon-menu"/>
        <span slot="title">分类管理</span>
      </el-menu-item>
      <el-menu-item index="/about">
        <i class="el-icon-setting"/>
        <span slot="title">关于</span>
      </el-menu-item>
    </el-menu>
  </el-scrollbar>
</template>

<script>
export default {
    name: "AppSidebar"
};
</script>

<style lang="less" scoped>
@import "./AppSidebar.less";
</style>
