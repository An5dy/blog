<template>
  <el-form 
    label-position="right" 
    label-width="80px" 
    :model="about">
    <el-form-item label="标题">
      <el-input 
        v-model="about.title" 
        size="small" 
        style="width: 450px" />
    </el-form-item>
    <el-form-item label="正文">
      <mavon-editor 
        style="height: 600px;" 
        ref='md' 
        code-style="googlecode" 
        v-model="about.markdown" 
        @imgAdd="imgAdd"
        :toolbars="toolbars" />
    </el-form-item>
    <el-form-item>
      <el-button 
        @click="onSubmit" 
        size="small" 
        type="primary" 
        :loading="loading" 
        v-if="about.id === 0">确认发布</el-button>
      <el-button 
        @click="onUpdate" 
        size="small" 
        type="primary" 
        :loading="loading" 
        v-else>确认修改</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import { mavonEditor } from "mavon-editor";
import "mavon-editor/dist/css/index.css";
import { showAbout, storeAbout, updateAbout } from "@/api/about";
import { imageUpload } from "@/api/upload";
export default {
    name: "About",
    components: {
        mavonEditor
    },
    data() {
        return {
            loading: false,
            about: {
                id: 0,
                title: "",
                markdown: ""
            },
            toolbars: {
                bold: true, // 粗体
                italic: true, // 斜体
                header: true, // 标题
                underline: true, // 下划线
                strikethrough: true, // 中划线
                mark: true, // 标记
                superscript: true, // 上角标
                subscript: true, // 下角标
                quote: true, // 引用
                ol: true, // 有序列表
                ul: true, // 无序列表
                link: true, // 链接
                imagelink: true, // 图片链接
                code: true, // code
                table: true, // 表格
                fullscreen: true, // 全屏编辑
                readmodel: true, // 沉浸式阅读
                htmlcode: true, // 展示html源码
                help: true, // 帮助
                /* 1.3.5 */
                undo: true, // 上一步
                redo: true, // 下一步
                trash: true, // 清空
                save: true, // 保存（触发events中的save事件）
                /* 1.4.2 */
                navigation: true, // 导航目录
                /* 2.1.8 */
                alignleft: true, // 左对齐
                aligncenter: true, // 居中
                alignright: true, // 右对齐
                /* 2.2.1 */
                subfield: true, // 单双栏模式
                preview: true // 预览
            }
        };
    },
    methods: {
        /**
         * 图片上传
         */
        imgAdd(pos, $file) {
            let formData = new FormData();
            formData.append("image", $file);
            imageUpload(formData).then(response => {
                if (response.data.code === "2000") {
                    this.$refs.md.$img2Url(pos, response.data.data.basePath);
                }
            });
        },
        onSubmit() {
            storeAbout(this.about).then(() => {
                this.$notify({
                    title: "成功",
                    message: "添加成功",
                    type: "success",
                    duration: 2000
                });
            });
        },
        onUpdate() {
            updateAbout(this.about.id, this.about).then(() => {
                this.$notify({
                    title: "成功",
                    message: "修改成功",
                    type: "success",
                    duration: 2000
                });
            });
        },
        /**
         * 获取关于
         */
        getAbout() {
            showAbout().then(response => {
                if (response.data.data.id > 0) {
                    this.about = response.data.data;
                }
            });
        }
    },
    mounted() {
        this.getAbout();
    }
};
</script>

<style lang="less" scoped>
@import "./About.less";
</style>
