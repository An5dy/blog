import request from "@/utils/request";

/**
 * 文章列表
 *
 * @param {*} data
 */
export function getArticles(data) {
  return request({
    url: "articles",
    method: "get",
    params: data
  });
}

/**
 * 文章详情
 *
 * @param {*} id
 */
export function getArticle(id) {
  return request({
    url: "articles/" + id,
    method: "get"
  });
}
