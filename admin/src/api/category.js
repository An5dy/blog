import request from "@/utils/request";

/**
 * 获取分类列表
 */
export function getCategories() {
    return request({
        url: "/categories",
        method: "get"
    });
}

/**
 * 新增
 *
 * @param {*} data
 */
export function storeCategory(data) {
    return request({
        url: "/categories",
        method: "post",
        data
    });
}

/**
 * 更新
 *
 * @param {*} data
 * @param {*} id
 */
export function updateCategory(data, id) {
    data["_method"] = "PUT";
    return request({
        url: "/categories/" + id,
        method: "post",
        data
    });
}

/**
 * 删除
 *
 * @param {*} id
 */
export function deleteCategory(id) {
    return request({
        url: "/categories/" + id,
        method: "post",
        data: {
            _method: "DELETE"
        }
    });
}
