webpackJsonp([19],{ArrO:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=a("B2YR"),s=a.n(r),n=a("h/uE"),o=a.n(n),l=a("k/aq"),i=a.n(l),c=a("/uRu"),u=a("ZXMi"),d={name:"WsRoutes",components:s()({VAlert:o.a},c,{VDataTable:i.a}),data:function(){return{search:"",rawData:[],pageOpts:[10,25,{text:"All",value:-1}],headers:[{text:this.$t("App.uriPath"),align:"left",value:"path"},{text:this.$t("App.routeHandler"),align:"left",value:"handler"}],routes:[]}},created:function(){this.fetchList()},mounted:function(){},computed:{},methods:{fetchList:function(){var e=this;Object(u.r)().then(function(t){var a=t.data;for(var r in console.log(a),e.rawData=a,a){var s={path:r};s.handler=a[r].handler,e.routes.push(s)}})}}},h={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("v-subheader",[a("h1",[e._v(e._s(e.$t(this.$route.name)))])]),e._v(" "),a("v-card",[a("v-card-title",{staticClass:"pt-1"},[a("v-spacer"),e._v(" "),a("v-text-field",{attrs:{"append-icon":"search",label:e.$t("App.search"),"single-line":"","hide-details":""},model:{value:e.search,callback:function(t){e.search=t},expression:"search"}})],1),e._v(" "),a("v-divider"),e._v(" "),a("v-data-table",{staticClass:"elevation-1",attrs:{headers:e.headers,items:e.routes,search:e.search,"rows-per-page-items":e.pageOpts,"rows-per-page-text":e.$t("App.rowsPerPage"),"disable-initial-sort":""},scopedSlots:e._u([{key:"items",fn:function(t){return[a("td",[e._v(e._s(t.item.path))]),e._v(" "),a("td",[a("span",{staticClass:"el-tag"},[e._v(e._s(t.item.handler))])])]}}])},[a("template",{slot:"no-data"},[a("v-alert",{attrs:{value:!0,color:"info",icon:"info"}},[e._v("\n          Sorry, nothing to display here :(\n        ")])],1),e._v(" "),a("v-alert",{attrs:{slot:"no-results",value:!0,color:"error",icon:"warning"},slot:"no-results"},[e._v('\n        Your search for "'+e._s(e.search)+'" found no results.\n      ')])],2)],1)],1)},staticRenderFns:[]};var v=a("E9e/")(d,h,!1,function(e){a("uFZ+")},"data-v-24f1eff8",null);t.default=v.exports},"uFZ+":function(e,t){}});
//# sourceMappingURL=19.6d9e92bc36b34464c9ec.js.map