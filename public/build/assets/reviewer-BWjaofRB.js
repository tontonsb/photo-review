import{m as s,d as l,a as r,b as c}from"./displayImageWithScale-GVUucSyj.js";import"./XYZ-sykNy2Li.js";const m=new Date,a=document.querySelector("form"),w=a.querySelector("[name=reviewing_duration_ms]");a.addEventListener("submit",()=>w.value=new Date-m);function p(t,n,i){const e=document.querySelector(t);e.querySelectorAll(".js-close").forEach(o=>o.addEventListener("click",d=>e.close())),document.querySelectorAll(n).forEach(o=>o.addEventListener("click",d=>e.showModal())),i&&e.showModal()}window.bootInfobox=p;window.makeMapWith=s;window.displayImage=l;window.displayImageOnMap=r;window.displayImageWithScale=c;