<style>
    .alert-card { border: none; border-radius: 12px; transition: all 0.3s ease; }
    .alert-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .status-dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 8px; }
    .bg-Green { background-color: #22c55e; }
    .bg-Yellow { background-color: #eab308; }
    .bg-Orange { background-color: #f97316; }
    .bg-Red { background-color: #ef4444; }
    .text-Green { color: #166534; }
    .text-Yellow { color: #854d0e; }
    .text-Orange { color: #9a3412; }
    .text-Red { color: #991b1b; }
    .alert-box-Green { background-color: #dcfce7; border-left: 5px solid #22c55e; }
    .alert-box-Yellow { background-color: #fef9c3; border-left: 5px solid #eab308; }
    .alert-box-Orange { background-color: #ffedd5; border-left: 5px solid #f97316; }
    .alert-box-Red { background-color: #fee2e2; border-left: 5px solid #ef4444; }
    
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-pulse {
        animation: pulse 2s infinite ease-in-out;
    }

    #map-alerts { height: 400px; width: 100%; border-radius: 12px; border: 1px solid #e2e8f0; }
    
    .map-legend-overlay {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        max-width: 180px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
    }
    
    .legend-item:last-child { margin-bottom: 0; }
    
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="fas fa-broadcast-tower me-2"></i>Flood Alert System
                    </h2>
                    <span class="badge bg-light text-dark px-3 py-2 border">
                        <i class="far fa-clock me-1"></i> <?= $timestamp ?>
                    </span>
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- Flood Monitoring Connection Banner -->
                <?php if (isset($weather) && $weather): ?>
                <div class="alert border-0 rounded-3 mb-4 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2" 
                     style="background: linear-gradient(135deg, rgba(102,126,234,0.08), rgba(118,75,162,0.08)); border-left: 4px solid #667eea !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-3 text-primary"><i class="<?= $weather['icon'] ?>"></i></div>
                        <div>
                            <div class="fw-bold" style="font-size: 0.9rem;"><?= $weather['temp'] ?> · <?= $weather['condition'] ?></div>
                            <div class="text-muted small">
                                <i class="fas fa-tint me-1 text-info"></i>Rainfall: <?= $weather['rainfall'] ?>
                                <?php if ((float)str_replace('mm', '', $weather['rainfall']) > 20): ?>
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.6rem;">Heavy</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <a href="/micro-oss/index.php?route=flood-monitoring" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-map me-1"></i>Flood Monitor Map
                    </a>
                </div>
                <?php endif; ?>

                <!-- Barangay Selection -->
                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-search me-1 text-muted"></i> Select Barangay</label>
                    <form method="GET" action="/micro-oss/index.php" id="alertForm">
                        <input type="hidden" name="route" value="alerts">
                        <select name="barangay" class="form-select form-select-lg rounded-3" onchange="this.form.submit()" required>
                            <option value="">-- Choose Barangay --</option>
                            <?php foreach ($barangayList as $b): ?>
                                <option value="<?= htmlspecialchars($b) ?>" <?= ($barangay === $b) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <?php if ($barangay !== null): ?>
                    <!-- Flood Alert Map -->
                    <div class="position-relative mb-4">
                        <div id="map-alerts"></div>
                        <div class="map-legend-overlay shadow-sm">
                            <div class="legend-item">
                                <div class="legend-dot bg-Red"></div>
                                <span>Critical / Red</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot bg-Orange"></div>
                                <span>High Risk / Orange</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot bg-Yellow"></div>
                                <span>Warning / Yellow</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot bg-Green"></div>
                                <span>Safe / Green</span>
                            </div>
                        </div>
                    </div>

                    <!-- Current Alert Level -->
                    <div class="alert-box-<?= $alertColors[$barangayAlert] ?> p-4 rounded-4 mb-4 shadow-sm">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-dot bg-<?= $alertColors[$barangayAlert] ?> animate-pulse"></div>
                            <h4 class="mb-0 fw-bold text-<?= $alertColors[$barangayAlert] ?>">
                                <?= htmlspecialchars($barangay) ?>: <?= strtoupper($alertColors[$barangayAlert]) ?>
                            </h4>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold mb-1 opacity-75">ADVISORY:</h6>
                            <p class="mb-0 fs-5"><?= !empty($barangayAdvisory) ? htmlspecialchars($barangayAdvisory) : "No specific advisory issued for this location." ?></p>
                        </div>
                        
                        <div class="p-3 bg-white bg-opacity-50 rounded-3">
                            <h6 class="fw-bold mb-1 text-muted small">PROTOCOL:</h6>
                            <p class="mb-0 small text-dark"><?= $educationMsg[$barangayAlert] ?></p>
                        </div>
                    </div>

                    <!-- Sitio-Level Alerts -->
                    <h5 class="fw-bold mt-5 mb-4 px-2">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>Sitio-Level Alerts
                    </h5>
                    
                    <div class="row g-3">
                        <?php if (count($sitios) > 0): ?>
                            <?php foreach ($sitios as $s): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 alert-card alert-box-<?= $alertColors[(int)($s['flood_level'] ?? 0)] ?>">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="fw-bold mb-0"><?= htmlspecialchars($s['sitio_name']) ?></h6>
                                                <span class="badge bg-<?= $alertColors[(int)($s['flood_level'] ?? 0)] ?> rounded-pill">
                                                    <?= $alertColors[(int)($s['flood_level'] ?? 0)] ?>
                                                </span>
                                            </div>
                                            <p class="small mb-0 opacity-75">
                                                <?= !empty($s['flood_advisory']) ? htmlspecialchars($s['flood_advisory']) : "Normal conditions." ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center text-muted py-4 bg-light rounded-3">
                                    No detailed sitio data recorded for this barangay.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Global Active Alerts Summary -->
                    <div class="row g-3 mb-5">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3"><i class="fas fa-exclamation-circle me-2 text-primary"></i>Active Alerts Summary</h5>
                        </div>
                        <?php 
                        $activeCount = 0;
                        foreach ($allAlerts as $item): 
                            if ($item['alert_level'] > 0): 
                                $activeCount++;
                        ?>
                            <div class="col-md-6">
                                <a href="?route=alerts&barangay=<?= urlencode($item['name']) ?>" class="text-decoration-none">
                                    <div class="card alert-card border-0 shadow-sm alert-box-<?= $alertColors[$item['alert_level']] ?>">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($item['name']) ?></h6>
                                                <span class="badge bg-<?= $alertColors[$item['alert_level']] ?> rounded-pill small">
                                                    <?= strtoupper($alertColors[$item['alert_level']]) ?>
                                                </span>
                                            </div>
                                            <div class="text-muted small text-truncate"><?= $item['flood_advisory'] ?: 'Active alert in effect.' ?></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        
                        if ($activeCount === 0):
                        ?>
                            <div class="col-12">
                                <div class="alert alert-light border text-center py-4">
                                    <i class="fas fa-check-circle text-success fs-2 mb-2"></i>
                                    <div class="fw-bold">All Areas Normal</div>
                                    <div class="small text-muted">No active flood alerts at this time.</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Welcome / Instruction State -->
                    <div class="text-center py-5 border-top">
                        <div class="mb-4 text-muted">
                            <i class="fas fa-map-marked-alt fa-4x opacity-25"></i>
                        </div>
                        <h4 class="text-muted">Explore Regional Data</h4>
                        <p class="text-muted">Select a barangay to view detailed boundaries, evacuation paths, and local sitio markers.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8"></script>
<script>
function initMap() {
    var centerMap = <?= json_encode($mapCenter) ?>;
    var map = new google.maps.Map(document.getElementById('map-alerts'), {
        center: centerMap,
        zoom: 14,
        styles: [
            { "featureType": "all", "elementType": "geometry.fill", "stylers": [{ "weight": "2.00" }] },
            { "featureType": "poi", "stylers": [{ "visibility": "off" }] }
        ]
    });

    var polygonCoords = <?= $polygonCoordsJS ?>;
    if (polygonCoords.length > 0) {
        new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: "#4338ca",
            strokeOpacity: 0.8,
            strokeWeight: 2.5,
            fillColor: "#6366f1",
            fillOpacity: 0.15,
            map: map
        });
    }

    var sitios = <?= json_encode($sitios) ?>;
    var infoWindow = new google.maps.InfoWindow();
    var alertColorsMap = {0: 'green', 1: 'yellow', 2: 'orange', 3: 'red'};

    // Add selected Barangay marker if coordinates exist
    <?php if ($barangay !== null): ?>
    (function(){
        var brgyData = <?= json_encode(['name' => $barangay, 'level' => $barangayAlert, 'lat' => $mapCenter['lat'], 'lng' => $mapCenter['lng'], 'advisory' => $barangayAdvisory]) ?>;
        // Only show marker if it's NOT the default center OR if there's no polygon
        if (polygonCoords.length === 0 || (brgyData.lat !== 7.028 || brgyData.lng !== 125.448)) {
            var colorName = alertColorsMap[brgyData.level] || 'green';
            var marker = new google.maps.Marker({
                position: {lat: brgyData.lat, lng: brgyData.lng},
                map: map,
                title: brgyData.name,
                icon: 'https://maps.google.com/mapfiles/ms/icons/' + colorName + '.png', // Square marker for barangay
                zIndex: 1000
            });
            marker.addListener('click', function() {
                var content = `
                    <div style="padding: 10px; max-width: 250px; font-family: 'Inter', sans-serif;">
                        <h6 class="fw-bold mb-1">${brgyData.name} (Barangay)</h6>
                        <div class="badge bg-${colorName.charAt(0).toUpperCase() + colorName.slice(1)} mb-2">${colorName.toUpperCase()}</div>
                        <div class="small">${brgyData.advisory || 'Normal conditions.'}</div>
                    </div>
                `;
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
            });
        }
    })();
    <?php endif; ?>

    sitios.forEach(function(sitio) {
        if (sitio.latitude && sitio.longitude) {
            var level = parseInt(sitio.flood_level || 0);
            var colorName = alertColorsMap[level] || 'green';
            
            var marker = new google.maps.Marker({
                position: {lat: parseFloat(sitio.latitude), lng: parseFloat(sitio.longitude)},
                map: map,
                title: sitio.sitio_name,
                icon: 'https://maps.google.com/mapfiles/ms/icons/' + colorName + '-dot.png'
            });

            marker.addListener('click', function() {
                var content = `
                    <div style="padding: 10px; max-width: 250px; font-family: 'Inter', sans-serif;">
                        <h6 class="fw-bold mb-1">${sitio.sitio_name}</h6>
                        <div class="badge bg-${colorName.charAt(0).toUpperCase() + colorName.slice(1)} mb-2">${colorName.toUpperCase()}</div>
                        <div class="small text-muted">${sitio.flood_advisory || 'Normal conditions.'}</div>
                    </div>
                `;
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
            });
        }
    });
}
if (document.getElementById('map-alerts')) {
    initMap();
}
</script>