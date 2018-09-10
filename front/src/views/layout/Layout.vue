<template>
  <div class="app-container">
    <app-header/>
    <div class="main-container">
      <router-view/>
    </div>
    <app-footer/>
  </div>
</template>

<script>
import AppHeader from "@/components/Header";
import AppFooter from "@/components/Footer";
export default {
  name: "Layout",
  components: {
    AppHeader,
    AppFooter
  }
};
</script>

<style lang="less" scoped>
</style>
