<style>
    .form-select {
        border-radius: 20px !important;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }
    .form-select:hover {
        border-color: #cbd5e1;
        background-color: #f1f5f9;
        cursor: pointer;
    }
    .form-select:focus {
        border-color: #6366f1;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        outline: none;
    }
    #map { height: 600px; width: 100%; border-radius: 12px; border: 1px solid #e2e8f0; }
    .map-card { border: none; border-radius: 16px; overflow: hidden; }
    
    .map-legend-overlay {
        position: absolute;
        bottom: 225px;
        right: 20px;
        left: auto;
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
        bottom: 165px;
        right: 20px;
        z-index: 1000;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4f46e5;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .loc-btn:hover {
        background: #4f46e5;
        color: #fff;
        transform: scale(1.1) translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.3), 0 10px 10px -5px rgba(79, 70, 229, 0.2);
    }
    
    .loc-btn i { 
        font-size: 1.25rem; 
        transition: transform 0.3s ease;
    }

    @media (max-width: 768px) {
        #map { height: 450px; border-radius: 12px 12px 0 0; }
        .card-body { display: flex; flex-direction: column; }
        .map-legend-overlay {
            position: relative;
            top: 0;
            bottom: auto;
            left: 0;
            right: 0;
            max-width: 100%;
            margin: 0;
            border-radius: 0 0 12px 12px;
            border: none;
            border-top: 1px solid #e2e8f0;
            background: #fff;
            box-shadow: none;
            order: 2;
        }
        #map { order: 1; }
        .loc-btn {
            bottom: 155px;
            right: 20px;
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
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
                                <?php if (isset($barangayList)): ?>
                                    <?php foreach ($barangayList as $b): ?>
                                        <option value="<?= htmlspecialchars($b) ?>" <?= ($barangay === $b) ? 'selected' : '' ?>><?= htmlspecialchars($b) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="Lizada" <?= $barangay=='Lizada'?'selected':'' ?>>Lizada</option>
                                <?php endif; ?>
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
                        <div class="legend-line" style="background: #2563eb;"></div>
                        <span>Barangay Boundary</span>
                    </div>

                       <div class="legend-item mt-2 pt-2 border-top">
                        <img src="https://maps.google.com/mapfiles/ms/icons/red-pushpin.png" width="18" height="18">
                        <span class="text-primary fw-bold">Your Location</span>
                    </div>

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

                <!-- Location Center Button -->
                <button id="center-location" class="loc-btn" title="Show my location">
                    <i class="fas fa-location-arrow"></i>
                </button>

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
            strokeColor: "#2563eb",
            strokeOpacity: 1.0,
            strokeWeight: 3,
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

    // --- Citizen Science Reports ---
    var citizenReports = <?= json_encode($citizenReports ?? []) ?>;
    citizenReports.forEach(function(report) {
        if (!report.latitude || !report.longitude) return;
        var m = new google.maps.Marker({
            position: {lat: parseFloat(report.latitude), lng: parseFloat(report.longitude)},
            map: map,
            title: report.category,
            icon: 'https://maps.google.com/mapfiles/ms/icons/orange-dot.png'
        });
        m.addListener('click', function() {
            var info = new google.maps.InfoWindow({
                content: '<div style="font-family:Inter,sans-serif; max-width:200px;">' +
                         '<h6 style="color:#f97316; font-weight:bold"><i class="fas fa-camera me-1"></i> ' + report.category + '</h6>' +
                         '<p style="font-size:12px; margin-bottom:5px;">' + report.description + '</p>' +
                         '<small style="color:#666">By: ' + report.first_name + ' | ' + report.status + '</small>' +
                         '</div>'
            });
            info.open(map, m);
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
