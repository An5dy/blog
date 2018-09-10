<template>
  <div class="app-main">
    <transition name="fade">
      <div 
        class="about" 
        v-show="show">
        <div class="about-container">
          <div 
            class="about-content" 
            v-html="about.markdown"/>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { showAbout } from "@/api/about";
import marked from "marked";
marked.setOptions({
  renderer: new marked.Renderer(),
  gfm: true,
  tables: true,
  breaks: false,
  pedantic: false,
  sanitize: false,
  smartLists: true,
  smartypants: false
});
export default {
  name: "About",
  data() {
    return {
      about: "",
      show: false
    };
  },
  methods: {
    getAbout() {
      showAbout().then(response => {
        this.about = response.data.data;
        this.about.markdown = marked(this.about.markdown || "", {
          sanitize: true
        });
        this.show = true;
      });
    }
  },
  mounted() {
    this.getAbout();
  }
};
</script>

<style lang="less" scoped>
@import "./About.less";
</style>
