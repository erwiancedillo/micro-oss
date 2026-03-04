let map;
let userMarker = null;
let directionsService;
let directionsRenderer;
let centerMarkers = [];
let watchId = null;
let currentDestination = null;
let updateTimeout = null;
let lastPosition = null;  
let nearestMarker = null; 
const defaultCenter = { lat: 7.028012, lng: 125.447948 };

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultCenter,
        zoom: 12,
        fullscreenControl: true,
        zoomControl: true,
        mapTypeControl: false
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: false });
    directionsRenderer.setMap(map);

    const geocoder = new google.maps.Geocoder();

    // Show user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };
            userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: "Your Location",
                icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
            });
            map.setCenter(userLocation);
            map.setZoom(15);
        });
    }

    // Load DB centers
    fetch('api/get-centers.php')
        .then(res => res.json())
        .then(data => {
            console.log("Centers loaded:", data);
            centerMarkers.forEach(m => m.setMap(null));
            centerMarkers = [];

            if (!data || data.length === 0) {
                console.warn("No evacuation centers found in database");
                return;
            }

            data.forEach(center => {
                const lat = parseFloat(center.latitude);
                const lng = parseFloat(center.longitude);
                
                if (isNaN(lat) || isNaN(lng)) {
                    console.warn("Invalid coordinates for center:", center);
                    return;
                }

                const marker = new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    map: map,
                    title: center.name,
                    icon: getStatusIcon(center.status),
                    defaultIcon: getStatusIcon(center.status),
                    status: center.status || "Vacant",
                    capacity: center.capacity || 0,
                    occupied: center.occupied || 0
                });

                // click to select center
                marker.addListener('click', () => selectCenter(marker));

                centerMarkers.push(marker);
            });

            console.log("Total markers added:", centerMarkers.length);
        })
        .catch(err => console.error("Error loading centers:", err));

    // load flood zones if function available
    if (typeof loadFloodZones === 'function') {
        loadFloodZones();
    }

    // Map click to get barangay
    map.addListener('click', e => {
        geocoder.geocode({ location: e.latLng }, (results, status) => {
            if (status === "OK" && results[0]) {
                const barangay = parseBarangay(results[0].address_components);
                if (barangay) {
                    const infoPanel = document.getElementById("info-panel");
                    infoPanel.innerHTML += `<br><em>Clicked Barangay:</em> ${barangay}`;
                }
            }
        });
    });
}

// Select a center (marker)
function selectCenter(marker) {
    currentDestination = marker.getPosition();
    highlightNearestMarker(marker);

    // Get center status from marker object
    const status = marker.status || "Vacant";
    const capacity = marker.capacity || 0;
    const occupied = marker.occupied || 0;

    if (userMarker) updateRoute(userMarker.getPosition(), marker.getTitle(), status, capacity, occupied);
}

// Update route & info panel with center status
function updateRoute(start, centerName, status = "Vacant", capacity = 0, occupied = 0) {
    if (!currentDestination) return;
    directionsService.route({
        origin: start,
        destination: currentDestination,
        travelMode: google.maps.TravelMode.DRIVING
    }, (response, statusRoute) => {
        if (statusRoute === "OK") {
            directionsRenderer.setDirections(response);
            const leg = response.routes[0].legs[0];
            const statusClass = status === "Full" ? "status-full" : status === "Limited" ? "status-limited" : "status-vacant";
            const utilization = capacity > 0 ? ((occupied / capacity) * 100).toFixed(1) : 0;
            document.getElementById("info-panel").innerHTML =
                `<strong>🏢 Center:</strong> ${centerName}<br>` +
                `<strong>📏 Distance:</strong> ${leg.distance.text} (${(leg.distance.value/1000).toFixed(2)} km)<br>` +
                `<strong>⏱️ Estimated Time:</strong> ${leg.duration.text}<br>` +
                `<strong>👥 Capacity:</strong> ${occupied}/${capacity} (${utilization}%)<br>` +
                `<span class="status-badge ${statusClass}">Status: ${status}</span>`;
        } else console.error("Directions request failed:", statusRoute);
    });
}

// Helper: icon based on evacuation center status
function getStatusIcon(status) {
    switch(status) {
        case "Full": return "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
        case "Limited": return "http://maps.google.com/mapfiles/ms/icons/orange-dot.png";
        case "Vacant": return "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
        default: return "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
    }
}

// Helper: flood risk icon (kept for legacy use)
function getRiskIcon(risk) {
    switch(risk.toLowerCase()) {
        case "high": return "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
        case "medium": return "http://maps.google.com/mapfiles/ms/icons/orange-dot.png";
        default: return "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
    }
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
    directionsRenderer.setDirections({ routes: [] });
    centerMarkers.forEach(m => { m.setMap(map); if (m.defaultIcon) m.setIcon(m.defaultIcon); });
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
            userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: "Your Location",
                icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
            });
        } else userMarker.setPosition(userLocation);

        map.panTo(userLocation);
        map.setZoom(15);

        // find nearest
        let nearest = null;
        let minDist = Infinity;
        centerMarkers.forEach(m => {
            const dist = calculateDistance(userLocation.lat, userLocation.lng, m.getPosition().lat(), m.getPosition().lng());
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
                    userMarker.setPosition(newLoc);
                    map.panTo(newLoc);
                    if (updateTimeout) clearTimeout(updateTimeout);
                    updateTimeout = setTimeout(() => {
                        if (currentDestination) updateRouteLive(newLoc, nearestMarker.getTitle());
                    }, 2000);
                }
            }, err => console.error(err), { enableHighAccuracy: true, maximumAge: 0, timeout: 10000 });
        }

    }, () => alert("Please allow location access."), { enableHighAccuracy: true, timeout: 10000 });
}

// Highlight nearest/selected marker
function highlightNearestMarker(marker) {
    if (nearestMarker && nearestMarker !== marker) {
        if (nearestMarker.defaultIcon) nearestMarker.setIcon(nearestMarker.defaultIcon);
    }
    marker.setIcon("http://maps.google.com/mapfiles/ms/icons/yellow-dot.png");
    nearestMarker = marker;
}

// Update route & info panel (live tracking version)
function updateRouteLive(start, centerName) {
    if (!currentDestination || !nearestMarker) return;
    const status = nearestMarker.status || "Vacant";
    const capacity = nearestMarker.capacity || 0;
    const occupied = nearestMarker.occupied || 0;
    updateRoute(start, centerName, status, capacity, occupied);
}

window.onload = initMap;