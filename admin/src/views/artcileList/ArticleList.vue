<template>
  <div class="artcile-container">
    <el-table 
      v-loading="loading" 
      :data="articles" 
      stripe 
      style="width: 100%">
      <el-table-column 
        prop="id" 
        label="ID" 
        align="center" 
        width="100" />
      <el-table-column 
        prop="category.title" 
        label="分类" 
        align="center" 
        width="100" />
      <el-table-column 
        label="标签" 
        prop="tags" 
        align="center"
        width="300">
        <template slot-scope="scope">
          <el-tag 
            v-for="(tag, index) in scope.row.tags" 
            :key="index" 
            closable 
            size="mini" 
            style="margin-right: 5px"
            @close="handleTagClose(index, scope.row.tags)" 
            type="primary">{{ tag.title }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column 
        prop="title" 
        align="center" 
        label="标题" 
        width="200"/>
      <el-table-column 
        prop="created_at" 
        align="center" 
        width="200" 
        label="发布时间" />
      <el-table-column 
        label="操作" 
        align="center">
        <template slot-scope="scope">
          <el-button 
            type="text" 
            size="medium" 
            icon="el-icon-edit-outline" 
            @click="editArticle(scope.row)"
          />
          <el-button 
            type="text" 
            size="medium" 
            icon="el-icon-delete" 
            style="color: #f56c6c;" 
            @click="deleteArticle(scope)"
          />
        </template>
      </el-table-column>
    </el-table>
    <div class="pagination">
      <el-pagination
        background
        layout="prev, pager, next"
        @current-change="handleCurrentChange"
        :current-page.sync="page"
        :page-size="pageSize"
        :total="total"/>
    </div>
  </div>
</template>

<script>
import { getArticles, deleteArticle } from "@/api/article";
import { deleteTag } from "@/api/tag";
export default {
  name: "ArticleList",
  data() {
    return {
      loading: true,
      articles: [],
      page: 1,
      total: 0,
      pageSize: 0
    };
  },
  methods: {
    /**
     * 获取文章列表
     */
    getArticles() {
      let formData = {
        page: this.page
      };
      getArticles(formData).then(response => {
        this.loading = false;
        this.articles = response.data.data;
        this.page = response.data.meta.current_page;
        this.total = response.data.meta.total;
        this.pageSize = response.data.meta.per_page;
      });
    },
    /**
     * 分页
     */
    handleCurrentChange(val) {
      this.page = val;
      this.getArticles();
    },
    /**
     * 删除文章
     */
    deleteArticle(scope) {
      this.$confirm("是否删除?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          deleteArticle(scope.row.id).then(response => {
            this.getArticles();
            this.$message.success(response.data.message);
          });
        })
        .catch(() => {});
    },
    editArticle(article) {
      this.$router.push("/articles/" + article.id);
    },
    /**
     * 删除标签
     */
    handleTagClose(index, tags) {
      deleteTag(tags[index].id).then(() => {
        tags.splice(index, 1);
        this.$notify({
          title: "成功",
          message: "标签删除成功",
          type: "success",
          duration: 2000
        });
      });
    }
  },
  mounted() {
    this.getArticles();
  }
};
</script>

<style lang="less" scoped>
@import "./ArticleList.less";
</style>
