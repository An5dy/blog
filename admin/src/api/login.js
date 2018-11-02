import request from "@/utils/request";

/**
 * 登录
 *
 * @export
 * @param {*} name
 * @param {*} password
 * @returns
 */
export function login(data) {
    return request({
        url: "login",
        method: "post",
        data
    });
}

/**
 * 退出登录
 *
 * @export
 * @returns
 */
export function logout() {
    return request({
        url: "/logout",
        method: "get"
    });
}

/**
 * 刷新 access_token
 *
 * @returns
 */
export function refresh() {
    return request({
        url: "/tokens/refresh",
        method: "get"
    });
}

/**
 * 修改账号或密码
 *
 * @param {*} data
 */
export function reset(data) {
    return request({
        url: "/reset",
        method: "post",
        data
    });
}
