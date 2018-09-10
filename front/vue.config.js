module.exports = {
  // 代理
  devServer: {
    proxy: {
      "/api": {
        target: "http://blog.it"
      }
    }
  },

  baseUrl: undefined,
  outputDir: "front",
  assetsDir: "front",
  runtimeCompiler: undefined,
  productionSourceMap: undefined,
  parallel: undefined,
  css: undefined
};
