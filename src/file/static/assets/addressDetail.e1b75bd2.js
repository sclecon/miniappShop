import{d as E,r as F,x as B,o as D,c as d,e as n,h as a,F as m,g as C,u as x,k as b,t,s as g,i as w,_ as S}from"./index.a9eb44ad.js";import{b as N,c as q}from"./my.7c278380.js";import"./request.e88f5894.js";const L=["onClick"],M={class:"address-info"},R=["onClick"],V=E({__name:"addressDetail",setup($){const r=x(),c=b(),i=F([]);B(c,s=>s.name==="addressDetail"&&u());const u=async()=>i.value=(await N()).list,p=async s=>{let{address_id:_,area:e,city:l,detail:o,name:k,phone:v,province:y}=s;q({address_id:_,area:e,city:l,detail:o,name:k,phone:v,province:y,default:1}).then(u).then(h)},h=()=>{let{query:{type:s}}=c;switch(s){case"order":r.back();break}},f=s=>{r.push({name:"addressAdd",query:{id:s.address_id,detail:JSON.stringify(s)}})},A=()=>r.push({name:"addressAdd"});return D(()=>{u()}),(s,_)=>(d(),n("div",null,[a("ul",null,[(d(!0),n(m,null,C(i.value,(e,l)=>(d(),n("li",{class:"address-item flex-center-between",key:l,onClick:o=>f(e)},[a("div",M,[a("p",null,"\u6536\u4EF6\u4EBA\uFF1A"+t(e.name),1),a("p",null,"\u7535\u8BDD\u53F7\u7801\uFF1A"+t(e.phone),1),a("p",null," \u6240\u5C5E\u8857\u9053\uFF1A"+t(e.province)+"-"+t(e.city)+"-"+t(e.area.split("|")[0]),1),a("p",null,"\u8BE6\u7EC6\u5730\u5740\uFF1A"+t(e.detail),1)]),e.default?w("",!0):(d(),n("div",{key:0,class:"default",onClick:g(o=>p(e),["stop"])}," \u8BBE\u4E3A\u9ED8\u8BA4 ",8,R))],8,L))),128))]),a("footer",{class:"flex-center-center"},[a("div",{class:"default",onClick:A},"\u65B0\u589E\u5730\u5740")])]))}});const j=S(V,[["__scopeId","data-v-c557022b"]]);export{j as default};