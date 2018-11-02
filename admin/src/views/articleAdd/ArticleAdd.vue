<template>
  <el-form 
    label-position="right" 
    label-width="80px" 
    :model="article">
    <el-form-item label="标题">
      <el-input
        v-model="article.title"
        size="small"
        style="width: 450px"
      />
    </el-form-item>
    <el-form-item label="封面">
      <el-upload
        ref="upload"
        class="avatar-uploader"
        action="/api/admin/images"
        name="image"
        :headers="uploadHeaders"
        :show-file-list="false"
        :auto-upload="false"
        :on-success="handleUploadSuccess"
        :on-change="onChange"
        :before-upload="beforeUpload">
        <img 
          v-if="article.cover_img" 
          :src="article.cover_img" 
          class="avatar">
        <i 
          v-else 
          class="el-icon-plus avatar-uploader-icon"/>
      </el-upload>
    </el-form-item>
    <el-form-item label="正文">
      <mavon-editor
        style="height: 600px;"
        ref='md'
        code-style="googlecode"
        v-model="article.markdown"
        @imgAdd="imgAdd"
        :toolbars="toolbars"/>
    </el-form-item>
    <el-form-item label="标签">
      <el-tag
        style="margin-right: 10px"
        size="normal"
        v-for="tag in article.tags"
        :key="tag"
        closable
        :disable-transitions="false"
        @close="handleClose(tag)">
        {{ tag }}
      </el-tag>
      <el-input
        class="input-new-tag"
        v-if="inputVisible"
        v-model.trim="inputValue"
        ref="saveTagInput"
        size="small"
        @keyup.enter.native="handleInputConfirm"
        @blur="handleInputConfirm"
      />
      <el-button
        v-else
        class="button-new-tag"
        size="small"
        @click="showInput">+ 新增标签</el-button>
    </el-form-item>
    <el-form-item label="分类">
      <el-select
        v-model="article.category_id"
        size="small"
        placeholder="请选择分类">
        <el-option
          v-for="category in categories"
          :label="category.title"
          :value="category.id"
          :key="category.id"/>
      </el-select>
    </el-form-item>
    <el-form-item>
      <el-button
        @click="onSubmit"
        size="small"
        type="primary"
        :loading="loading"
        v-if="article.id === 0">确认发布</el-button>
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
import { imageUpload } from "@/api/upload";
import { getCategories } from "@/api/category";
import { storeArticle, showArtcile, updateArticle } from "@/api/article";
import { getAccessToken } from "@/utils/auth";
export default {
    name: "ArticleAdd",
    components: {
        mavonEditor
    },
    data() {
        return {
            inputVisible: false,
            inputValue: "",
            value: "",
            imageUrl: "",
            article: {
                title: "",
                category_id: "",
                markdown: "",
                tags: [],
                cover_img: "",
                id: 0,
                image: {}
            },
            loading: false,
            categories: [],
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
            },
            editor: {},
            uploadHeaders: {}
        };
    },
    methods: {
        /**
         * 关闭标签
         */
        handleClose(tag) {
            this.article.tags.splice(this.article.tags.indexOf(tag), 1);
        },
        /**
         * 显示标签
         */
        showInput() {
            if (this.article.tags.length >= 5) {
                this.$message.warning("标签最多添加5个");
                return;
            }
            this.inputVisible = true;
            this.$nextTick(() => {
                this.$refs.saveTagInput.$refs.input.focus();
            });
        },
        /**
         * 添加标签
         */
        handleInputConfirm() {
            if (this.article.tags.includes(this.inputValue)) {
                this.$message.warning("当前标签已添加");
                return;
            }
            let inputValue = this.inputValue;
            if (inputValue) {
                this.article.tags.push(inputValue);
            }
            this.inputVisible = false;
            this.inputValue = "";
        },
        /**
         * markdown 编辑器图片上传
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
        /**
         * 获取分类
         */
        getCategories() {
            getCategories().then(response => {
                this.categories = response.data.data;
            });
        },
        /**
         * 提交
         */
        onSubmit() {
            var formData = new FormData();
            formData.append("title", this.article.title);
            formData.append("category_id", this.article.category_id);
            formData.append("markdown", this.article.markdown);
            formData.append("tags", this.article.tags);
            formData.append("image", this.article.image);
            storeArticle(formData).then(() => {
                this.$notify({
                    title: "成功",
                    message: "文章添加成功",
                    type: "success",
                    duration: 2000
                });
                this.$router.push("/articles");
            });
        },
        /**
         * 修改
         */
        onUpdate() {
            var formData = new FormData();
            formData.append("title", this.article.title);
            formData.append("category_id", this.article.category_id);
            formData.append("markdown", this.article.markdown);
            formData.append("tags", this.article.tags);
            if (JSON.stringify(this.article.image) !== "{}") {
                formData.append("image", this.article.image);
            }
            updateArticle(this.article.id, formData).then(() => {
                this.$notify({
                    title: "成功",
                    message: "文章修改成功",
                    type: "success",
                    duration: 2000
                });
                this.$router.push("/articles");
            });
        },
        /**
         * 获取文章详情
         */
        getArticle() {
            if (this.$route.params.id > 0) {
                showArtcile(this.$route.params.id).then(response => {
                    this.article = response.data.data;
                    this.article.category_id = response.data.data.category_id;
                    for (let key in this.article.tags) {
                        this.article.tags[key] = this.article.tags[key].title;
                    }
                    this.getCategories();
                });
            } else {
                this.getCategories();
            }
        },
        /**
         * 封面图片上传前钩子
         */
        beforeUpload(file) {
            const isLt2M = file.size / 1024 / 1024 < 4;

            if (!isLt2M) {
                this.$message.error("上传头像图片大小不能超过 4MB!");
            }

            return isLt2M;
        },
        /**
         * 更换图片事件
         */
        onChange(file) {
            this.article.image = file.raw;
            this.article.cover_img = URL.createObjectURL(this.article.image);
        },
        /**
         * 封面图片上传成功
         */
        // handleUploadSuccess(response, file) {
        // this.article.cover_img = file.raw
        // console.log(file)
        // if (response.code === "2000") {
        //     this.article.cover_img = response.data.basePath;
        // } else {
        //     this.$message.error("封面图片上传失败。");
        // }
        // },
        /**
         * 文件上传请求头
         */
        setUploadHeaders() {
            this.uploadHeaders = {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Authorization: "Bearer " + getAccessToken()
            };
        }
    },
    watch: {
        $route() {
            this.article = {};
        }
    },
    mounted() {
        this.getArticle();
        this.setUploadHeaders();
    }
};
</script>

<style lang="less" scoped>
@import "./ArticleAdd.less";
</style>
