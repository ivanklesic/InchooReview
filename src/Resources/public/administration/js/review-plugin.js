(this.webpackJsonp=this.webpackJsonp||[]).push([["review-plugin"],{"53gB":function(e){e.exports=JSON.parse("{}")},B1bj:function(e,t){e.exports='{% block swag_bundle_list %}\n    <sw-page class="swag-bundle-list">\n        <template slot="content">\n            {% block swag_bundle_list_content %}\n                <sw-entity-listing\n                        v-if="reviews"\n                        :items="reviews"\n                        :repository="repository"\n                        :showSelection="false"\n                        :columns="columns"\n                        detailRoute="inchoo.review.detail">\n                </sw-entity-listing>\n            {% endblock %}\n        </template>\n    </sw-page>\n{% endblock %}'},lP8p:function(e){e.exports=JSON.parse('{"inchoo-review":{"general":{"mainMenuItemGeneral":"Review","descriptionTextModule":"Manage reviews here"},"list":{}}}')},s24Y:function(e,t,i){"use strict";i.r(t);var n=i("53gB"),o=i("lP8p"),r=i("B1bj"),s=i.n(r);const a=Shopware.Data.Criteria;Shopware.Component.register("swag-bundle-list",{template:s.a,metaInfo(){return{title:this.$createTitle()}},data:()=>({repository:null,reviews:null}),created(){this.repository=this.repositoryFactory.create("inchoo_review"),this.repository.search(new a,Shopware.Context.api).then(e=>{this.reviews=e})},inject:["repositoryFactory"],computed:{columns(){return[{property:"title",dataIndex:"title",label:this.$tc("swag-bundle.list.columnName"),routerLink:"inchoo.review.detail",inlineEdit:"string",allowResize:!0,primary:!0}]}}}),Shopware.Module.register("inchoo-review",{color:"#ff3d58",icon:"default-shopping-paper-bag-product",title:"inchoo-review.general.mainMenuItemGeneral",description:"inchoo-review.general.descriptionTextModule",name:"Inchoo Review plugin",type:"plugin",snippets:{"de-DE":n,"en-GB":o},routes:{list:{component:"inchoo-review-list",path:"list"},detail:{component:"inchoo-review-details",path:"detail/:id",meta:{parentPath:"inchoo.review.list"}},delete:{component:"swag-bundle-delete",path:"delete",meta:{parentPath:"inchoo.review.list"}}},navigation:[{label:"inchoo-review.general.mainMenuItemGeneral",color:"#ff3d58",path:"inchoo.review.list",icon:"default-shopping-paper-bag-product",position:100}]})}},[["s24Y","runtime"]]]);