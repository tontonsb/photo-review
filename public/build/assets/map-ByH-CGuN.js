import{V as P,G as S,f as w,a as y,g as v,P as b,M as x,T as A,X as I,b as M}from"./XYZ-DsNBlP0r.js";function _(E,G,d){const a=new P({format:new S,url:G}),l=w([23.54238,56.87841]),f=new y({center:l,zoom:12}),i=v(f.getProjection(),1,l);a.on("featuresloadend",()=>a.forEachFeature(e=>{const r=e.getGeometry();if(r.getType()!=="Point")return;const o=e.get("width_guess_meters"),n=e.get("height_guess_meters"),u=e.get("bearing_degrees");if(!o||!n||!u)return;const s=r.getCoordinates(),c=s[0]-o/2/i,g=s[1]+n/2/i,m=s[0]+o/2/i,h=s[1]-n/2/i,p=new b([[[c,g],[c,h],[m,h],[m,g],[c,g]]]);p.rotate(-u*Math.PI/180,s),e.setGeometry(p)}));const t=new x({target:E,layers:[new A({source:new I({attributions:["Powered by Esri","Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community"],url:"https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",maxZoom:20})}),new M({source:a})],view:new y({center:w([23.54238,56.87841]),zoom:12})});return t.on("click",function(e){const r=t.getEventPixel(e.originalEvent),o=[];t.forEachFeatureAtPixel(r,n=>{o.push({path:n.get("path"),url:n.get("url")})}),d(o)}),t.on("pointermove",function(e){if(e.dragging)return;t.getTargetElement().style.cursor="";const r=t.getEventPixel(e.originalEvent);t.forEachFeatureAtPixel(r,o=>{if(o.get("path")&&o.get("url"))return t.getTargetElement().style.cursor="pointer",!0})}),t}window.showFeaturesOnMap=_;