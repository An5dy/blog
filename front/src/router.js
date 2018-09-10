import Vue from "vue";
import Router from "vue-router";
import Layout from "@/views/layout";
import Views from "@/views";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "",
      component: Layout,
      meta: {
        title: "个人博客"
      },
      children: [
        {
          path: "/",
          component: Views.Home,
          meta: {
            title: "文章列表"
          }
        },
        {
          path: "/search/:title",
          name: "search",
          component: Views.Home,
          meta: {
            title: "文章搜索"
          }
        },
        {
          path: "/articles/:id",
          name: "articles",
          component: Views.Article,
          meta: {
            title: "文章详情"
          }
        },
        {
          path: "/about",
          component: Views.About,
          meta: {
            title: "关于我呀"
          }
        },
        {
          path: "/archives",
          component: Views.Archive,
          meta: {
            title: "归档"
          }
        }
      ]
    }
  ]
});
