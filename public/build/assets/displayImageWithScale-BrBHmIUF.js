import{ab as W,ac as Z,k as G,ad as ae,ae as re,af as J,ag as f,ah as T,ai as A,aj as oe,l as le,E as O,u as ce,ak as he,al as ue,am as ge,a3 as q,an as de,ao as j,ap as v,aq as me,ar as _e,as as Q,a2 as fe,at as ee,au as pe,av as we,aw as X,ax as Y,ay as Ee,az as xe,aA as Ie,aB as te,aC as ye,g as F,aD as Se,V as Re,b as ve,S as Le,aE as Me,e as Te,d as Ae,F as K,c as z,M as H,a as M,aF as be,aG as De,aH as se,T as Ce,X as ke,f as je}from"./XYZ-DW-6z1kv.js";function N(h){return Array.isArray(h)?Math.min(...h):h}class Fe extends W{constructor(e,t,i,n,a,s,l){let o=e.getExtent();o&&e.canWrapX()&&(o=o.slice(),o[0]=-1/0,o[2]=1/0);let c=t.getExtent();c&&t.canWrapX()&&(c=c.slice(),c[0]=-1/0,c[2]=1/0);const r=c?Z(i,c):i,u=G(r),g=ae(e,t,u,n),d=he,m=new re(e,t,r,o,g*d,n),p=m.calculateSourceExtent(),w=J(p)?null:s(p,g,a),x=w?f.IDLE:f.EMPTY,_=w?w.getPixelRatio():1;super(i,n,_,x),this.targetProj_=t,this.maxSourceExtent_=o,this.triangulation_=m,this.targetResolution_=n,this.targetExtent_=i,this.sourceImage_=w,this.sourcePixelRatio_=_,this.interpolate_=l,this.canvas_=null,this.sourceListenerKey_=null}disposeInternal(){this.state==f.LOADING&&this.unlistenSource_(),super.disposeInternal()}getImage(){return this.canvas_}getProjection(){return this.targetProj_}reproject_(){const e=this.sourceImage_.getState();if(e==f.LOADED){const t=T(this.targetExtent_)/this.targetResolution_,i=A(this.targetExtent_)/this.targetResolution_;this.canvas_=oe(t,i,this.sourcePixelRatio_,N(this.sourceImage_.getResolution()),this.maxSourceExtent_,this.targetResolution_,this.targetExtent_,this.triangulation_,[{extent:this.sourceImage_.getExtent(),image:this.sourceImage_.getImage()}],0,void 0,this.interpolate_,!0)}this.state=e,this.changed()}load(){if(this.state==f.IDLE){this.state=f.LOADING,this.changed();const e=this.sourceImage_.getState();e==f.LOADED||e==f.ERROR?this.reproject_():(this.sourceListenerKey_=le(this.sourceImage_,O.CHANGE,function(t){const i=this.sourceImage_.getState();(i==f.LOADED||i==f.ERROR)&&(this.unlistenSource_(),this.reproject_())},this),this.sourceImage_.load())}}unlistenSource_(){ce(this.sourceListenerKey_),this.sourceListenerKey_=null}}const L=4,C={IMAGELOADSTART:"imageloadstart",IMAGELOADEND:"imageloadend",IMAGELOADERROR:"imageloaderror"};class Ne extends _e{constructor(e,t){super(e),this.image=t}}class We extends ue{constructor(e){super({attributions:e.attributions,projection:e.projection,state:e.state,interpolate:e.interpolate!==void 0?e.interpolate:!0}),this.on,this.once,this.un,this.loader=e.loader||null,this.resolutions_=e.resolutions!==void 0?e.resolutions:null,this.reprojectedImage_=null,this.reprojectedRevision_=0,this.image=null,this.wantedExtent_,this.wantedResolution_,this.static_=e.loader?e.loader.length===0:!1,this.wantedProjection_=null}getResolutions(){return this.resolutions_}setResolutions(e){this.resolutions_=e}findNearestResolution(e){const t=this.getResolutions();if(t){const i=ge(t,e,0);e=t[i]}return e}getImage(e,t,i,n){const a=this.getProjection();if(!a||!n||q(a,n))return a&&(n=a),this.getImageInternal(e,t,i,n);if(this.reprojectedImage_){if(this.reprojectedRevision_==this.getRevision()&&q(this.reprojectedImage_.getProjection(),n)&&this.reprojectedImage_.getResolution()==t&&de(this.reprojectedImage_.getExtent(),e))return this.reprojectedImage_;this.reprojectedImage_.dispose(),this.reprojectedImage_=null}return this.reprojectedImage_=new Fe(a,n,e,t,i,(s,l,o)=>this.getImageInternal(s,l,o,a),this.getInterpolate()),this.reprojectedRevision_=this.getRevision(),this.reprojectedImage_}getImageInternal(e,t,i,n){if(this.loader){const a=Oe(e,t,i,1),s=this.findNearestResolution(t);if(this.image&&(this.static_||this.wantedProjection_===n&&(this.wantedExtent_&&j(this.wantedExtent_,a)||j(this.image.getExtent(),a))&&(this.wantedResolution_&&N(this.wantedResolution_)===s||N(this.image.getResolution())===s)))return this.image;this.wantedProjection_=n,this.wantedExtent_=a,this.wantedResolution_=s,this.image=new W(a,s,i,this.loader),this.image.addEventListener(O.CHANGE,this.handleImageChange.bind(this))}return this.image}handleImageChange(e){const t=e.target;let i;switch(t.getState()){case f.LOADING:this.loading=!0,i=C.IMAGELOADSTART;break;case f.LOADED:this.loading=!1,i=C.IMAGELOADEND;break;case f.ERROR:this.loading=!1,i=C.IMAGELOADERROR;break;default:return}this.hasListener(i)&&this.dispatchEvent(new Ne(i,t))}}function Ge(h,e){h.getImage().src=e}function Oe(h,e,t,i){const n=e/t,a=G(h),s=v(T(h)/n,L),l=v(A(h)/n,L),o=v((i-1)*s/2,L),c=s+2*o,r=v((i-1)*l/2,L),u=l+2*r;return me(a,n,0,[c,u])}function He(h){const e=h.load||Q,t=h.imageExtent,i=new Image;return h.crossOrigin!==null&&(i.crossOrigin=h.crossOrigin),()=>e(i,h.url).then(n=>{const a=T(t)/n.width,s=A(t)/n.height;return{image:n,extent:t,resolution:a!==s?[a,s]:s,pixelRatio:1}})}class P extends We{constructor(e){const t=e.crossOrigin!==void 0?e.crossOrigin:null,i=e.imageLoadFunction!==void 0?e.imageLoadFunction:Ge;super({attributions:e.attributions,interpolate:e.interpolate,projection:fe(e.projection)}),this.url_=e.url,this.imageExtent_=e.imageExtent,this.image=null,this.image=new W(this.imageExtent_,void 0,1,He({url:e.url,imageExtent:e.imageExtent,crossOrigin:t,load:(n,a)=>(this.image.setImage(n),i(this.image,a),Q(n))})),this.image.addEventListener(O.CHANGE,this.handleImageChange.bind(this))}getImageExtent(){return this.imageExtent_}getImageInternal(e,t,i,n){return ee(e,this.image.getExtent())?this.image:null}getUrl(){return this.url_}}class Pe extends pe{constructor(e){e=e||{},super(e)}}class Ve extends we{constructor(e){super(e),this.image_=null}getImage(){return this.image_?this.image_.getImage():null}prepareFrame(e){const t=e.layerStatesArray[e.layerIndex],i=e.pixelRatio,n=e.viewState,a=n.resolution,s=this.getLayer().getSource(),l=e.viewHints;let o=e.extent;if(t.extent!==void 0&&(o=Z(o,X(t.extent,n.projection))),!l[Y.ANIMATING]&&!l[Y.INTERACTING]&&!J(o))if(s){const c=n.projection,r=s.getImage(o,a,i,c);r&&(this.loadImage(r)?this.image_=r:r.getState()===f.EMPTY&&(this.image_=null))}else this.image_=null;return!!this.image_}getData(e){const t=this.frameState;if(!t)return null;const i=this.getLayer(),n=Ee(t.pixelToCoordinateTransform,e.slice()),a=i.getExtent();if(a&&!xe(a,n))return null;const s=this.image_.getExtent(),l=this.image_.getImage(),o=T(s),c=Math.floor(l.width*((n[0]-s[0])/o));if(c<0||c>=l.width)return null;const r=A(s),u=Math.floor(l.height*((s[3]-n[1])/r));return u<0||u>=l.height?null:this.getImageData(l,c,u)}renderFrame(e,t){const i=this.image_,n=i.getExtent(),a=i.getResolution(),[s,l]=Array.isArray(a)?a:[a,a],o=i.getPixelRatio(),c=e.layerStatesArray[e.layerIndex],r=e.pixelRatio,u=e.viewState,g=u.center,d=u.resolution,m=r*s/(d*o),p=r*l/(d*o);this.prepareContainer(e,t);const w=this.context.canvas.width,x=this.context.canvas.height,_=this.getRenderContext(e);let E=!1,b=!0;if(c.extent){const y=X(c.extent,u.projection);b=ee(y,e.extent),E=b&&!j(y,e.extent),E&&this.clipUnrotated(_,e,y)}const I=i.getImage(),R=Ie(this.tempTransform,w/2,x/2,m,p,0,o*(n[0]-g[0])/s,o*(g[1]-n[3])/l);this.renderedResolution=l*r/o;const U=I.width*R[0],$=I.height*R[3];if(this.getLayer().getSource().getInterpolate()||(_.imageSmoothingEnabled=!1),this.preRender(_,e),b&&U>=.5&&$>=.5){const y=R[4],ne=R[5],D=c.opacity;D!==1&&(_.save(),_.globalAlpha=D),_.drawImage(I,0,0,+I.width,+I.height,y,ne,U,$),D!==1&&_.restore()}return this.postRender(this.context,e),E&&_.restore(),_.imageSmoothingEnabled=!0,this.container}}class V extends Pe{constructor(e){super(e)}createRenderer(){return new Ve(this)}getData(e){return super.getData(e)}}const k="units",Be=[1,2,5],S=25.4/.28;class ie extends te{constructor(e){e=e||{};const t=document.createElement("div");t.style.pointerEvents="none",super({element:t,render:e.render,target:e.target}),this.on,this.once,this.un;const i=e.className!==void 0?e.className:e.bar?"ol-scale-bar":"ol-scale-line";this.innerElement_=document.createElement("div"),this.innerElement_.className=i+"-inner",this.element.className=i+" "+ye,this.element.appendChild(this.innerElement_),this.viewState_=null,this.minWidth_=e.minWidth!==void 0?e.minWidth:64,this.maxWidth_=e.maxWidth,this.renderedVisible_=!1,this.renderedWidth_=void 0,this.renderedHTML_="",this.addChangeListener(k,this.handleUnitsChanged_),this.setUnits(e.units||"metric"),this.scaleBar_=e.bar||!1,this.scaleBarSteps_=e.steps||4,this.scaleBarText_=e.text||!1,this.dpi_=e.dpi||void 0}getUnits(){return this.get(k)}handleUnitsChanged_(){this.updateElement_()}setUnits(e){this.set(k,e)}setDpi(e){this.dpi_=e}updateElement_(){const e=this.viewState_;if(!e){this.renderedVisible_&&(this.element.style.display="none",this.renderedVisible_=!1);return}const t=e.center,i=e.projection,n=this.getUnits(),a=n=="degrees"?"degrees":"m";let s=F(i,e.resolution,t,a);const l=this.minWidth_*(this.dpi_||S)/S,o=this.maxWidth_!==void 0?this.maxWidth_*(this.dpi_||S)/S:void 0;let c=l*s,r="";if(n=="degrees"){const E=Se.degrees;c*=E,c<E/60?(r="″",s*=3600):c<E?(r="′",s*=60):r="°"}else if(n=="imperial")c<.9144?(r="in",s/=.0254):c<1609.344?(r="ft",s/=.3048):(r="mi",s/=1609.344);else if(n=="nautical")s/=1852,r="NM";else if(n=="metric")c<1e-6?(r="nm",s*=1e9):c<.001?(r="μm",s*=1e6):c<1?(r="mm",s*=1e3):c<1e3?r="m":(r="km",s/=1e3);else if(n=="us")c<.9144?(r="in",s*=39.37):c<1609.344?(r="ft",s/=.30480061):(r="mi",s/=1609.3472);else throw new Error("Invalid units");let u=3*Math.floor(Math.log(l*s)/Math.log(10)),g,d,m,p,w,x;for(;;){m=Math.floor(u/3);const E=Math.pow(10,m);if(g=Be[(u%3+3)%3]*E,d=Math.round(g/s),isNaN(d)){this.element.style.display="none",this.renderedVisible_=!1;return}if(o!==void 0&&d>=o){g=p,d=w,m=x;break}else if(d>=l)break;p=g,w=d,x=m,++u}const _=this.scaleBar_?this.createScaleBar(d,g,r):g.toFixed(m<0?-m:0)+" "+r;this.renderedHTML_!=_&&(this.innerElement_.innerHTML=_,this.renderedHTML_=_),this.renderedWidth_!=d&&(this.innerElement_.style.width=d+"px",this.renderedWidth_=d),this.renderedVisible_||(this.element.style.display="",this.renderedVisible_=!0)}createScaleBar(e,t,i){const n=this.getScaleForResolution(),a=n<1?Math.round(1/n).toLocaleString()+" : 1":"1 : "+Math.round(n).toLocaleString(),s=this.scaleBarSteps_,l=e/s,o=[this.createMarker("absolute")];for(let r=0;r<s;++r){const u=r%2===0?"ol-scale-singlebar-odd":"ol-scale-singlebar-even";o.push(`<div><div class="ol-scale-singlebar ${u}" style="width: ${l}px;"></div>`+this.createMarker("relative")+(r%2===0||s===2?this.createStepText(r,e,!1,t,i):"")+"</div>")}return o.push(this.createStepText(s,e,!0,t,i)),(this.scaleBarText_?`<div class="ol-scale-text" style="width: ${e}px;">`+a+"</div>":"")+o.join("")}createMarker(e){return`<div class="ol-scale-step-marker" style="position: ${e}; top: ${e==="absolute"?3:-10}px;"></div>`}createStepText(e,t,i,n,a){const l=(e===0?0:Math.round(n/this.scaleBarSteps_*e*100)/100)+(e===0?"":" "+a),o=e===0?-3:t/this.scaleBarSteps_*-1,c=e===0?0:t/this.scaleBarSteps_*2;return`<div class="ol-scale-step-text" style="margin-left: ${o}px;text-align: ${e===0?"left":"center"};min-width: ${c}px;left: ${i?t+"px":"unset"};">`+l+"</div>"}getScaleForResolution(){const e=F(this.viewState_.projection,this.viewState_.resolution,this.viewState_.center,"m"),t=this.dpi_||S,i=1e3/25.4;return e*i*t}render(e){const t=e.frameState;t?this.viewState_=t.viewState:this.viewState_=null,this.updateElement_()}}function B(){const h=new Re,e=new ve({source:h,style:new Le({image:new Me({radius:15,fill:new Te({color:"#ff33e022"}),stroke:new Ae({color:"#ff33e0",width:2})})})});return{layer:e,clickHandler:async a=>{const s=await e.getFeatures(a.pixel);if(s.length){s.forEach(l=>h.removeFeature(l));return}h.addFeature(new K(new z(a.coordinate)))},getMarkers:()=>h.getFeatures().map(a=>a.getGeometry().getCoordinates()),addMarkers:a=>a.forEach(s=>h.addFeature(new K(new z(s))))}}function qe(h,e,t,i=!0){e=[0,0,e[0],e[1]];const n=new be({code:"this-image",units:"pixels",extent:e}),a=B(),s=new H({layers:[new V({source:new P({url:t,projection:n,imageExtent:e})}),a.layer],target:h,view:new M({projection:n,center:G(e),extent:e,showFullExtent:!0,zoom:1})});s.getView().fit(e);const l=async o=>{const c=await a.layer.getFeatures(o.pixel);s.getTargetElement().style.cursor=c.length?"pointer":""};return i&&(s.on("click",a.clickHandler),s.on("pointermove",l),s.on("click",o=>setTimeout(c=>l(o),10))),{map:s,userMarkers:a}}function Xe(h,e,t,i=!0){const n=De([parseFloat(e.west),parseFloat(e.south),parseFloat(e.east),parseFloat(e.north)],"EPSG:4326","EPSG:3857"),a=B(),s=new ie({units:"metric",bar:!0,steps:4,text:!1,minWidth:140}),l=new H({controls:se().extend([s]),layers:[new Ce({source:new ke({attributions:["Powered by Esri","Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community"],url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",maxZoom:20})}),new V({source:new P({url:t,imageExtent:n})}),a.layer],target:h,view:new M});l.getView().fit(n);const o=async c=>{const r=await a.layer.getFeatures(c.pixel);l.getTargetElement().style.cursor=r.length?"pointer":""};return i&&(l.on("click",a.clickHandler),l.on("pointermove",o),l.on("click",c=>setTimeout(r=>o(c),10))),{map:l,userMarkers:a}}function Ue(){const h=document.createElement("button"),e=document.createElement("div");e.className="ol-unselectable ol-control",e.style.right=".5em",e.style.top=".5em",e.appendChild(h);const t=new te({element:e});return{button:h,control:t}}function Ye(h,e,t,i,n=!0){e=je(e);const a=new M({center:e}),s=F(a.getProjection(),1,e);t=[e[0]-t[0]/2/s,e[1]-t[1]/2/s,e[0]+t[0]/2/s,e[1]+t[1]/2/s];const l=new M({extent:t,showFullExtent:!0}),o=B(),c=new ie({units:"metric",bar:!0,steps:4,text:!1,minWidth:160}),r=Ue();let u=window.sessionStorage.getItem("view-type")==="extent"?l:a;r.button.innerHTML=window.sessionStorage.getItem("view-type")==="extent"?"🔳":"🔲";const g=new H({controls:se().extend([c,r.control]),layers:[new V({source:new P({url:i,imageExtent:t})}),o.layer],target:h,view:u});g.getView().fit(t),r.button.addEventListener("click",m=>{u===a?(r.button.innerHTML="🔳",window.sessionStorage.setItem("view-type","extent"),u=l):(r.button.innerHTML="🔲",window.sessionStorage.setItem("view-type","free"),u=a),g.setView(u),u.fit(t)});const d=async m=>{const p=await o.layer.getFeatures(m.pixel);g.getTargetElement().style.cursor=p.length?"pointer":""};return n&&(g.on("click",o.clickHandler),g.on("pointermove",d),g.on("click",m=>setTimeout(p=>d(m),10))),{map:g,userMarkers:o}}export{Xe as a,Ye as b,qe as d};
