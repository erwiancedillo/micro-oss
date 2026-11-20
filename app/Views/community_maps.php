<style>
:root {
    --grad-start: #667eea;
    --grad-end:   #764ba2;
    --bg-deep:    #090c16;
    --bg-mid:     #111531;
    --bg-light:   #191c42;
    --card-radius: 20px;
}

/* ── Hero Banner ───────────────────────────────────────── */
.map-hero-banner {
    background: linear-gradient(135deg, var(--bg-deep) 0%, var(--bg-mid) 50%, var(--bg-light) 100%);
    border-radius: var(--card-radius);
    padding: 2rem 2.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(102,126,234,0.18);
    box-shadow: 0 20px 60px rgba(9,12,22,0.5);
}
.map-hero-banner::before {
    content: '';
    position: absolute;
    top: -60px; left: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(102,126,234,0.22) 0%, transparent 70%);
    pointer-events: none;
}
.map-hero-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; right: -40px;
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(118,75,162,0.2) 0%, transparent 70%);
    pointer-events: none;
}
.header-badge-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(102,126,234,0.15);
    border: 1px solid rgba(102,126,234,0.35);
    color: #a5b4fc;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 999px;
    margin-bottom: 1rem;
}
.pulse-dot {
    width: 7px; height: 7px;
    background: #667eea;
    border-radius: 50%;
    animation: pulse-ring 1.6s ease-out infinite;
}
@keyframes pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(102,126,234,0.7); }
    70%  { box-shadow: 0 0 0 7px rgba(102,126,234,0); }
    100% { box-shadow: 0 0 0 0 rgba(102,126,234,0); }
}
.banner-title {
    font-size: clamp(1.5rem, 3vw, 2.1rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 0.3rem;
    line-height: 1.2;
}
.banner-title .highlight-purple {
    background: linear-gradient(135deg, var(--grad-start), var(--grad-end));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.banner-subtitle { color: #94a3b8; font-size: 0.9rem; margin: 0; }

/* ── Barangay Selector ─────────────────────────────────── */
.selector-card {
    background: #fff;
    border-radius: var(--card-radius);
    border: 1px solid rgba(226,232,240,0.85);
    box-shadow: 0 4px 24px rgba(102,126,234,0.07);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
.selector-label {
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 0.2rem;
}
.selector-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e293b;
}
.map-select {
    border: 1.5px solid #e2e8f0;
    border-radius: 999px;
    background: #f8fafc;
    padding: 0.5rem 1.25rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: #334155;
    transition: all 0.2s;
    outline: none;
    cursor: pointer;
    min-width: 160px;
}
.map-select:focus {
    border-color: var(--grad-start);
    box-shadow: 0 0 0 4px rgba(102,126,234,0.15);
    background: #fff;
}

/* ── Map Card ──────────────────────────────────────────── */
.map-container-card {
    background: #fff;
    border-radius: var(--card-radius);
    border: 1px solid rgba(226,232,240,0.85);
    box-shadow: 0 8px 40px rgba(102,126,234,0.1);
    overflow: hidden;
    position: relative;
}
#map {
    height: 580px;
    width: 100%;
    display: block;
}

/* ── Legend Overlay ────────────────────────────────────── */
.map-legend-overlay {
    position: absolute;
    bottom: 24px;
    right: 20px;
    z-index: 1000;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 14px 16px;
    border-radius: 16px;
    border: 1px solid rgba(226,232,240,0.9);
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    min-width: 190px;
}
.legend-heading {
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f1f5f9;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 7px;
    font-size: 0.82rem;
    font-weight: 500;
    color: #475569;
}
.legend-item:last-child { margin-bottom: 0; }
.legend-dot {
    width: 14px; height: 14px;
    border-radius: 4px;
    flex-shrink: 0;
}
.legend-line-h {
    width: 20px; height: 3px;
    border-radius: 2px;
    flex-shrink: 0;
}
.legend-img { width: 16px; height: 16px; flex-shrink: 0; }

/* ── Location Button ───────────────────────────────────── */
.loc-btn {
    position: absolute;
    bottom: 24px;
    left: 20px;
    z-index: 1000;
    background: linear-gradient(135deg, var(--grad-start), var(--grad-end));
    border: none;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    box-shadow: 0 8px 24px rgba(102,126,234,0.4);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.loc-btn:hover {
    transform: scale(1.1) translateY(-2px);
    box-shadow: 0 16px 32px rgba(102,126,234,0.5);
}

/* ── Stats Strip ───────────────────────────────────────── */
.map-stats-strip {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.stat-pill {
    flex: 1;
    min-width: 120px;
    background: #fff;
    border: 1px solid rgba(226,232,240,0.85);
    border-radius: 16px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 12px rgba(102,126,234,0.07);
}
.stat-pill-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.stat-pill-icon.indigo  { background: rgba(102,126,234,0.12); color: var(--grad-start); }
.stat-pill-icon.green   { background: rgba(34,197,94,0.12);   color: #22c55e; }
.stat-pill-icon.orange  { background: rgba(249,115,22,0.12);  color: #f97316; }
.stat-pill-icon.purple  { background: rgba(118,75,162,0.12);  color: var(--grad-end); }
.stat-pill-num  { font-size: 1.3rem; font-weight: 800; color: #1e293b; line-height: 1; }
.stat-pill-label{ font-size: 0.72rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; }

/* ── Partners Strip ────────────────────────────────────── */
.partners-strip {
    background: #fff;
    border-radius: var(--card-radius);
    border: 1px solid rgba(226,232,240,0.85);
    box-shadow: 0 4px 24px rgba(102,126,234,0.07);
    padding: 1.5rem 2rem;
    margin-top: 1.5rem;
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}
.partners-label {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #94a3b8;
    flex-shrink: 0;
}
.partner-logo-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 8px 16px;
    text-decoration: none;
    transition: all 0.2s;
}
.partner-logo-wrap:hover {
    border-color: rgba(102,126,234,0.4);
    box-shadow: 0 4px 16px rgba(102,126,234,0.12);
    transform: translateY(-1px);
}
.partner-logo-wrap img {
    width: 36px; height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}
.partner-logo-wrap span {
    font-size: 0.82rem;
    font-weight: 700;
    color: #334155;
}

/* ── Error Alert ───────────────────────────────────────── */
.map-error-alert {
    margin: 1rem;
    padding: 1rem 1.25rem;
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.3);
    border-radius: 12px;
    color: #dc2626;
    font-size: 0.88rem;
    font-weight: 600;
}

/* ── Responsive ────────────────────────────────────────── */
@media (max-width: 768px) {
    #map { height: 420px; }
    .map-hero-banner { padding: 1.5rem; }
    .selector-card { flex-direction: column; align-items: flex-start; }
    .map-legend-overlay { bottom: 12px; right: 10px; min-width: 160px; padding: 10px 12px; }
    .loc-btn { bottom: 12px; left: 10px; }
    .map-stats-strip { gap: 0.75rem; }
    .partners-strip { gap: 1rem; }
}
</style>

<!-- ── Hero Banner ──────────────────────────────────────────────── -->
<div class="map-hero-banner">
    <div class="header-badge-tag">
        <span class="pulse-dot"></span>
        Live Community Map
    </div>
    <h1 class="banner-title">
        <span class="highlight-purple">Disaster</span> Mapping &amp; Resources
    </h1>
    <p class="banner-subtitle">
        <i class="fas fa-map-marker-alt me-1"></i>
        Davao City · Real-time flood zones, evacuation centers &amp; community reports
    </p>
</div>

<!-- ── Stats Strip ─────────────────────────────────────────────── -->
<div class="map-stats-strip">
    <div class="stat-pill">
        <div class="stat-pill-icon indigo"><i class="fas fa-map"></i></div>
        <div>
            <div class="stat-pill-num"><?= count($floodZones ?? []) ?></div>
            <div class="stat-pill-label">Flood Zones</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon green"><i class="fas fa-clinic-medical"></i></div>
        <div>
            <div class="stat-pill-num"><?= count($evacuationCenters ?? []) ?></div>
            <div class="stat-pill-label">Evacuation Centers</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon orange"><i class="fas fa-camera"></i></div>
        <div>
            <div class="stat-pill-num"><?= count($citizenReports ?? []) ?></div>
            <div class="stat-pill-label">Citizen Reports</div>
        </div>
    </div>
    <div class="stat-pill">
        <div class="stat-pill-icon purple"><i class="fas fa-map-pin"></i></div>
        <div>
            <div class="stat-pill-num"><?= count($markers ?? []) ?></div>
            <div class="stat-pill-label">Sitios Mapped</div>
        </div>
    </div>
</div>

<!-- ── Barangay Selector Card ──────────────────────────────────── -->
<div class="selector-card">
    <div>
        <div class="selector-label"><i class="fas fa-layer-group me-1"></i>Viewing</div>
        <div class="selector-title">Barangay <?= htmlspecialchars($barangay ?? 'Lizada') ?></div>
    </div>
    <form method="GET" action="/index.php" class="d-flex align-items-center gap-2">
        <input type="hidden" name="route" value="community-map">
        <label for="barangay" class="selector-label mb-0 d-none d-sm-block">Switch Barangay:</label>
        <select name="barangay" id="barangay" class="map-select" onchange="this.form.submit()">
            <?php if (isset($barangayList)): ?>
                <?php foreach ($barangayList as $b): ?>
                    <option value="<?= htmlspecialchars($b) ?>" <?= ($barangay === $b) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b) ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="Lizada" <?= ($barangay ?? '') === 'Lizada' ? 'selected' : '' ?>>Lizada</option>
            <?php endif; ?>
        </select>
    </form>
</div>

<!-- ── Map Container ───────────────────────────────────────────── -->
<div class="map-container-card">

    <?php if (isset($notFound) && $notFound): ?>
        <div class="map-error-alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            No data available for "<?= htmlspecialchars($barangay ?? '') ?>". Please select another barangay.
        </div>
    <?php endif; ?>

    <!-- Legend -->
    <div class="map-legend-overlay">
        <div class="legend-heading">Map Legend</div>

        <div class="legend-item">
            <div class="legend-line-h" style="background: linear-gradient(90deg,#667eea,#764ba2);"></div>
            <span>Barangay Boundary</span>
        </div>
        <div class="legend-item">
            <img src="https://maps.google.com/mapfiles/ms/icons/red-pushpin.png" class="legend-img">
            <span style="color:#667eea; font-weight:700;">Your Location</span>
        </div>
        <div class="legend-item">
            <img src="https://maps.google.com/mapfiles/ms/icons/green-dot.png" class="legend-img">
            <span>Evacuation Center</span>
        </div>
        <div class="legend-item">
            <img src="https://maps.google.com/mapfiles/ms/icons/blue-dot.png" class="legend-img">
            <span>Sitio Marker</span>
        </div>
        <div class="legend-item">
            <img src="https://maps.google.com/mapfiles/ms/icons/orange-dot.png" class="legend-img">
            <span>Citizen Report</span>
        </div>

        <div style="border-top:1px solid #f1f5f9; margin: 8px 0 8px;"></div>

        <div class="legend-item">
            <div class="legend-dot" style="background:rgba(34,197,94,0.4); border:1px solid #22c55e;"></div>
            <span>Low Risk</span>
        </div>
        <div class="legend-item">
            <div class="legend-dot" style="background:rgba(249,115,22,0.4); border:1px solid #f97316;"></div>
            <span>Moderate Risk</span>
        </div>
        <div class="legend-item">
            <div class="legend-dot" style="background:rgba(239,68,68,0.4); border:1px solid #ef4444;"></div>
            <span>High Risk Flood</span>
        </div>
    </div>

    <!-- Location Button -->
    <button id="center-location" class="loc-btn" title="Show my location">
        <i class="fas fa-location-arrow"></i>
    </button>

    <!-- Map -->
    <div id="map"></div>
</div>

<!-- ── Partners Strip ──────────────────────────────────────────── -->
<div class="partners-strip">
    <div class="partners-label"><i class="fas fa-handshake me-1"></i>Our Partners</div>
    <a href="#" class="partner-logo-wrap">
        <img src="/assets/uploads/Lizadalogo.jpg" alt="Barangay Lizada">
        <span>Barangay Lizada</span>
    </a>
    <a href="#" class="partner-logo-wrap">
        <img src="/assets/uploads/barangaydalio.jpg" alt="Barangay Dalio">
        <span>Barangay Dalio</span>
    </a>
</div>

<!-- ── Google Maps ──────────────────────────────────────────────── -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8"></script>
<script>
function initMap() {
    var center = { lat: <?= $mapCenter['lat'] ?>, lng: <?= $mapCenter['lng'] ?> };

    var mapStyles = [
        { elementType: "geometry", stylers: [{ color: "#f8fafc" }] },
        { elementType: "labels.text.fill", stylers: [{ color: "#475569" }] },
        { elementType: "labels.text.stroke", stylers: [{ color: "#ffffff" }] },
        { featureType: "water", elementType: "geometry", stylers: [{ color: "#bfdbfe" }] },
        { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#64748b" }] },
        { featureType: "road", elementType: "geometry", stylers: [{ color: "#e2e8f0" }] },
        { featureType: "road.arterial", elementType: "geometry", stylers: [{ color: "#f1f5f9" }] },
        { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#e2e8f0" }] },
        { featureType: "poi", elementType: "geometry", stylers: [{ color: "#ecfdf5" }] },
        { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#64748b" }] },
        { featureType: "park", elementType: "geometry", stylers: [{ color: "#dcfce7" }] }
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 14,
        styles: mapStyles,
        mapTypeControl: true,
        mapTypeControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT,
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
        },
        zoomControl: true,
        zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_CENTER },
        streetViewControl: false,
        fullscreenControl: true,
        fullscreenControlOptions: { position: google.maps.ControlPosition.RIGHT_TOP }
    });

    // Barangay Boundary
    var polygonCoords = <?= $polygonCoordsJS ?>;
    if (polygonCoords.length > 0) {
        new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: "#667eea",
            strokeOpacity: 1.0,
            strokeWeight: 3,
            fillColor: "#667eea",
            fillOpacity: 0.1
        }).setMap(map);
    }

    // Sitio Markers
    var markers = <?= json_encode($markers) ?>;
    markers.forEach(function(marker) {
        new google.maps.Marker({
            position: { lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude) },
            map: map,
            title: marker.sitio_name,
            icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
        });
    });

    // Citizen Reports
    var citizenReports = <?= json_encode($citizenReports ?? []) ?>;
    citizenReports.forEach(function(report) {
        if (!report.latitude || !report.longitude) return;
        var m = new google.maps.Marker({
            position: { lat: parseFloat(report.latitude), lng: parseFloat(report.longitude) },
            map: map,
            title: report.category,
            icon: 'https://maps.google.com/mapfiles/ms/icons/orange-dot.png'
        });
        m.addListener('click', function() {
            new google.maps.InfoWindow({
                content: '<div style="font-family:Inter,sans-serif;max-width:210px;padding:4px">' +
                         '<div style="color:#f97316;font-weight:800;font-size:13px;margin-bottom:6px">' +
                         '<i class="fas fa-camera" style="margin-right:5px"></i>' + report.category + '</div>' +
                         '<p style="font-size:12px;color:#475569;margin-bottom:6px">' + report.description + '</p>' +
                         '<span style="font-size:11px;color:#94a3b8">By: ' + report.first_name + ' · ' + report.status + '</span>' +
                         '</div>'
            }).open(map, m);
        });
    });

    // Flood Zones
    var floodZones = <?= json_encode($floodZones) ?>;
    floodZones.forEach(function(zone) {
        new google.maps.Polygon({
            paths: zone.polygon,
            strokeColor: "#000",
            strokeOpacity: 0.4,
            strokeWeight: 1,
            fillColor: getRiskColor(zone.risk_level),
            fillOpacity: 0.35,
            map: map
        });
    });

    // Evacuation Centers
    var evacuationCenters = <?= json_encode($evacuationCenters) ?>;
    var evacInfoWindow = new google.maps.InfoWindow();
    evacuationCenters.forEach(function(ec) {
        var eMarker = new google.maps.Marker({
            position: { lat: parseFloat(ec.latitude), lng: parseFloat(ec.longitude) },
            map: map,
            title: ec.name,
            icon: { url: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png', scaledSize: new google.maps.Size(32, 32) }
        });
        eMarker.addListener('click', function() {
            evacInfoWindow.setContent(
                '<div style="font-family:Inter,sans-serif;max-width:210px;padding:6px">' +
                '<div style="font-weight:800;font-size:13px;color:#1e293b;margin-bottom:6px">' + ec.name + '</div>' +
                '<span style="display:inline-block;background:#dcfce7;color:#15803d;font-size:11px;font-weight:700;padding:2px 10px;border-radius:999px;margin-bottom:8px">' + ec.status + '</span>' +
                '<div style="font-size:12px;color:#64748b;margin-bottom:4px"><i class="fas fa-users" style="margin-right:4px"></i>Capacity: <strong>' + ec.capacity + '</strong></div>' +
                '<div style="font-size:12px;color:#64748b"><i class="fas fa-user-check" style="margin-right:4px"></i>Occupied: <strong>' + ec.occupied + '</strong></div>' +
                '</div>'
            );
            evacInfoWindow.open(map, eMarker);
        });
    });

    // User Geolocation
    var userMarker = null;
    var centerBtn = document.getElementById('center-location');

    function showUserLocation(forceCenter) {
        if (!navigator.geolocation) return;
        navigator.geolocation.getCurrentPosition(function(pos) {
            var latLng = { lat: pos.coords.latitude, lng: pos.coords.longitude };
            if (userMarker) {
                userMarker.setPosition(latLng);
            } else {
                userMarker = new google.maps.Marker({
                    position: latLng, map: map,
                    title: "Your Location",
                    icon: { url: 'https://maps.google.com/mapfiles/ms/icons/red-pushpin.png', scaledSize: new google.maps.Size(40, 40) },
                    zIndex: 1001
                });
            }
            if (forceCenter) { map.setCenter(latLng); map.setZoom(16); }
        });
    }

    centerBtn.addEventListener('click', function() {
        showUserLocation(true);
        var icon = centerBtn.querySelector('i');
        icon.style.transition = 'transform 0.5s';
        icon.style.transform = 'rotate(360deg)';
        setTimeout(function() { icon.style.transform = 'rotate(0deg)'; }, 500);
    });

    showUserLocation(false);

    function getRiskColor(level) {
        switch ((level || '').toLowerCase()) {
            case 'high':     return '#ef4444';
            case 'moderate': return '#f97316';
            case 'low':      return '#22c55e';
            default:         return '#3b82f6';
        }
    }
}
initMap();
</script>
