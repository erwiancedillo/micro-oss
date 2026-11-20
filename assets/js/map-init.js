let map;
let userMarker = null;
let routeLayer = null;
let centerMarkers = [];
let watchId = null;
let currentDestination = null;
let updateTimeout = null;
let lastPosition = null;  
let nearestMarker = null; 
const defaultCenter = { lat: 7.028012, lng: 125.447948 };

function initMap() {
    map = L.map('map').setView([defaultCenter.lat, defaultCenter.lng], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    addLeafletFullscreenControl(map);

    // Show user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };
            userMarker = L.circleMarker([userLocation.lat, userLocation.lng], { radius: 8, color: '#fff', weight: 3, fillColor: '#2563eb', fillOpacity: 1 }).addTo(map).bindTooltip('Your Location');
            map.setView([userLocation.lat, userLocation.lng], 15);
        });
    }

    // Load DB centers
    fetch('api/get-centers.php')
        .then(res => res.json())
        .then(data => {
            console.log("Centers loaded:", data);
            centerMarkers.forEach(m => map.removeLayer(m));
            centerMarkers = [];

            if (!data || data.length === 0) {
                console.warn("No evacuation centers found in database");
                return;
            }

            const bounds = L.latLngBounds([]);

            data.forEach(center => {
                const lat = parseFloat(center.latitude);
                const lng = parseFloat(center.longitude);
                
                if (isNaN(lat) || isNaN(lng)) {
                    console.warn("Invalid coordinates for center:", center);
                    return;
                }

                const marker = L.marker([lat, lng], {
                    title: center.name,
                    icon: getStatusIcon(center.status),
                    defaultIcon: getStatusIcon(center.status)
                }).addTo(map);
                marker.centerStatus = center.status || 'Vacant';
                marker.centerCapacity = center.capacity || 0;
                marker.centerOccupied = center.occupied || 0;

                // click to select center
                marker.on('click', () => selectCenter(marker));

                centerMarkers.push(marker);
                bounds.extend(marker.getLatLng());
            });

            if (centerMarkers.length > 0 && !userMarker) {
                map.fitBounds(bounds);
            }

            console.log("Total markers added:", centerMarkers.length);
        })
        .catch(err => console.error("Error loading centers:", err));

    // load flood zones if function available
    if (typeof loadFloodZones === 'function') {
        loadFloodZones();
    }

    // Map click to get barangay
    map.on('click', async e => {
        try {
            const result = await mapServices.reverseGeocode(e.latlng.lat, e.latlng.lng);
            const barangay = parseBarangay(result.address_components);
            if (barangay) document.getElementById('info-panel').innerHTML += `<br><em>Clicked Barangay:</em> ${barangay}`;
        } catch (error) {
            console.warn('Could not identify clicked barangay:', error);
        }
    });
}

// Select a center (marker)
function selectCenter(marker) {
    currentDestination = marker.getLatLng();
    highlightNearestMarker(marker);

    // Get center status from marker object
    const status = marker.centerStatus || "Vacant";
    const capacity = marker.centerCapacity || 0;
    const occupied = marker.centerOccupied || 0;

    if (userMarker) {
        const user = userMarker.getLatLng();
        updateRoute({ lat: user.lat, lng: user.lng }, marker.options.title, status, capacity, occupied);
    }
}

// Update route & info panel with center status
async function updateRoute(start, centerName, status = "Vacant", capacity = 0, occupied = 0) {
    if (!currentDestination) return;
    try {
        const destination = { lat: currentDestination.lat, lng: currentDestination.lng };
        const route = await mapServices.route(start, destination);
        if (routeLayer) map.removeLayer(routeLayer);
        routeLayer = L.polyline(route.coordinates, { color: '#2563eb', weight: 5, opacity: 0.8 }).addTo(map);
        const statusClass = status === "Full" ? "status-full" : status === "Limited" ? "status-limited" : "status-vacant";
        const utilization = capacity > 0 ? ((occupied / capacity) * 100).toFixed(1) : 0;
        document.getElementById("info-panel").innerHTML =
            `<strong>🏢 Center:</strong> ${centerName}<br>` +
            `<strong>📏 Distance:</strong> ${route.distanceText}<br>` +
            `<strong>⏱️ Estimated Time:</strong> ${route.durationText}<br>` +
            `<strong>👥 Capacity:</strong> ${occupied}/${capacity} (${utilization}%)<br>` +
            `<span class="status-badge ${statusClass}">Status: ${status}</span>`;
        map.fitBounds(routeLayer.getBounds(), { padding: [30, 30] });
    } catch (error) {
        console.error('Directions request failed:', error);
        document.getElementById('info-panel').innerHTML = `<strong>${centerName}</strong><br>Route service is unavailable. The center is ${calculateDistance(start.lat, start.lng, currentDestination.lat, currentDestination.lng).toFixed(2)} km away in a straight line.`;
    }
}

// Helper: icon based on evacuation center status
function getStatusIcon(status) {
    let color = '#16a34a';
    switch(status) {
        case "Full": color = '#dc2626'; break;
        case "Limited": color = '#f97316'; break;
    }
    return L.divIcon({ className: 'center-map-marker', html: `<span style="display:block;width:20px;height:20px;border:2px solid #fff;border-radius:50%;background:${color};box-shadow:0 1px 5px #555"></span>`, iconSize: [20, 20], iconAnchor: [10, 10] });
}

// Helper: flood risk icon (kept for legacy use)
function getRiskIcon(risk) {
    let color = '#16a34a';
    switch(String(risk).toLowerCase()) {
        case "high": color = '#dc2626'; break;
        case "medium": case "moderate": color = '#f97316'; break;
    }
    return L.divIcon({ className: 'risk-map-marker', html: `<span style="display:block;width:18px;height:18px;border:2px solid #fff;border-radius:50%;background:${color}"></span>`, iconSize: [18, 18], iconAnchor: [9, 9] });
}

// Parse barangay from address components
function parseBarangay(components) {
    for (const c of components) {
        if (c.types.includes("sublocality_level_1") || c.types.includes("political")) return c.long_name;
    }
    return null;
}

// Reset map
function resetMap() {
    if (routeLayer) { map.removeLayer(routeLayer); routeLayer = null; }
    centerMarkers.forEach(m => { if (!map.hasLayer(m)) m.addTo(map); if (m.options.defaultIcon) m.setIcon(m.options.defaultIcon); });
    document.getElementById("info-panel").innerHTML = "";
    lastPosition = null;
    nearestMarker = null;
    currentDestination = null;
    if (watchId !== null) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
    }
}

// Haversine distance (km)
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2-lat1) * Math.PI/180;
    const dLon = (lon2-lon1) * Math.PI/180;
    const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLon/2)**2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

// Find nearest center and start live tracking
function findNearest() {
    if (!navigator.geolocation) { alert("Geolocation not supported."); return; }

    navigator.geolocation.getCurrentPosition(position => {
        const userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };
        if (!userMarker) {
            userMarker = L.circleMarker([userLocation.lat, userLocation.lng], { radius: 8, color: '#fff', weight: 3, fillColor: '#2563eb', fillOpacity: 1 }).addTo(map).bindTooltip('Your Location');
        } else userMarker.setLatLng([userLocation.lat, userLocation.lng]);

        map.setView([userLocation.lat, userLocation.lng], 15);

        // find nearest
        let nearest = null;
        let minDist = Infinity;
        centerMarkers.forEach(m => {
            const center = m.getLatLng();
            const dist = calculateDistance(userLocation.lat, userLocation.lng, center.lat, center.lng);
            if (dist < minDist) { minDist = dist; nearest = m; }
        });

        if (!nearest) { alert("No evacuation centers found."); return; }
        selectCenter(nearest);

        // Start debounced live tracking
        if (watchId === null) {
            watchId = navigator.geolocation.watchPosition(pos => {
                const newLoc = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                // only update if moved >10m
                if (!lastPosition || calculateDistance(lastPosition.lat, lastPosition.lng, newLoc.lat, newLoc.lng) > 0.01) {
                    lastPosition = newLoc;
                    userMarker.setLatLng([newLoc.lat, newLoc.lng]);
                    map.panTo([newLoc.lat, newLoc.lng]);
                    if (updateTimeout) clearTimeout(updateTimeout);
                    updateTimeout = setTimeout(() => {
                        if (currentDestination && nearestMarker) updateRouteLive(newLoc, nearestMarker.options.title);
                    }, 2000);
                }
            }, err => console.error(err), { enableHighAccuracy: true, maximumAge: 0, timeout: 10000 });
        }

    }, () => alert("Please allow location access."), { enableHighAccuracy: true, timeout: 10000 });
}

// Highlight nearest/selected marker
function highlightNearestMarker(marker) {
    if (nearestMarker && nearestMarker !== marker) {
        if (nearestMarker.options.defaultIcon) nearestMarker.setIcon(nearestMarker.options.defaultIcon);
    }
    marker.setIcon(L.divIcon({ className: 'selected-center-marker', html: '<span style="display:block;width:24px;height:24px;border:3px solid #fff;border-radius:50%;background:#eab308;box-shadow:0 1px 6px #444"></span>', iconSize: [24, 24], iconAnchor: [12, 12] }));
    nearestMarker = marker;
}

// Update route & info panel (live tracking version)
function updateRouteLive(start, centerName) {
    if (!currentDestination || !nearestMarker) return;
    const status = nearestMarker.centerStatus || "Vacant";
    const capacity = nearestMarker.centerCapacity || 0;
    const occupied = nearestMarker.centerOccupied || 0;
    updateRoute(start, centerName, status, capacity, occupied);
}

window.addEventListener('load', initMap);