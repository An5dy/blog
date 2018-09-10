<template>
  <headroom 
    :speed="220" 
    :offset="60">
    <header class="header">
      <div class="nav-container">
        <!-- <b> -->
        <router-link 
          to="/" 
          class="nav-logo">泽's</router-link>
        <!-- </b> -->
        <div class="nav-menus">
          <router-link 
            to="/archives" 
            class="nav-menus-archive">归档</router-link>
          <router-link 
            to="/about" 
            class="nav-menus-about">关于</router-link>
        </div>
        <div class="nav-search">
          <input 
            type="text" 
            class="nav-search-input" 
            placeholder="请输入文章标题..."
            v-model.trim="title"
            @keyup.enter="onSearch">
          <icon 
            name="search" 
            class="nav-search-icon" />
        </div>
      </div>
    </header>
  </headroom>
</template>

<script>
import { headroom } from "vue-headroom";
export default {
  name: "Header",
  data() {
    return {
      title: ""
    };
  },
  components: {
    headroom
  },
  methods: {
    onSearch() {
      if (this.title) {
        this.$router.push({
          path: "/search/" + this.title
        });
      }
    }
  }
};
</script>

<style lang="less" scoped>
@import "./Header.less";
</style>
