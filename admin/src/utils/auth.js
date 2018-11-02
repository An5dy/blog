const ACCESS_TOKEN_KEY = "admin_access_token";

/**
 * 设置 access_token
 *
 * @export
 * @param {*} accessToken
 * @returns
 */
export function setAccessToken(accessToken) {
    return window.sessionStorage.setItem(ACCESS_TOKEN_KEY, accessToken);
}

/**
 * 获取 access_token
 *
 * @export
 * @returns
 */
export function getAccessToken() {
    return window.sessionStorage.getItem(ACCESS_TOKEN_KEY);
}

/**
 * 删除 access_token
 *
 * @export
 * @returns
 */
export function delAccessToken() {
    return window.sessionStorage.removeItem(ACCESS_TOKEN_KEY);
}
