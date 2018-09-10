module.exports = {
  baseUrl: undefined,
  outputDir: "admin",
  assetsDir: "admin",
  runtimeCompiler: undefined,
  productionSourceMap: undefined,
  parallel: undefined,
  css: undefined,
  lintOnSave: undefined,
  devServer: {
    proxy: {
      "/api": {
        target: "http://blog.it"
      }
    }
  }
};
