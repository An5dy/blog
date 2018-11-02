<template>
  <div class="app-container">
    <app-header/>
    <app-sidebar/>
    <div class="main-container">
      <section class="app-main">
        <transition 
          name="fade-transform" 
          mode="out-in">
          <router-view/>
        </transition>
      </section>
    </div>
  </div>
</template>

<script>
import AppHeader from "@/components/AppHeader";
import AppSidebar from "@/components/AppSidebar";
import AppBreadcrumb from "@/components/AppBreadcrumb";
export default {
    name: "Layout",
    components: {
        AppHeader,
        AppSidebar,
        AppBreadcrumb
    }
};
</script>

<style lang="less" scoped ref="stylesheet/less">
@import "./Layout.less";
</style>
