import{_ as E}from"./MarkeLayout.88951292.js";import{d as I,x as N,a as V,r as j,o as M,b as h,c as o,e as n,f as m,w as _,F as v,g as f,h as e,t as c,i as D,j as k,k as w,y as O,l as S,p as q,m as L,_ as R}from"./index.a9eb44ad.js";import{a as z,S as G}from"./marke.8d60d36d.js";import"./request.e88f5894.js";const p=r=>(q("data-v-bcd22723"),r=r(),L(),r),T={key:0},$=["src"],H={class:"writing-info"},J=p(()=>e("div",{class:"flex-center"},[e("div",{class:"hot-view"},"\u70ED\u5356\u4E2D")],-1)),K={class:"writing-rules"},P={class:"flex-start-start"},Q=p(()=>e("span",{class:"lable-view"},"\u63CF\u8FF0\uFF1A",-1)),U={class:"poster-view"},W={key:0,class:"lot-view"},X=k("\u63A8\u8350"),Y={class:"flex-center-warp"},Z=p(()=>e("i",{class:"iconfont icon-z044"},null,-1)),ee=p(()=>e("span",null,"\u52A0\u8F7D\u66F4\u591A",-1)),te=[Z,ee],oe=k("\u6469\u8BD8\u827A\u672F\u63D0\u4F9B"),ae=I({__name:"commodityDetails",setup(r){const x=w(),{query:{shop_id:d}}=w();N(x,()=>location.reload());const t=V({ShopData:[],ShopDataConfig:{params:{page:1,number:10},ismove:!0}}),a=j(null),C=async()=>{let l=await z({shop_id:d});a.value=l},y=async()=>{let l=(await G({...t.ShopDataConfig.params,recommend:1})).list.filter(u=>~~u.shop_id!==~~d);t.ShopDataConfig.params.page++,t.ShopDataConfig.ismove=l.length===t.ShopDataConfig.params.number,t.ShopData.push(...l)},F=()=>O.push({name:"placeOrder",query:{shop_id:d}});return M(()=>{y(),C()}),(l,u)=>{const b=h("van-swipe-item"),A=h("van-swipe"),g=h("van-divider"),B=E;return a.value?(o(),n("div",T,[m(A,{class:"works-atlas",autoplay:3e3,"indicator-color":"white"},{default:_(()=>[(o(!0),n(v,null,f(a.value.shop_image,(s,i)=>(o(),S(b,{key:i},{default:_(()=>[e("img",{src:s,alt:""},null,8,$)]),_:2},1024))),128))]),_:1}),e("div",H,[J,e("ul",K,[e("li",null,c(a.value.name),1),e("li",P,[e("ul",null,[(o(!0),n(v,null,f(a.value.options,(s,i)=>(o(),n("li",{key:i},c(Object.keys(s)[0])+":"+c(Object.values(s)[0]),1))),128))])]),e("li",null,[Q,e("span",null,c(a.value.intro),1)])])]),e("div",U,[e("div",{class:"poster-view-button flex-center-center",onClick:F}," \u53BB\u8D2D\u4E70 \xA5"+c(a.value.price),1)]),t.ShopData.length?(o(),n("div",W,[m(g,null,{default:_(()=>[X]),_:1}),e("ul",Y,[(o(!0),n(v,null,f(t.ShopData,(s,i)=>(o(),S(B,{key:i,info:s},null,8,["info"]))),128)),t.ShopDataConfig.ismove&&t.ShopData.length?(o(),n("li",{key:0,class:"flex-center-center more-load",onClick:u[0]||(u[0]=s=>y())},te)):D("",!0)])])):D("",!0),e("footer",null,[m(g,null,{default:_(()=>[oe]),_:1})])])):D("",!0)}}});const ce=R(ae,[["__scopeId","data-v-bcd22723"]]);export{ce as default};