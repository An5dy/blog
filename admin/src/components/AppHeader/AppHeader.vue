<template>
  <div>
    <el-menu class="header">
      <div class="logo">
        <router-link to="/">管理后台</router-link>
      </div>
      <el-dropdown 
        class="userinfo-container" 
        trigger="click" 
        @command="handleCommand">
        <div class="userinfo-name">
          <span class="el-dropdown-link userinfo-inner">管理员</span>
          <i class="el-icon-caret-bottom" />
        </div>
        <el-dropdown-menu 
          slot="dropdown" 
          class="userinfo-dropdown">
          <el-dropdown-item command="passwordReset">修改密码</el-dropdown-item>
          <el-dropdown-item 
            divided 
            command="logout">退出登录</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </el-menu>
    <!-- dialog -->
    <el-dialog 
      title="修改密码" 
      :visible.sync="dialogFormVisible" 
      width="400px" 
      center>
      <el-form :model="user">
        <el-form-item 
          label="账号" 
          :label-width="formLabelWidth" 
          label-position="left" >
          <el-input 
            v-model="user.username" 
            auto-complete="off"/>
        </el-form-item>
        <el-form-item 
          label="原密码" 
          :label-width="formLabelWidth" 
          label-position="left" >
          <el-input 
            v-model="user.old_password" 
            auto-complete="off"/>
        </el-form-item>
        <el-form-item 
          label="新密码" 
          :label-width="formLabelWidth" 
          label-position="left" >
          <el-input 
            v-model="user.new_password" 
            auto-complete="off"/>
        </el-form-item>
        <el-form-item 
          label="确认密码" 
          :label-width="formLabelWidth" 
          label-position="left" >
          <el-input 
            v-model="user.new_password_confirmation" 
            auto-complete="off"/>
        </el-form-item>
      </el-form>
      <div 
        slot="footer" 
        class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button 
          type="primary" 
          @click="onSubmit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
    
</template>

<script>
import { reset } from "@/api/login";
export default {
    name: "AppHeader",
    data() {
        return {
            dialogFormVisible: false,
            formLabelWidth: "70px",
            user: {
                username: "",
                new_password: "",
                old_password: "",
                new_password_confirmation: ""
            }
        };
    },
    methods: {
        handleCommand(command) {
            if (command === "logout") {
                this.$confirm("退出登录，是否继续？", "提示", {
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    type: "warning"
                })
                    .then(() => {
                        this.$store.dispatch("logout").then(() => {
                            location.reload();
                        });
                    })
                    .catch(() => {});
            }
            if (command === "passwordReset") {
                this.dialogFormVisible = true;
            }
        },
        onSubmit() {
            reset(this.user).then(() => {
                this.dialogFormVisible = false;
                this.$notify({
                    title: "成功",
                    message: "修改成功",
                    type: "success",
                    duration: 2000
                });
            });
        }
    }
};
</script>

<style lang="less" scoped>
@import "./AppHeader.less";
</style>
