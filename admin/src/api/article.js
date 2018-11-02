import request from "@/utils/request";

/**
 * 新增文章
 *
 * @param {*} data
 */
export function storeArticle(data) {
    return request({
        url: "/articles",
        method: "post",
        data
    });
}

/**
 * 文章详情
 *
 * @param {*} id
 */
export function showArtcile(id) {
    return request({
        url: "/articles/" + id,
        method: "get"
    });
}

/**
 * 文章列表
 *
 * @param {*} data
 */
export function getArticles(data) {
    return request({
        url: "/articles",
        method: "get",
        params: data
    });
}

/**
 * 删除文章
 *
 * @param {*} id
 */
export function deleteArticle(id) {
    return request({
        url: "/articles/" + id,
        method: "post",
        data: {
            _method: "DELETE"
        }
    });
}

/**
 * 修改文章
 *
 * @param {*} id
 * @param {*} data
 */
export function updateArticle(id, data) {
    data.append("_method", "PUT");
    return request({
        url: "/articles/" + id,
        method: "post",
        data
    });
}
