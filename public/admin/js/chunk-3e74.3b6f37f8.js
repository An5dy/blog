(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-3e74"],{"46db":function(t,e,a){},"9a16":function(t,e,a){"use strict";var o=a("46db"),n=a.n(o);n.a},ef4c:function(t,e,a){"use strict";a.r(e);var o=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-form",{attrs:{"label-position":"right","label-width":"80px",model:t.about}},[a("el-form-item",{attrs:{label:"标题"}},[a("el-input",{staticStyle:{width:"450px"},attrs:{size:"small"},model:{value:t.about.title,callback:function(e){t.$set(t.about,"title",e)},expression:"about.title"}})],1),a("el-form-item",{attrs:{label:"正文"}},[a("mavon-editor",{ref:"md",staticStyle:{height:"600px"},attrs:{"code-style":"googlecode",toolbars:t.toolbars},on:{imgAdd:t.imgAdd},model:{value:t.about.markdown,callback:function(e){t.$set(t.about,"markdown",e)},expression:"about.markdown"}})],1),a("el-form-item",[0===t.about.id?a("el-button",{attrs:{size:"small",type:"primary",loading:t.loading},on:{click:t.onSubmit}},[t._v("确认发布")]):a("el-button",{attrs:{size:"small",type:"primary",loading:t.loading},on:{click:t.onUpdate}},[t._v("确认修改")])],1)],1)},n=[],i=a("b2d8"),l=(a("64e1"),a("b775"));function u(){return Object(l["a"])({url:"/abouts",method:"get"})}function r(t){return Object(l["a"])({url:"/abouts",method:"post",data:t})}function s(t,e){return e["_method"]="PUT",Object(l["a"])({url:"/abouts/"+t,method:"post",data:e})}var d=a("91b6"),c={name:"About",components:{mavonEditor:i["mavonEditor"]},data:function(){return{loading:!1,about:{id:0,title:"",markdown:""},toolbars:{bold:!0,italic:!0,header:!0,underline:!0,strikethrough:!0,mark:!0,superscript:!0,subscript:!0,quote:!0,ol:!0,ul:!0,link:!0,imagelink:!0,code:!0,table:!0,fullscreen:!0,readmodel:!0,htmlcode:!0,help:!0,undo:!0,redo:!0,trash:!0,save:!0,navigation:!0,alignleft:!0,aligncenter:!0,alignright:!0,subfield:!0,preview:!0}}},methods:{imgAdd:function(t,e){var a=this,o=new FormData;o.append("image",e),Object(d["a"])(o).then(function(e){"2000"===e.data.code&&a.$refs.md.$img2Url(t,e.data.data.basePath)})},onSubmit:function(){var t=this;r(this.about).then(function(){t.$notify({title:"成功",message:"添加成功",type:"success",duration:2e3})})},onUpdate:function(){var t=this;s(this.about.id,this.about).then(function(){t.$notify({title:"成功",message:"修改成功",type:"success",duration:2e3})})},getAbout:function(){var t=this;u().then(function(e){e.data.data.id>0&&(t.about=e.data.data)})}},mounted:function(){this.getAbout()}},b=c,m=(a("9a16"),a("2877")),f=Object(m["a"])(b,o,n,!1,null,"96bbcd7c",null);f.options.__file="About.vue";e["default"]=f.exports}}]);
//# sourceMappingURL=chunk-3e74.3b6f37f8.js.map