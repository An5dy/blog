<template>
  <div class="app-main">
    <div class="article-list">
      <transition-group 
        name="staggered-fade" 
        :css="false" 
        @before-enter="beforeEnter" 
        @enter="enter" 
        tag="div">
        <div 
          class="artile-item" 
          v-for="(item, index) in list" 
          :key="index">
          <div class="article-item-container">
            <div 
              class="artile-item-image" 
              :style="{backgroundImage: 'url(' + item.cover_img +')'}" />
            <div class="artile-item-description">
              <router-link :to="{ name: 'articles', params: { id: item.id }}">
                <p>{{ item.description }}</p>
              </router-link>
            </div>
            <div class="artile-item-lable">
              <div class="artile-item-title">
                <router-link :to="{ name: 'articles', params: { id: item.id }}">{{ item.title }}</router-link>
              </div>
              <div class="artile-item-meta">
                <span>{{ item.published_at }}</span>
                <span>{{ item.category.title }}</span>
              </div>
              <div class="artile-item-read">
                <router-link :to="{ name: 'articles', params: { id: item.id }}">继续阅读</router-link>
              </div>
            </div>
          </div>
        </div>
      </transition-group>
    </div>
    <div class="load-more">
      <div 
        v-if="loadMore" 
        class="load-more-button" 
        @click="loadMoreArticles">点击加载更多...</div>
      <div 
        v-if="loading" 
        class="loading">
        <icon 
          name="spinner" 
          pulse 
          scale="1.3" />
      </div>
      <div 
        v-if="loadNone" 
        class="load-none">{{ loadNoneText }}</div>
    </div>
  </div>
</template>

<script>
import Velocity from "velocity-animate";
import { getArticles } from "@/api/article";
export default {
  name: "Home",
  data() {
    return {
      list: [],
      loading: false,
      loadMore: false,
      loadNone: false,
      page: 1,
      isRequest: true,
      loadNoneText: "我也是有底线的...",
      isEnd: false
    };
  },
  methods: {
    beforeEnter(el) {
      el.style.opacity = 0;
      el.style.transform = "translateY(100px)";
    },
    enter(el, done) {
      let delay = el.dataset.index * 100;
      Velocity(
        el,
        {
          opacity: 1,
          translateY: 0
        },
        {
          delay: delay,
          easing: "spring",
          complete: done
        }
      );
      done();
    },
    initScroll() {
      document.addEventListener("scroll", this.reloadMoreData, true);
    },
    reloadMoreData() {
      let scrollY;
      // 监听滚动条下拉
      if (self.pageYOffset) {
        scrollY = self.pageYOffset;
      } else if (
        document.documentElement &&
        document.documentElement.scrollTop
      ) {
        scrollY = document.documentElement.scrollTop;
      } else if (document.body) {
        scrollY = document.body.scrollTop;
      }
      // 滚动条拉到底
      if (
        window.innerHeight + scrollY === document.body.offsetHeight &&
        this.page <= 3 &&
        this.isRequest &&
        !this.loadNone
      ) {
        this.getList();
      }
    },
    getList() {
      this.loading = true;
      this.isRequest = false;
      let formData = {
        page: this.page
      };
      if (this.$route.params.title != null) {
        formData.title = this.$route.params.title;
      }
      getArticles(formData)
        .then(response => {
          this.list = this.list.concat(response.data.data);
          if (this.list.length === 0 && this.$route.params.title != null) {
            this.loadNone = true;
            this.loadNoneText = "查询文章不存在！";
          } else {
            ++this.page; // 分页加 1
            if (this.page > 3) {
              if (this.page <= response.data.meta.last_page) {
                this.loadMore = true;
              } else {
                this.loadMore = false;
                this.loadNone = true;
                this.loadNoneText = "我也是有底线的...";
              }
            } else {
              if (
                response.data.meta.last_page === response.data.meta.current_page
              ) {
                this.loadMore = false;
                this.loadNone = true;
                this.loadNoneText = "我也是有底线的...";
              }
            }
          }
          this.loading = false;
          this.isRequest = true;
        })
        .catch(() => {
          this.loading = false;
          this.isRequest = true;
        });
    },
    loadMoreArticles() {
      this.loadMore = false;
      this.getList();
    }
  },
  mounted() {
    this.getList();
    this.initScroll();
  },
  destroyed() {
    document.removeEventListener("scroll", this.reloadMoreData, true);
  },
  watch: {
    $route() {
      this.page = 1;
      this.list = [];
      this.loadNone = false;
      this.loadMore = false;
      this.getList();
    }
  }
};
</script>

<style lang="less" scoped>
@import "./Home.less";
</style>
