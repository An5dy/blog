import axios from "axios";
import Nprogress from "nprogress";
import "nprogress/nprogress.css";

/* 设置公共头 */
const service = axios.create({
  baseURL: "/api",
  // timeout: 1500,
  headers: {
    Accept: "application/json",
    "X-Requested-With": "XMLHttpRequest"
  }
});

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
    Nprogress.done();
    return response;
  },
  error => {
    console.log("err" + error);
    return Promise.reject(error);
  }
);

export default service;
