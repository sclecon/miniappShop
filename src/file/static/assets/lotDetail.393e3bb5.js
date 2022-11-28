import{_ as I}from"./LotILayout.dba08459.js";import{d as S,r as y,a as V,o as N,b as d,c as l,e as i,f as _,w as p,F as v,g as f,h as e,t as s,i as z,q as M,v as H,s as P,j as k,u as $,k as O,l as B,p as U,m as G,_ as J}from"./index.a9eb44ad.js";import{L as K,c as Q,d as W,a as X,P as Y,e as Z}from"./home.6cdcc8a6.js";import"./request.e88f5894.js";const n=h=>(U("data-v-66475662"),h=h(),G(),h),ee=["src"],te={class:"synopsis flex-start-start"},ne=n(()=>e("div",{class:"user-image"},[e("img",{src:"https://fastly.jsdelivr.net/npm/@vant/assets/apple-3.jpeg",alt:""})],-1)),se={class:"synopsis-info"},ae=n(()=>e("span",null,"\u4F5C\u54C1\u63CF\u8FF0\uFF1A",-1)),oe={class:"outside flex-center-between"},le={class:"outside-left"},ie=n(()=>e("i",{class:"iconfont icon-naozhong"},null,-1)),ue={class:"outside-right flex-center-center"},re=n(()=>e("i",{class:"iconfont icon-guanzhu"},null,-1)),ce=n(()=>e("i",{class:"iconfont icon-aixin"},null,-1)),de=n(()=>e("i",{class:"iconfont icon-fenxiang"},null,-1)),_e={class:"user-wx flex-center"},pe=["src"],ve={class:"count-down flex-center"},he=n(()=>e("div",{class:"hot-view"},"\u70ED\u62CD\u4E2D",-1)),me={class:"hot-view-time"},De={class:"record-view"},fe={class:"flex-center-warp"},we=n(()=>e("div",null,"\u8D77",-1)),Fe=n(()=>e("div",null,"\u52A0",-1)),xe=n(()=>e("div",null,"\u4FDD",-1)),ge=n(()=>e("div",null,"\u5EF6",-1)),Ae=n(()=>e("div",null,"\u4E00\u53E3\u4EF7",-1)),ye=n(()=>e("div",null,"\u90AE",-1)),Be=n(()=>e("div",null,"\u4F63",-1)),ke=n(()=>e("li",null,null,-1)),Ce={class:"bid-record"},Ee={class:"bid-record-view"},Le={class:"lot-view"},qe=k("\u6700\u65B0"),be={class:"flex-center-warp"},Re=n(()=>e("li",{class:"flex-center-center more-load"},[e("i",{class:"iconfont icon-z044"}),e("span",null,"\u52A0\u8F7D\u66F4\u591A")],-1)),Te=k("\u6469\u8BD8\u827A\u672F\u63D0\u4F9B"),je=n(()=>e("div",{class:"wrapper-header"},"\u51FA\u4EF7",-1)),Ie={class:"wrapper-content flex-center-center"},Se=n(()=>e("span",null,"\xA5",-1)),Ve=S({__name:"lotDetail",setup(h){$();const C=O(),r=y(!1),m=y(null),t=V({renderData:{},BoutiqueData:[],BiddingData:[],LikeRecordData:[]}),{auction_id:c}=C.query,E=()=>K({auction_id:c}).then(()=>(x(),F())),F=async()=>t.LikeRecordData=(await Q({auction_id:c})).list,x=async()=>{const D=await W({auction_id:c}),o=new Date(D.start_time*1e3).getTime(),w=new Date(D.end_time*1e3).getTime();t.renderData={...D,time:w-o},F()},L=async()=>{t.BoutiqueData=(await X()).list},q=async()=>{await Y({auction_id:c,join_price:m.value}),await g(),r.value=!r.value,m.value=null},g=async()=>{t.BiddingData=(await Z({auction_id:c})).list};return N(()=>{L(),x(),g()}),(D,o)=>{const w=d("van-swipe-item"),b=d("van-swipe"),R=d("van-count-down"),A=d("van-divider"),T=I,j=d("van-overlay");return l(),i("div",null,[_(b,{class:"works-atlas",autoplay:3e3,"indicator-color":"white"},{default:p(()=>[(l(!0),i(v,null,f(t.renderData.images,(a,u)=>(l(),B(w,{key:u},{default:p(()=>[e("img",{src:a.url,alt:""},null,8,ee)]),_:2},1024))),128))]),_:1}),e("div",te,[ne,e("div",se,[e("h3",null,s(t.renderData.painter),1),e("p",null,"\u4F5C\u54C1\u89C4\u683C\uFF1A"+s(t.renderData.specification),1),e("div",null,[ae,e("span",null,s(t.renderData.intro),1)])])]),e("div",oe,[e("div",le,[ie,e("span",null,s(t.renderData.end_time_str),1)]),e("div",ue,[e("div",null,[re,e("span",null,s(t.renderData.views),1)]),e("div",{onClick:E},[ce,e("span",null,s(t.renderData.star),1)]),e("div",null,[de,e("span",null,s(t.renderData.share),1)])])]),t.renderData.status===1?(l(),i(v,{key:0},[e("div",_e,[(l(!0),i(v,null,f(t.LikeRecordData,(a,u)=>(l(),i("img",{key:u,src:a.avatar,alt:""},null,8,pe))),128))]),e("div",ve,[he,e("span",me,[_(R,{time:t.renderData.time,format:"DD \u5929 HH \u65F6 mm \u5206 ss \u79D2"},null,8,["time"])])]),e("div",De,[e("div",{class:"record-offer flex-center-center",onClick:o[0]||(o[0]=a=>r.value=!r.value)}," \u51FA\u4EF7 "),e("ul",fe,[e("li",null,[we,e("span",null,"\xA5 "+s(t.renderData.start_price),1)]),e("li",null,[Fe,e("span",null,"\xA5 "+s(t.renderData.append_price),1)]),e("li",null,[xe,e("span",null,"\xA5 "+s(t.renderData.guaranteed_price),1)]),e("li",null,[ge,e("span",null,s(t.renderData.delay_str),1)]),e("li",null,[Ae,e("span",null,"\xA5 "+s(t.renderData.buy_now_price),1)]),e("li",null,[ye,e("span",null,s(t.renderData.postage_str),1)]),e("li",null,[Be,e("span",null,s(t.renderData.commission_str),1)]),ke])]),e("div",Ce,[e("p",null,"\u51FA\u4EF7\u8BB0\u5F55("+s(t.BiddingData.length)+")",1),e("ul",Ee,[(l(!0),i(v,null,f(t.BiddingData,(a,u)=>(l(),i("li",{class:"flex-center-between",key:u},[e("span",null,s(a.user_id),1),e("span",null,"\xA5 "+s(a.join_price),1)]))),128))])])],64)):z("",!0),e("div",Le,[_(A,null,{default:p(()=>[qe]),_:1}),e("ul",be,[(l(!0),i(v,null,f(t.BoutiqueData,(a,u)=>(l(),B(T,{key:u,Boutique:a},null,8,["Boutique"]))),128)),Re])]),e("footer",null,[_(A,null,{default:p(()=>[Te]),_:1})]),_(j,{show:r.value,onClick:o[3]||(o[3]=a=>r.value=!1)},{default:p(()=>[e("div",{class:"wrapper",onClick:o[2]||(o[2]=P(()=>{},["stop"]))},[je,e("div",Ie,[Se,M(e("input",{type:"number",placeholder:"0.01","onUpdate:modelValue":o[1]||(o[1]=a=>m.value=a)},null,512),[[H,m.value]])]),e("div",{class:"record-offer flex-center-center",onClick:q}," \u786E\u5B9A\u51FA\u4EF7 ")])]),_:1},8,["show"])])}}});const Pe=J(Ve,[["__scopeId","data-v-66475662"]]);export{Pe as default};