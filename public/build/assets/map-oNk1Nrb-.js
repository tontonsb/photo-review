import{V as S,G as b,f as w,a as y,g as f,P as v,M as x,T as _,X as A,b as I}from"./XYZ-Cu8nJpgV.js";function M(E,d,G){const a=new S({format:new b,url:d}),l=w([23.54238,56.87841]),P=new y({center:l,zoom:12}),i=f(P.getProjection(),1,l);a.on("featuresloadend",()=>a.forEachFeature(e=>{const n=e.getGeometry();if(n.getType()!=="Point")return;const o=e.get("width_guess_meters"),r=e.get("height_guess_meters"),u=e.get("bearing_degrees");if(!o||!r||!u)return;const s=n.getCoordinates(),c=s[0]-o/2/i,g=s[1]+r/2/i,m=s[0]+o/2/i,h=s[1]-r/2/i,p=new v([[[c,g],[c,h],[m,h],[m,g],[c,g]]]);p.rotate(-u*Math.PI/180,s),e.setGeometry(p)}));const t=new x({target:E,layers:[new _({source:new A({attributions:["Powered by Esri","Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community"],url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",maxZoom:20})}),new I({source:a})],view:new y({center:w([23.54238,56.87841]),zoom:12})});return t.on("click",function(e){const n=t.getEventPixel(e.originalEvent),o=[];t.forEachFeatureAtPixel(n,r=>{console.log({šķībums:r.get("bearing_degrees")}),o.push({path:r.get("path"),url:r.get("url")})}),G(o)}),t.on("pointermove",function(e){if(e.dragging)return;t.getTargetElement().style.cursor="";const n=t.getEventPixel(e.originalEvent);t.forEachFeatureAtPixel(n,o=>{if(o.get("path")&&o.get("url"))return t.getTargetElement().style.cursor="pointer",!0})}),t}window.showFeaturesOnMap=M;
