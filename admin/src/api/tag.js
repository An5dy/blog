import request from "@/utils/request";

/**
 * 删除标签
 *
 * @param {*} id
 */
export function deleteTag(id) {
    return request({
        url: "/tags/" + id,
        method: "post",
        data: {
            _method: "DELETE"
        }
    });
}
