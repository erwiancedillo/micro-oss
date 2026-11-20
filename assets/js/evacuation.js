let userMarker = null;
let centerMarker = null;
let evacuationRouteLayer = null;

function findNearest() {

    if (!navigator.geolocation) {
        alert("Geolocation not supported.");
        return;
    }

    navigator.geolocation.getCurrentPosition(function (position) {

        const userLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        // Show user marker
        if (!userMarker) {
            userMarker = L.circleMarker([userLocation.lat, userLocation.lng], { radius: 8, color: '#fff', weight: 3, fillColor: '#2563eb', fillOpacity: 1 }).addTo(map).bindTooltip('Your Location');
        } else {
            userMarker.setLatLng([userLocation.lat, userLocation.lng]);
        }

        map.setView([userLocation.lat, userLocation.lng], 15);

        // Check flood risk
        checkFloodRisk(userLocation);

        if (!centers || centers.length === 0) {
            alert("No evacuation centers found.");
            return;
        }

        let nearestCenter = null;
        let shortestDistance = Infinity;

        centers.forEach(center => {

            const distance = calculateDistance(
                userLocation.lat,
                userLocation.lng,
                parseFloat(center.latitude),
                parseFloat(center.longitude)
            );

            if (distance < shortestDistance) {
                shortestDistance = distance;
                nearestCenter = center;
            }

        });

        if (!nearestCenter) return;

        const destination = {
            lat: parseFloat(nearestCenter.latitude),
            lng: parseFloat(nearestCenter.longitude)
        };

        // Draw route
        mapServices.route(userLocation, destination).then(route => {
                if (evacuationRouteLayer) map.removeLayer(evacuationRouteLayer);
                evacuationRouteLayer = L.polyline(route.coordinates, { color: '#2563eb', weight: 5, opacity: 0.8 }).addTo(map);
                map.fitBounds(evacuationRouteLayer.getBounds(), { padding: [30, 30] });
                document.getElementById("info-panel").innerHTML =
                    "<strong>Nearest Center:</strong> " + nearestCenter.name + "<br>" +
                    "<strong>Barangay:</strong> " + nearestCenter.barangay + "<br>" +
                    "<strong>Distance:</strong> " + route.distanceText + "<br>" +
                    "<strong>Estimated Time:</strong> " + route.durationText + "<br>" +
                    "<strong>Available Capacity:</strong> " +
                    (nearestCenter.capacity - nearestCenter.occupied);
        }).catch(error => alert("Directions request failed: " + error.message));

    }, function () {
        alert("Please allow location access.");
    }, {
        enableHighAccuracy: true,
        timeout: 10000
    });
}


function calculateDistance(lat1, lon1, lat2, lon2) {

    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;

    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return R * c;
}