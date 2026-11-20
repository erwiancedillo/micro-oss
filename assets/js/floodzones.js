let floodPolygons = [];

function loadFloodZones() {
    if (!map || typeof L === 'undefined') return;
    floodPolygons.forEach(zone => map.removeLayer(zone.polygon));
    floodPolygons = [];
    fetch("api/get-floodzones.php")
        .then(response => response.json())
        .then(zones => {
            zones.forEach(zone => {
                const polygon = L.polygon(zone.polygon, {
                    fillColor: getRiskColor(zone.risk_level),
                    fillOpacity: 0.4,
                    color: '#000',
                    weight: 1
                }).addTo(map);
                floodPolygons.push({
                    polygon: polygon,
                    risk: zone.risk_level
                });
            });
        })
        .catch(error => console.error('Unable to load flood zones:', error));
}

function getRiskColor(level) {
    if (String(level).toLowerCase() === "high") return "red";
    if (String(level).toLowerCase() === "moderate") return "orange";
    if (String(level).toLowerCase() === "low") return "green";
    return "#319795"; // safe zone
}

function pointInFloodPolygon(point, ring) {
    let inside = false;
    for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
        const a = ring[i];
        const b = ring[j];
        const crosses = ((a.lat > point.lat) !== (b.lat > point.lat)) &&
            (point.lng < (b.lng - a.lng) * (point.lat - a.lat) / ((b.lat - a.lat) || Number.EPSILON) + a.lng);
        if (crosses) inside = !inside;
    }
    return inside;
}

function checkFloodRisk(location) {
    floodPolygons.forEach(zone => {
        const rings = zone.polygon.getLatLngs();
        const outerRing = Array.isArray(rings[0]) ? rings[0] : rings;
        if (pointInFloodPolygon(location, outerRing)) {
            alert("⚠ WARNING: You are inside a " + zone.risk.toUpperCase() + " flood risk zone!");
        }
    });
}