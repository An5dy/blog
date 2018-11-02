<template>
  <el-form 
    ref="loginForm"
    :model="loginForm" 
    :rules="loginRules"
    label-position="left" 
    label-width="0px"
    class="login-container">
    <h3 class="title">后台登录</h3>
    <el-form-item prop="name">
      <el-input 
        type="text" 
        v-model="loginForm.name" 
        auto-complete="off" 
        placeholder="用户名"/>
    </el-form-item>
    <el-form-item prop="password">
      <el-input 
        type="password" 
        v-model="loginForm.password" 
        auto-complete="off" 
        placeholder="密码"/>
    </el-form-item>
    <el-form-item style="width:100%;">
      <el-button 
        type="primary" 
        style="width:100%;"
        :loading="loading"
        @click.native.prevent="handleLogin">登录</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
export default {
    name: "Login",
    data() {
        const validateName = (rule, value, callback) => {
            if (!value) {
                callback(new Error("用户名不能为空。"));
            } else {
                callback();
            }
        };
        const validatePassword = (rule, value, callback) => {
            if (value.length < 6) {
                callback(new Error("密码不能小于6位。"));
            } else {
                callback();
            }
        };
        return {
            loading: false,
            loginForm: {
                name: "",
                password: ""
            },
            loginRules: {
                name: [
                    {
                        required: true,
                        trigger: "blur",
                        validator: validateName
                    }
                ],
                password: [
                    {
                        required: true,
                        trigger: "blur",
                        validator: validatePassword
                    }
                ]
            }
        };
    },
    methods: {
        handleLogin() {
            this.$refs.loginForm.validate(valid => {
                if (valid) {
                    this.loading = true;
                    let data = {
                        username: this.loginForm.name,
                        password: this.loginForm.password
                    };
                    this.$store
                        .dispatch("login", data)
                        .then(() => {
                            this.$router.push("/");
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                } else {
                    return false;
                }
            });
        }
    }
};
</script>

<style lang="less" scoped>
@import "./Login.less";
</style>
