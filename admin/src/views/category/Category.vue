<template>
  <div class="category-container">
    <div class="menus-bar">
      <el-button 
        type="primary" 
        icon="el-icon-edit" 
        size="mini" 
        @click="openFormDialog"/>
    </div>
    <el-table 
      v-loading="loading" 
      :data="categories" 
      stripe 
      style="width: 100%">
      <el-table-column 
        prop="id" 
        label="ID" 
        width="100"/>
      <el-table-column 
        prop="title" 
        align="center" 
        label="标题" 
        width="180"/>
      <el-table-column 
        prop="created_at" 
        align="center" 
        label="新增时间" 
        width="180"/>
      <el-table-column 
        prop="updated_at" 
        align="center" 
        label="修改时间" 
        width="200"/>
      <el-table-column 
        prop="updated_at" 
        align="center" 
        label="操作">
        <template slot-scope="scope">
          <el-button 
            type="text" 
            size="medium" 
            icon="el-icon-edit-outline" 
            @click="editCategory(scope.row)"/>
          <el-button 
            type="text" 
            size="medium" 
            icon="el-icon-delete" 
            style="color: #f56c6c;" 
            @click="deleteCategory(scope)"/>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog 
      :title="dialogTitle[dialogStatus]" 
      :visible.sync="dialogFormVisible" 
      width="500px">
      <el-form 
        :model="category" 
        label-position="left" 
        label-width="50px" 
        style="width: 400px; margin-left: 20px;">
        <el-form-item 
          label="名称" 
          size="medium">
          <el-input 
            v-model="category.title" 
            auto-complete="off"/>
        </el-form-item>
      </el-form>
      <div slot="footer">
        <el-button 
          @click="dialogFormVisible = false" 
          size="small">取 消</el-button>
        <el-button 
          v-if="dialogStatus==='create'" 
          type="primary" 
          @click="createCategory" 
          size="small">确 定</el-button>
        <el-button 
          v-else 
          type="primary" 
          @click="updateCategory" 
          size="small">确 定</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import {
    getCategories,
    storeCategory,
    updateCategory,
    deleteCategory
} from "@/api/category";
export default {
    name: "Category",
    data() {
        return {
            categories: [],
            loading: true,
            dialogTitle: {
                create: "新增分类",
                edit: "修改分类"
            },
            dialogStatus: "create",
            category: {
                id: 0,
                title: ""
            },
            dialogFormVisible: false
        };
    },
    methods: {
        /* 获取分类 */
        getCategories() {
            getCategories().then(response => {
                this.loading = false;
                this.categories = response.data.data;
            });
        },
        /* 打开 dialog */
        openFormDialog() {
            this.category.title = "";
            this.dialogFormVisible = true;
            this.dialogStatus = "create";
            this.$nextTick(() => {});
        },
        /* 新增 Category */
        createCategory() {
            let formData = {
                title: this.category.title
            };
            storeCategory(formData).then(() => {
                this.dialogFormVisible = false;
                this.getCategories();
                this.$notify({
                    title: "成功",
                    message: "分类添加成功",
                    type: "success",
                    duration: 2000
                });
            });
        },
        /* 修改 Category */
        editCategory(category) {
            this.category.title = category.title;
            this.category.id = category.id;
            this.dialogStatus = "edit";
            this.dialogFormVisible = true;
        },
        updateCategory() {
            let formData = {
                title: this.category.title
            };
            updateCategory(formData, this.category.id).then(() => {
                for (let category of this.categories) {
                    if (category.id === this.category.id) {
                        category.title = this.category.title;
                        break;
                    }
                }
                this.dialogFormVisible = false;
                this.$notify({
                    title: "成功",
                    message: "分类修改成功",
                    type: "success",
                    duration: 2000
                });
            });
        },
        /* 删除 Category */
        deleteCategory(scope) {
            this.$confirm("是否删除?", "提示", {
                confirmButtonText: "确定",
                cancelButtonText: "取消",
                type: "warning"
            })
                .then(() => {
                    deleteCategory(scope.row.id).then(response => {
                        this.categories.splice(scope.$index, 1);
                        this.$message.success(response.data.message);
                    });
                })
                .catch(() => {});
        }
    },
    mounted() {
        this.getCategories();
    }
};
</script>

<style lang="less" scoped>
@import "./Category.less";
</style>
