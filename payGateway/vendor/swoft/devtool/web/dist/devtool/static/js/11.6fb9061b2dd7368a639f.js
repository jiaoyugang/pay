webpackJsonp([11],{"3eKX":function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var s=n("9dsW"),a=n("ZXMi"),i={name:"http-middleware",components:{SimpleTable:s.a},data:function(){return{middles:[]}},created:function(){this.fetchList()},mounted:function(){},computed:{},methods:{fetchList:function(){var e=this;Object(a.i)().then(function(t){var n=t.data;console.log(n),e.middles=n})}}},r={render:function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("v-subheader",[n("h1",[e._v(e._s(e.$t(this.$route.name)))])]),e._v(" "),n("simple-table",{staticClass:"table-bordered"},[n("template",{slot:"header"},[n("th",[e._v(" "+e._s(e.$t("App.number"))+" ")]),e._v(" "),n("th",[e._v(" "+e._s(e.$t("App.middlewareClass")))])]),e._v(" "),e._l(e.middles,function(t,s){return n("tr",{key:s},[n("td",[e._v(e._s(s))]),e._v(" "),n("td",[n("span",{staticClass:"el-tag"},[e._v(e._s(t))])])])})],2)],1)},staticRenderFns:[]};var d=n("E9e/")(i,r,!1,function(e){n("rKMD")},"data-v-7c4a9fe6",null);t.default=d.exports},rKMD:function(e,t){}});
//# sourceMappingURL=11.6fb9061b2dd7368a639f.js.map