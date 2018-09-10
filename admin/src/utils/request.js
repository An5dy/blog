import axios from "axios";
import store from "../store";
import Nprogress from "nprogress";
import "nprogress/nprogress.css";
import { getAccessToken } from "@/utils/auth";
import { Message, MessageBox } from "element-ui";

/* 设置公共头 */
const service = axios.create({
  baseURL: "/api/admin",
  // timeout: 1500,
  timeout: 3000,
  headers: {
    Accept: "application/json",
    "X-Requested-With": "XMLHttpRequest"
  }
});

/* 设置 request 拦截 */
service.interceptors.request.use(
  function(config) {
    if (store.getters.accessToken) {
      config.headers["Authorization"] = "Bearer " + getAccessToken();
    }
    return config;
  },
  function(error) {
    return Promise.reject(error);
  }
);

/* 请求拦截 */
service.interceptors.request.use(
  config => {
    // 加载进度条
    Nprogress.start();
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

/* 响应拦截 */
service.interceptors.response.use(
  response => {
    const res = response.data;
    const code = res.code;
    if (code === "2000") {
      Nprogress.done();
      return response;
    } else {
      if (code === "4001") {
        // access_token 过期
        MessageBox.confirm("登录令牌已失效", "重新获取?", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        })
          .then(() => {
            store.dispatch("tokensRefresh").then(() => {
              location.reload();
            });
          })
          .catch(() => {});
      } else if (code === "4002") {
        // refresh_token 不存在或失效
        MessageBox.confirm(res.message, "确认登出?", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        })
          .then(() => {
            store.dispatch("clearTokens").then(() => {
              location.reload();
            });
          })
          .catch(() => {});
      } else {
        Message({
          // 其他错误
          message: res.message,
          type: "error",
          duration: 5000
        });
      }
      Nprogress.done();
      return Promise.reject(response.data.message);
    }
  },
  error => {
    return Promise.reject(error);
  }
);

export default service;
