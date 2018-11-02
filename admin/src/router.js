import Vue from "vue";
import Router from "vue-router";
import { getAccessToken } from "@/utils/auth";
import Views from "./views";
import Layout from "./views/layout";

Vue.use(Router);

const router = new Router({
    routes: [
        {
            path: "/login",
            name: "login",
            component: Views.Login
        },
        {
            path: "/",
            name: "home",
            component: Layout,
            redirect: "articles",
            meta: {
                title: "首页",
                icon: "home"
            },
            children: [
                {
                    path: "/articles/create",
                    name: "artcile-create",
                    component: Views.ArticleAdd,
                    meta: {
                        title: "发布文章"
                    }
                },
                {
                    path: "/articles/:id",
                    name: "artcile-show",
                    component: Views.ArticleAdd,
                    meta: {
                        title: "修改文章"
                    }
                },
                {
                    path: "/articles",
                    name: "article-list",
                    component: Views.ArticleList,
                    meta: {
                        title: "文章列表"
                    }
                },
                {
                    path: "/categories",
                    name: "category-list",
                    component: Views.Category,
                    meta: {
                        title: "分类管理"
                    }
                },
                {
                    path: "/about",
                    name: "about",
                    component: Views.About,
                    meta: {
                        title: "关于"
                    }
                }
            ]
        }
    ]
});

// 免登录白名单
const whiteList = ["/login"];

router.beforeEach((to, from, next) => {
    if (getAccessToken()) {
        if (to.path === "/login") {
            next({
                path: "/"
            });
        } else {
            next();
        }
    } else {
        if (whiteList.indexOf(to.path) !== -1) {
            next();
        } else {
            next({
                path: "login"
            });
        }
    }
});

router.afterEach(to => {
    // 设置 title
    let title = to.meta.title;
    if (typeof title !== "undefined") {
        window.document.title = title;
    }
});

export default router;
