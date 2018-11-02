import request from "@/utils/request";

/**
 * 图片上传
 *
 * @param {*} formData
 */
export function imageUpload(formData) {
    return request({
        url: "/images",
        method: "post",
        data: formData,
        headers: { "Content-Type": "multipart/form-data" }
    });
}
