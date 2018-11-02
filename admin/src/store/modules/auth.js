import * as types from "../mutation-types";
import { setAccessToken, getAccessToken, delAccessToken } from "@/utils/auth";

import { login, logout, refresh } from "@/api/login";

const state = {
    accessToken: getAccessToken()
};

const mutations = {
    [types.SET_ACCESS_TOKEN](state, accessToken) {
        state.accessToken = accessToken;
    },
    [types.DEL_ACCESS_TOKEN](state) {
        state.accessToken = "";
    }
};

const actions = {
    /**
     * 登录
     *
     * @param {*} param0
     * @param {*} data
     */
    login({ commit }, data) {
        return new Promise((resolve, reject) => {
            login(data)
                .then(response => {
                    const accessToken = response.data.data.access_token;
                    // 设置 access_token
                    setAccessToken(accessToken);
                    commit(types.SET_ACCESS_TOKEN, accessToken);
                    resolve();
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    /**
     * 刷新 Oath 令牌
     *
     * @param {*} param0
     */
    tokensRefresh({ commit }) {
        return new Promise((resolve, reject) => {
            refresh()
                .then(response => {
                    const accessToken = response.data.data.access_token;
                    // 设置 access_token
                    setAccessToken(accessToken);
                    commit(types.SET_ACCESS_TOKEN, accessToken);
                    resolve();
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    /**
     * 退出登录
     *
     * @param {*} param0
     */
    logout({ commit }) {
        return new Promise((resolve, reject) => {
            logout()
                .then(() => {
                    delAccessToken();
                    commit(types.DEL_ACCESS_TOKEN);
                    resolve();
                })
                .catch(error => {
                    reject(error);
                });
        });
    },
    /**
     * 清空令牌
     *
     * @param {*} param0
     */
    clearTokens({ commit }) {
        return new Promise(resolve => {
            delAccessToken();
            commit(types.DEL_ACCESS_TOKEN);
            resolve();
        });
    }
};

export default {
    state,
    mutations,
    actions
};
