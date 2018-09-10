<template>
  <div class="app-main">
    <transition name="fade">
      <div 
        class="archive" 
        v-show="show">
        <div class="archive-container">
          <div 
            class="archive-item" 
            v-for="(archive, index) in archives" 
            :key="index">
            <div class="archive-item-date">
              <span>#</span> {{ index }}
            </div>
            <div class="archive-list">
              <div class="archive-list-body">
                <div 
                  class="archive-list-item" 
                  v-for="(item, index) in archive" 
                  :key="index">
                  <div class="archive-list-item-container">
                    <div class="item-label">
                      <div class="item-title">
                        <router-link :to="{ name: 'articles', params: { id: item.id }}">{{ item.title }}</router-link>
                      </div>
                      <div class="item-meta">
                        <div class="item-meta-date"> {{ item.created_at }} </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { getArchives } from "@/api/archive";
export default {
  name: "Archive",
  data() {
    return {
      archives: [],
      show: false
    };
  },
  methods: {
    getList() {
      getArchives().then(response => {
        this.archives = response.data.data;
        this.show = true;
      });
    }
  },
  mounted() {
    this.getList();
  }
};
</script>

<style lang="less" scoped>
@import "./Archive.less";
</style>
