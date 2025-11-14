function initMap(){
 const map = L.map('map').setView([-23.95,-46.33],10);
 L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(map);
 fetch('api/data.json').then(r=>r.json()).then(d=>{
   d.dados.forEach(p=>{
     L.marker([p.lat,p.lon]).addTo(map).bindPopup(p.tipo+' - '+p.local);
   });
 });
}
document.addEventListener('DOMContentLoaded', initMap);
