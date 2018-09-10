<template>
  <div class="footer">
    <div class="footer-container">
      <div class="footer-meta">
        <div class="footer-site-desc">
          <p>© 2016-{{ year }}
            <b>
              <router-link to="/">zhangze.me</router-link>
          </b> All right reserved. </p>
        </div>
        <div class="footer-social">
          <span><a href="#"><icon 
            name="github" 
            scale="1.4"/></a></span>
          <span><a href="#"><icon 
            name="weibo" 
            scale="1.4"/></a></span>
          <span><a href="#"><icon 
            name="envelope" 
            scale="1.3"/></a></span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Footer",
  data() {
    return {
      year: new Date().getFullYear()
    };
  }
};
</script>

<style lang="less" scoped>
@import "./Footer.less";
</style>
