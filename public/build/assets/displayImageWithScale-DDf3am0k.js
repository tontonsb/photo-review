import{I as V,c as te,d as B,e as me,h as pe,i as se,j as f,k as T,l as D,r as fe,m as we,E as $,u as _e,n as Ee,S as xe,o as Ie,p as J,q as ye,s as W,t as b,v as Se,B as ve,w as ne,x as Re,y as ie,L as Le,C as be,z as Q,A as ee,D as Ae,F as Me,H as Te,J as M,K as j,f as x,N as q,O as De,P as Ce,Q as re,R as ae,b as P,V as O,G as ke,M as C,T as oe,X as le,a as R,U as ce,W as Ge,g as H,Y as Fe,Z as Ne,_ as We,$ as je,a0 as ue}from"./XYZ-Dpa1tCDS.js";function U(u){return Array.isArray(u)?Math.min(...u):u}class Pe extends V{constructor(e,s,i,n,r,t,a){let l=e.getExtent();l&&e.canWrapX()&&(l=l.slice(),l[0]=-1/0,l[2]=1/0);let o=s.getExtent();o&&s.canWrapX()&&(o=o.slice(),o[0]=-1/0,o[2]=1/0);const c=o?te(i,o):i,h=B(c),d=me(e,s,h,n),g=Ee,p=new pe(e,s,c,l,d*g,n),w=p.calculateSourceExtent(),_=se(w)?null:t(w,d,r),I=_?f.IDLE:f.EMPTY,m=_?_.getPixelRatio():1;super(i,n,m,I),this.targetProj_=s,this.maxSourceExtent_=l,this.triangulation_=p,this.targetResolution_=n,this.targetExtent_=i,this.sourceImage_=_,this.sourcePixelRatio_=m,this.interpolate_=a,this.canvas_=null,this.sourceListenerKey_=null}disposeInternal(){this.state==f.LOADING&&this.unlistenSource_(),super.disposeInternal()}getImage(){return this.canvas_}getProjection(){return this.targetProj_}reproject_(){const e=this.sourceImage_.getState();if(e==f.LOADED){const s=T(this.targetExtent_)/this.targetResolution_,i=D(this.targetExtent_)/this.targetResolution_;this.canvas_=fe(s,i,this.sourcePixelRatio_,U(this.sourceImage_.getResolution()),this.maxSourceExtent_,this.targetResolution_,this.targetExtent_,this.triangulation_,[{extent:this.sourceImage_.getExtent(),image:this.sourceImage_.getImage()}],0,void 0,this.interpolate_,!0)}this.state=e,this.changed()}load(){if(this.state==f.IDLE){this.state=f.LOADING,this.changed();const e=this.sourceImage_.getState();e==f.LOADED||e==f.ERROR?this.reproject_():(this.sourceListenerKey_=we(this.sourceImage_,$.CHANGE,function(s){const i=this.sourceImage_.getState();(i==f.LOADED||i==f.ERROR)&&(this.unlistenSource_(),this.reproject_())},this),this.sourceImage_.load())}}unlistenSource_(){_e(this.sourceListenerKey_),this.sourceListenerKey_=null}}const A=4,F={IMAGELOADSTART:"imageloadstart",IMAGELOADEND:"imageloadend",IMAGELOADERROR:"imageloaderror"};class Oe extends ve{constructor(e,s){super(e),this.image=s}}class He extends xe{constructor(e){super({attributions:e.attributions,projection:e.projection,state:e.state,interpolate:e.interpolate!==void 0?e.interpolate:!0}),this.on,this.once,this.un,this.loader=e.loader||null,this.resolutions_=e.resolutions!==void 0?e.resolutions:null,this.reprojectedImage_=null,this.reprojectedRevision_=0,this.image=null,this.wantedExtent_,this.wantedResolution_,this.static_=e.loader?e.loader.length===0:!1,this.wantedProjection_=null}getResolutions(){return this.resolutions_}setResolutions(e){this.resolutions_=e}findNearestResolution(e){const s=this.getResolutions();if(s){const i=Ie(s,e,0);e=s[i]}return e}getImage(e,s,i,n){const r=this.getProjection();if(!r||!n||J(r,n))return r&&(n=r),this.getImageInternal(e,s,i,n);if(this.reprojectedImage_){if(this.reprojectedRevision_==this.getRevision()&&J(this.reprojectedImage_.getProjection(),n)&&this.reprojectedImage_.getResolution()==s&&ye(this.reprojectedImage_.getExtent(),e))return this.reprojectedImage_;this.reprojectedImage_.dispose(),this.reprojectedImage_=null}return this.reprojectedImage_=new Pe(r,n,e,s,i,(t,a,l)=>this.getImageInternal(t,a,l,r),this.getInterpolate()),this.reprojectedRevision_=this.getRevision(),this.reprojectedImage_}getImageInternal(e,s,i,n){if(this.loader){const r=Ve(e,s,i,1),t=this.findNearestResolution(s);if(this.image&&(this.static_||this.wantedProjection_===n&&(this.wantedExtent_&&W(this.wantedExtent_,r)||W(this.image.getExtent(),r))&&(this.wantedResolution_&&U(this.wantedResolution_)===t||U(this.image.getResolution())===t)))return this.image;this.wantedProjection_=n,this.wantedExtent_=r,this.wantedResolution_=t,this.image=new V(r,t,i,this.loader),this.image.addEventListener($.CHANGE,this.handleImageChange.bind(this))}return this.image}handleImageChange(e){const s=e.target;let i;switch(s.getState()){case f.LOADING:this.loading=!0,i=F.IMAGELOADSTART;break;case f.LOADED:this.loading=!1,i=F.IMAGELOADEND;break;case f.ERROR:this.loading=!1,i=F.IMAGELOADERROR;break;default:return}this.hasListener(i)&&this.dispatchEvent(new Oe(i,s))}}function Ue(u,e){u.getImage().src=e}function Ve(u,e,s,i){const n=e/s,r=B(u),t=b(T(u)/n,A),a=b(D(u)/n,A),l=b((i-1)*t/2,A),o=t+2*l,c=b((i-1)*a/2,A),h=a+2*c;return Se(r,n,0,[o,h])}function Be(u){const e=u.load||ne,s=u.imageExtent,i=new Image;return u.crossOrigin!==null&&(i.crossOrigin=u.crossOrigin),()=>e(i,u.url).then(n=>{const r=T(s)/n.width,t=D(s)/n.height;return{image:n,extent:s,resolution:r!==t?[r,t]:t,pixelRatio:1}})}class X extends He{constructor(e){const s=e.crossOrigin!==void 0?e.crossOrigin:null,i=e.imageLoadFunction!==void 0?e.imageLoadFunction:Ue;super({attributions:e.attributions,interpolate:e.interpolate,projection:Re(e.projection)}),this.url_=e.url,this.imageExtent_=e.imageExtent,this.image=null,this.image=new V(this.imageExtent_,void 0,1,Be({url:e.url,imageExtent:e.imageExtent,crossOrigin:s,load:(n,r)=>(this.image.setImage(n),i(this.image,r),ne(n))})),this.image.addEventListener($.CHANGE,this.handleImageChange.bind(this))}getImageExtent(){return this.imageExtent_}getImageInternal(e,s,i,n){return ie(e,this.image.getExtent())?this.image:null}getUrl(){return this.url_}}class $e extends Le{constructor(e){e=e||{},super(e)}}class qe extends be{constructor(e){super(e),this.image_=null}getImage(){return this.image_?this.image_.getImage():null}prepareFrame(e){const s=e.layerStatesArray[e.layerIndex],i=e.pixelRatio,n=e.viewState,r=n.resolution,t=this.getLayer().getSource(),a=e.viewHints;let l=e.extent;if(s.extent!==void 0&&(l=te(l,Q(s.extent,n.projection))),!a[ee.ANIMATING]&&!a[ee.INTERACTING]&&!se(l))if(t){const o=n.projection,c=t.getImage(l,r,i,o);c&&(this.loadImage(c)?this.image_=c:c.getState()===f.EMPTY&&(this.image_=null))}else this.image_=null;return!!this.image_}getData(e){const s=this.frameState;if(!s)return null;const i=this.getLayer(),n=Ae(s.pixelToCoordinateTransform,e.slice()),r=i.getExtent();if(r&&!Me(r,n))return null;const t=this.image_.getExtent(),a=this.image_.getImage(),l=T(t),o=Math.floor(a.width*((n[0]-t[0])/l));if(o<0||o>=a.width)return null;const c=D(t),h=Math.floor(a.height*((t[3]-n[1])/c));return h<0||h>=a.height?null:this.getImageData(a,o,h)}renderFrame(e,s){const i=this.image_,n=i.getExtent(),r=i.getResolution(),[t,a]=Array.isArray(r)?r:[r,r],l=i.getPixelRatio(),o=e.layerStatesArray[e.layerIndex],c=e.pixelRatio,h=e.viewState,d=h.center,g=h.resolution,p=c*t/(g*l),w=c*a/(g*l);this.prepareContainer(e,s);const _=this.context.canvas.width,I=this.context.canvas.height,m=this.getRenderContext(e);let E=!1,k=!0;if(o.extent){const S=Q(o.extent,h.projection);k=ie(S,e.extent),E=k&&!W(S,e.extent),E&&this.clipUnrotated(m,e,S)}const y=i.getImage(),L=Te(this.tempTransform,_/2,I/2,p,w,0,l*(n[0]-d[0])/t,l*(d[1]-n[3])/a);this.renderedResolution=a*c/l;const K=y.width*L[0],Z=y.height*L[3];if(this.getLayer().getSource().getInterpolate()||(m.imageSmoothingEnabled=!1),this.preRender(m,e),k&&K>=.5&&Z>=.5){const S=L[4],de=L[5],G=o.opacity;G!==1&&(m.save(),m.globalAlpha=G),m.drawImage(y,0,0,+y.width,+y.height,S,de,K,Z),G!==1&&m.restore()}return this.postRender(this.context,e),E&&m.restore(),m.imageSmoothingEnabled=!0,this.container}}class Y extends $e{constructor(e){super(e)}createRenderer(){return new qe(this)}getData(e){return super.getData(e)}}function Xe(u,e,s,i,n,r){const t=[e.lon,e.lat],a=new M({geometry:new j(x(t))});return a.setStyle(new q({image:new De({src:i,scale:.125,rotation:s})})),he(u,a,t,n,r)}function Ye(u,e,s,i){const n={north:parseFloat(e.north),east:parseFloat(e.east),south:parseFloat(e.south),west:parseFloat(e.west)},r=new M({geometry:new Ce([[x([n.west,n.north]),x([n.east,n.north]),x([n.east,n.south]),x([n.west,n.south]),x([n.west,n.north])]])});r.setStyle(new q({stroke:new re({color:"#b833ff",width:2}),fill:new ae({color:"#b833ff22"})}));const t=[(n.east+n.west)/2,(n.north+n.south)/2];return he(u,r,t,s,i)}function he(u,e,s,i,n){const r=new P({source:new O({format:new ke,url:i})}),t=new C({target:u,layers:[new oe({source:new le({attributions:["Powered by Esri","Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community"],url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",maxZoom:20})}),r,new P({source:new O({features:[e]})})],view:new R({center:x(s),zoom:14})});return t.on("click",function(a){const l=t.getEventPixel(a.originalEvent),o=[];t.forEachFeatureAtPixel(l,c=>{o.push({path:c.get("path"),url:c.get("url")})}),n(o)}),t.on("pointermove",function(a){if(a.dragging)return;t.getTargetElement().style.cursor="";const l=t.getEventPixel(a.originalEvent);t.forEachFeatureAtPixel(l,o=>{if(o.get("path")&&o.get("url"))return t.getTargetElement().style.cursor="pointer",!0})}),t}const Je={pin:Xe,box:Ye},N="units",ze=[1,2,5],v=25.4/.28;class ge extends ce{constructor(e){e=e||{};const s=document.createElement("div");s.style.pointerEvents="none",super({element:s,render:e.render,target:e.target}),this.on,this.once,this.un;const i=e.className!==void 0?e.className:e.bar?"ol-scale-bar":"ol-scale-line";this.innerElement_=document.createElement("div"),this.innerElement_.className=i+"-inner",this.element.className=i+" "+Ge,this.element.appendChild(this.innerElement_),this.viewState_=null,this.minWidth_=e.minWidth!==void 0?e.minWidth:64,this.maxWidth_=e.maxWidth,this.renderedVisible_=!1,this.renderedWidth_=void 0,this.renderedHTML_="",this.addChangeListener(N,this.handleUnitsChanged_),this.setUnits(e.units||"metric"),this.scaleBar_=e.bar||!1,this.scaleBarSteps_=e.steps||4,this.scaleBarText_=e.text||!1,this.dpi_=e.dpi||void 0}getUnits(){return this.get(N)}handleUnitsChanged_(){this.updateElement_()}setUnits(e){this.set(N,e)}setDpi(e){this.dpi_=e}updateElement_(){const e=this.viewState_;if(!e){this.renderedVisible_&&(this.element.style.display="none",this.renderedVisible_=!1);return}const s=e.center,i=e.projection,n=this.getUnits(),r=n=="degrees"?"degrees":"m";let t=H(i,e.resolution,s,r);const a=this.minWidth_*(this.dpi_||v)/v,l=this.maxWidth_!==void 0?this.maxWidth_*(this.dpi_||v)/v:void 0;let o=a*t,c="";if(n=="degrees"){const E=Fe.degrees;o*=E,o<E/60?(c="″",t*=3600):o<E?(c="′",t*=60):c="°"}else if(n=="imperial")o<.9144?(c="in",t/=.0254):o<1609.344?(c="ft",t/=.3048):(c="mi",t/=1609.344);else if(n=="nautical")t/=1852,c="NM";else if(n=="metric")o<1e-6?(c="nm",t*=1e9):o<.001?(c="μm",t*=1e6):o<1?(c="mm",t*=1e3):o<1e3?c="m":(c="km",t/=1e3);else if(n=="us")o<.9144?(c="in",t*=39.37):o<1609.344?(c="ft",t/=.30480061):(c="mi",t/=1609.3472);else throw new Error("Invalid units");let h=3*Math.floor(Math.log(a*t)/Math.log(10)),d,g,p,w,_,I;for(;;){p=Math.floor(h/3);const E=Math.pow(10,p);if(d=ze[(h%3+3)%3]*E,g=Math.round(d/t),isNaN(g)){this.element.style.display="none",this.renderedVisible_=!1;return}if(l!==void 0&&g>=l){d=w,g=_,p=I;break}else if(g>=a)break;w=d,_=g,I=p,++h}const m=this.scaleBar_?this.createScaleBar(g,d,c):d.toFixed(p<0?-p:0)+" "+c;this.renderedHTML_!=m&&(this.innerElement_.innerHTML=m,this.renderedHTML_=m),this.renderedWidth_!=g&&(this.innerElement_.style.width=g+"px",this.renderedWidth_=g),this.renderedVisible_||(this.element.style.display="",this.renderedVisible_=!0)}createScaleBar(e,s,i){const n=this.getScaleForResolution(),r=n<1?Math.round(1/n).toLocaleString()+" : 1":"1 : "+Math.round(n).toLocaleString(),t=this.scaleBarSteps_,a=e/t,l=[this.createMarker("absolute")];for(let c=0;c<t;++c){const h=c%2===0?"ol-scale-singlebar-odd":"ol-scale-singlebar-even";l.push(`<div><div class="ol-scale-singlebar ${h}" style="width: ${a}px;"></div>`+this.createMarker("relative")+(c%2===0||t===2?this.createStepText(c,e,!1,s,i):"")+"</div>")}return l.push(this.createStepText(t,e,!0,s,i)),(this.scaleBarText_?`<div class="ol-scale-text" style="width: ${e}px;">`+r+"</div>":"")+l.join("")}createMarker(e){return`<div class="ol-scale-step-marker" style="position: ${e}; top: ${e==="absolute"?3:-10}px;"></div>`}createStepText(e,s,i,n,r){const a=(e===0?0:Math.round(n/this.scaleBarSteps_*e*100)/100)+(e===0?"":" "+r),l=e===0?-3:s/this.scaleBarSteps_*-1,o=e===0?0:s/this.scaleBarSteps_*2;return`<div class="ol-scale-step-text" style="margin-left: ${l}px;text-align: ${e===0?"left":"center"};min-width: ${o}px;left: ${i?s+"px":"unset"};">`+a+"</div>"}getScaleForResolution(){const e=H(this.viewState_.projection,this.viewState_.resolution,this.viewState_.center,"m"),s=this.dpi_||v,i=1e3/25.4;return e*i*s}render(e){const s=e.frameState;s?this.viewState_=s.viewState:this.viewState_=null,this.updateElement_()}}function z(){const u=new O,e=new P({source:u,style:new q({image:new Ne({radius:15,fill:new ae({color:"#ff33e022"}),stroke:new re({color:"#ff33e0",width:2})})})});return{layer:e,clickHandler:async r=>{const t=await e.getFeatures(r.pixel);if(t.length){t.forEach(a=>u.removeFeature(a));return}u.addFeature(new M(new j(r.coordinate)))},getMarkers:()=>u.getFeatures().map(r=>r.getGeometry().getCoordinates()),addMarkers:r=>r.forEach(t=>u.addFeature(new M(new j(t))))}}function Qe(u,e,s,i=!0){e=[0,0,e[0],e[1]];const n=new We({code:"this-image",units:"pixels",extent:e}),r=z(),t=new C({layers:[new Y({source:new X({url:s,projection:n,imageExtent:e})}),r.layer],target:u,view:new R({projection:n,center:B(e),extent:e,showFullExtent:!0,zoom:1})});t.getView().fit(e);const a=async l=>{const o=await r.layer.getFeatures(l.pixel);t.getTargetElement().style.cursor=o.length?"pointer":""};return i&&(t.on("click",r.clickHandler),t.on("pointermove",a),t.on("click",l=>setTimeout(o=>a(l),10))),{map:t,userMarkers:r}}function et(u,e,s,i=!0){const n=je([parseFloat(e.west),parseFloat(e.south),parseFloat(e.east),parseFloat(e.north)],"EPSG:4326","EPSG:3857"),r=z(),t=new ge({units:"metric",bar:!0,steps:4,text:!1,minWidth:140}),a=new C({controls:ue().extend([t]),layers:[new oe({source:new le({attributions:["Powered by Esri","Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community"],url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",maxZoom:20})}),new Y({source:new X({url:s,imageExtent:n})}),r.layer],target:u,view:new R});a.getView().fit(n);const l=async o=>{const c=await r.layer.getFeatures(o.pixel);a.getTargetElement().style.cursor=c.length?"pointer":""};return i&&(a.on("click",r.clickHandler),a.on("pointermove",l),a.on("click",o=>setTimeout(c=>l(o),10))),{map:a,userMarkers:r}}function Ke(){const u=document.createElement("button"),e=document.createElement("div");e.className="ol-unselectable ol-control",e.style.right=".5em",e.style.top=".5em",e.appendChild(u);const s=new ce({element:e});return{button:u,control:s}}function tt(u,e,s,i,n=!0,r=!1){e=x(e);const t=new R({center:e}),a=r?.83236:H(t.getProjection(),1,e);s=[e[0]-s[0]/2/a,e[1]-s[1]/2/a,e[0]+s[0]/2/a,e[1]+s[1]/2/a];const l=new R({extent:s,showFullExtent:!0}),o=z(),c=new ge({units:"metric",bar:!0,steps:4,text:!1,minWidth:160}),h=Ke();let d=window.sessionStorage.getItem("view-type")==="extent"?l:t;h.button.innerHTML=window.sessionStorage.getItem("view-type")==="extent"?"🔳":"🔲";const g=new C({controls:ue().extend([c,h.control]),layers:[new Y({source:new X({url:i,imageExtent:s})}),o.layer],target:u,view:d});g.getView().fit(s),h.button.addEventListener("click",w=>{d===t?(h.button.innerHTML="🔳",window.sessionStorage.setItem("view-type","extent"),d=l):(h.button.innerHTML="🔲",window.sessionStorage.setItem("view-type","free"),d=t),g.setView(d),d.fit(s)});const p=async w=>{const _=await o.layer.getFeatures(w.pixel);g.getTargetElement().style.cursor=_.length?"pointer":""};return n&&(g.on("click",o.clickHandler),g.on("pointermove",p),g.on("click",w=>setTimeout(_=>p(w),10))),{map:g,userMarkers:o}}export{et as a,tt as b,Qe as d,Je as m};
