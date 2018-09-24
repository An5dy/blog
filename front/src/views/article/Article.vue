<template>
  <div class="app-main">
    <div 
      id="particles" 
      class="particles" />
    <transition name="fade">
      <div 
        class="article" 
        v-show="show">
        <div class="article-container">
          <div class="article-title">
            <h2>{{ article.title }}</h2>
            <div class="article-meta">
              <div>
                <icon 
                  name="clock" 
                  scale="0.8"/> {{ article.created_at }}</div>
              <div>
                <icon 
                  name="book" 
                  scale="0.8"/> {{ article.category.title }}</div>
              <div>
                <icon 
                  name="eye" 
                  scale="0.8"/> {{ article.views_count }}</div>
            </div>
          </div>
          <div 
            class="article-description" 
            v-html="article.markdown" />
          <div class="article-tags">
            <div 
              class="article-tags-item" 
              v-for="(tag, index) in article.tags" 
              :key="index">{{ tag.title }}</div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { getArticle } from "@/api/article";
import marked from "marked";
import highlight from "highlight.js";
import "highlight.js/styles/googlecode.css";
marked.setOptions({
  renderer: new marked.Renderer(),
  gfm: true,
  tables: true,
  breaks: false,
  pedantic: false,
  sanitize: false,
  smartLists: true,
  smartypants: false,
  highlight: function(code, lang) {
    if (lang && highlight.getLanguage(lang)) {
      return highlight.highlight(lang, code, true).value;
    } else {
      return highlight.highlightAuto(code).value;
    }
  }
});
import "particles.js";
import particlesConfig from "@/assets/particles.json";
export default {
  name: "Article",
  data() {
    return {
      show: false,
      article: {
        id: "",
        title: "",
        checked_num: "",
        category: {
          id: "",
          title: ""
        },
        markdown: "",
        created_at: ""
      }
    };
  },
  methods: {
    showArticle() {
      getArticle(this.$route.params.id).then(response => {
        if (response.data.code === "2000") {
          let markdown = response.data.data.markdown;
          this.article = response.data.data;
          markdown = marked(markdown || "", {
            sanitize: true
          });
          this.article.markdown = markdown;
          this.show = true;
        }
      });
    },
    initParticles() {
      window.particlesJS("particles", particlesConfig);
    }
  },
  updated() {
    // this.initParticles();
  },
  mounted() {
    this.showArticle();
  }
};
</script>

<style lang="less" scoped>
@import "./Article.less";
</style>
