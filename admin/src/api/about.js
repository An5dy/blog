import request from "@/utils/request";

/**
 * 获取关于
 */
export function showAbout() {
    return request({
        url: "/abouts",
        method: "get"
    });
}

/**
 * 保存
 *
 * @param {*} data
 */
export function storeAbout(data) {
    return request({
        url: "/abouts",
        method: "post",
        data
    });
}

/**
 * 修改
 *
 * @param {*} id
 * @param {*} data
 */
export function updateAbout(id, data) {
    data["_method"] = "PUT";
    return request({
        url: "/abouts/" + id,
        method: "post",
        data
    });
}
