<style>
    #map { height: 600px; width: 100%; border-radius: 12px; border: 1px solid #e2e8f0; }
    .map-card { border: none; border-radius: 16px; overflow: hidden; }
    
    .map-legend-overlay {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        padding: 15px;
        border-radius: 12px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        max-width: 220px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #475569;
    }
    
    .legend-item:last-child { margin-bottom: 0; }
    
    .legend-color {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        flex-shrink: 0;
    }
    
    .legend-line {
        width: 18px;
        height: 3px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* Floating Location Button */
    .loc-btn {
        position: absolute;
        bottom: 25px;
        right: 20px;
        z-index: 1000;
        background: #fff;
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        transition: all 0.2s;
    }
    
    .loc-btn:hover {
        background: #f8fafc;
        transform: scale(1.05);
    }
    
    .loc-btn i { font-size: 1.2rem; }

    @media (max-width: 768px) {
        #map { height: 400px; }
        .map-legend-overlay {
            top: 10px;
            right: 10px;
            padding: 10px;
            max-width: 180px;
        }
        .loc-btn {
            bottom: 20px;
            right: 10px;
            width: 40px;
            height: 40px;
        }
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card map-card shadow-sm">
            <div class="card-header bg-white p-4 border-0">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="fas fa-map-marked-alt me-2"></i>Community Map
                        </h2>
                        <p class="text-muted small mb-0 mt-1">Davao City Disaster Mapping & Resources</p>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="/micro-oss/index.php" class="d-flex align-items-center justify-content-md-end gap-2">
                            <input type="hidden" name="route" value="community-map">
                            <label for="barangay" class="fw-bold text-nowrap d-none d-sm-block">Change Barangay:</label>
                            <select name="barangay" id="barangay" class="form-select w-auto rounded-pill px-3" onchange="this.form.submit()">
                                <option value="Lizada" <?= $barangay=='Lizada'?'selected':'' ?>>Lizada</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0 position-relative">
                <?php if (isset($notFound) && $notFound): ?>
                    <div class="alert alert-danger m-3 border-0 shadow-sm">
                        <i class="fas fa-exclamation-circle me-2"></i> No data available for "<?=htmlspecialchars($barangay)?>".
                    </div>
                <?php endif; ?>
                
                <!-- Floating Legend -->
                <div class="map-legend-overlay">
                    <h6 class="fw-bold mb-3 small text-uppercase tracking-wider text-muted">Map Legend</h6>
                    
                    <div class="legend-item">
                        <div class="legend-line" style="background: #4338ca;"></div>
                        <span>Barangay Boundary</span>
                    </div>

                       <div class="legend-item mt-2 pt-2 border-top">
                        <img src="https://maps.google.com/mapfiles/ms/icons/red-pushpin.png" width="18" height="18">
                        <span class="text-primary fw-bold">Your Location</span>
                    </div>
                    <!-- Location Center Button -->
                <button id="center-location" class="loc-btn" title="Show my location">
                    <i class="fas fa-location-arrow"></i>
                </button>

                    <div class="legend-item">
                        <img src="https://maps.google.com/mapfiles/ms/icons/green-dot.png" width="18" height="18">
                        <span>Evacuation Center</span>
                    </div>

                    
                    <div class="legend-item">
                        <div class="legend-color" style="background: rgba(34, 197, 94, 0.4); border: 1px solid #22c55e;"></div>
                        <span>Low Risk</span>
                    </div>

                    <div class="legend-item">
                        <div class="legend-color" style="background: rgba(249, 115, 22, 0.4); border: 1px solid #f97316;"></div>
                        <span>Moderate Risk</span>
                    </div>
                    
                    <div class="legend-item">
                        <div class="legend-color" style="background: rgba(239, 68, 68, 0.4); border: 1px solid #ef4444;"></div>
                        <span>High Risk Flood</span>
                    </div>
                </div>

                

                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8"></script>
<script>
function initMap() {
    var center = { lat: <?= $mapCenter['lat'] ?>, lng: <?= $mapCenter['lng'] ?> };
    var map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 14,
        styles: [{ "featureType": "all", "elementType": "geometry.fill", "stylers": [{ "weight": "2.00" }] }]
    });

    var polygonCoords = <?= $polygonCoordsJS ?>;
    if (polygonCoords.length > 0) {
        new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: "#4338ca",
            strokeOpacity: 0.8,
            strokeWeight: 2.5,
            fillColor: "#6366f1",
            fillOpacity: 0.2
        }).setMap(map);
    }

    var markers = <?= json_encode($markers) ?>;
    markers.forEach(function(marker) {
        new google.maps.Marker({
            position: {lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude)},
            map: map,
            title: marker.sitio_name,
            icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
        });
    });

    // --- Flood Zones Layer ---
    var floodZones = <?= json_encode($floodZones) ?>;
    floodZones.forEach(function(zone) {
        new google.maps.Polygon({
            paths: zone.polygon,
            strokeColor: "#000",
            strokeOpacity: 0.5,
            strokeWeight: 1,
            fillColor: getRiskColor(zone.risk_level),
            fillOpacity: 0.35,
            map: map
        });
    });

    // --- Evacuation Centers Layer ---
    var evacuationCenters = <?= json_encode($evacuationCenters) ?>;
    var evacInfoWindow = new google.maps.InfoWindow();

    evacuationCenters.forEach(function(center) {
        var evacMarker = new google.maps.Marker({
            position: {lat: parseFloat(center.latitude), lng: parseFloat(center.longitude)},
            map: map,
            title: center.name,
            icon: {
                url: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                scaledSize: new google.maps.Size(32, 32)
            }
        });

        evacMarker.addListener('click', function() {
            evacInfoWindow.setContent(`
                <div style="padding: 10px; max-width: 200px; font-family: 'Inter', sans-serif;">
                    <h6 class="fw-bold mb-1">${center.name}</h6>
                    <div class="badge bg-success mb-2">${center.status}</div>
                    <div class="small text-muted mb-1">
                        <i class="fas fa-users me-1"></i> Capacity: <strong>${center.capacity}</strong>
                    </div>
                    <div class="small text-muted">
                        <i class="fas fa-user-check me-1"></i> Occupied: <strong>${center.occupied}</strong>
                    </div>
                </div>
            `);
            evacInfoWindow.open(map, evacMarker);
        });
    });

    // --- User Geolocation ---
    var userMarker = null;
    var centerBtn = document.getElementById('center-location');

    function showUserLocation(centerOnFound = false) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    if (userMarker) {
                        userMarker.setPosition(pos);
                    } else {
                        userMarker = new google.maps.Marker({
                            position: pos,
                            map: map,
                            title: "Your current location",
                            icon: {
                                url: 'https://maps.google.com/mapfiles/ms/icons/red-pushpin.png',
                                scaledSize: new google.maps.Size(40, 40)
                            },
                            zIndex: 1001
                        });
                    }

                    if (centerOnFound) {
                        map.setCenter(pos);
                        map.setZoom(16);
                    }
                },
                function() {
                    console.log("Error: The Geolocation service failed.");
                }
            );
        } else {
            console.log("Error: Your browser doesn't support geolocation.");
        }
    }

    centerBtn.addEventListener('click', function() {
        showUserLocation(true);
        // Add a small rotation animation to the icon when clicked
        var icon = centerBtn.querySelector('i');
        icon.style.transition = 'transform 0.5s';
        icon.style.transform = 'rotate(360deg)';
        setTimeout(() => { icon.style.transform = 'rotate(0deg)'; }, 500);
    });

    // Try to show location on load without force-centering
    showUserLocation(false);

    function getRiskColor(level) {
        switch(level.toLowerCase()) {
            case 'high': return '#ef4444';
            case 'moderate': return '#f97316';
            case 'low': return '#22c55e';
            default: return '#3b82f6';
        }
    }
}
initMap();
</script>
