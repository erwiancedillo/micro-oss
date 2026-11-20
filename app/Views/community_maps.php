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
    <form method="GET" action="<?= APP_BASE_PATH ?>/index.php" class="d-flex align-items-center gap-2">
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
            <span class="legend-img" style="background:#dc2626;border:2px solid #fff;border-radius:50%;box-shadow:0 0 2px #555"></span>
            <span style="color:#667eea; font-weight:700;">Your Location</span>
        </div>
        <div class="legend-item">
            <span class="legend-img" style="background:#16a34a;border:2px solid #fff;border-radius:50%;box-shadow:0 0 2px #555"></span>
            <span>Evacuation Center</span>
        </div>
        <div class="legend-item">
            <span class="legend-img" style="background:#2563eb;border:2px solid #fff;border-radius:50%;box-shadow:0 0 2px #555"></span>
            <span>Sitio Marker</span>
        </div>
        <div class="legend-item">
            <span class="legend-img" style="background:#f97316;border:2px solid #fff;border-radius:50%;box-shadow:0 0 2px #555"></span>
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

<!-- ── Leaflet Map ──────────────────────────────────────────────── -->
<script>
function initMap() {
    const center = [<?= $mapCenter['lat'] ?>, <?= $mapCenter['lng'] ?>];
    const map = L.map('map').setView(center, 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    addLeafletFullscreenControl(map);
    const dotIcon = color => L.divIcon({
        className: 'leaflet-dot-marker',
        html: `<span style="display:block;width:18px;height:18px;border:2px solid #fff;border-radius:50%;background:${color};box-shadow:0 1px 5px #555"></span>`,
        iconSize: [18, 18], iconAnchor: [9, 9]
    });

    // Barangay Boundary
    var polygonCoords = <?= $polygonCoordsJS ?>;
    if (polygonCoords.length > 0) {
        L.polygon(polygonCoords, { color: '#2563eb', weight: 3, fillColor: '#6366f1', fillOpacity: 0.2 }).addTo(map);
    }

    // Sitio Markers
    var markers = <?= json_encode($markers) ?>;
    markers.forEach(function(marker) {
        L.marker([parseFloat(marker.latitude), parseFloat(marker.longitude)], { icon: dotIcon('#2563eb'), title: marker.sitio_name }).addTo(map);
    });

    // Citizen Reports
    var citizenReports = <?= json_encode($citizenReports ?? []) ?>;
    citizenReports.forEach(function(report) {
        if (!report.latitude || !report.longitude) return;
        L.marker([parseFloat(report.latitude), parseFloat(report.longitude)], { icon: dotIcon('#f97316'), title: report.category })
            .bindPopup('<div style="font-family:Inter,sans-serif; max-width:200px;">' +
                         '<h6 style="color:#f97316; font-weight:bold"><i class="fas fa-camera me-1"></i> ' + report.category + '</h6>' +
                         '<p style="font-size:12px; margin-bottom:5px;">' + report.description + '</p>' +
                         '<small style="color:#666">By: ' + report.first_name + ' | ' + report.status + '</small>' +
                         '</div>').addTo(map);
    });

    // Flood Zones
    var floodZones = <?= json_encode($floodZones) ?>;
    floodZones.forEach(function(zone) {
        L.polygon(zone.polygon, { color: '#000', opacity: 0.5, weight: 1, fillColor: getRiskColor(zone.risk_level), fillOpacity: 0.35 }).addTo(map);
    });

    // Evacuation Centers
    var evacuationCenters = <?= json_encode($evacuationCenters) ?>;
    evacuationCenters.forEach(function(center) {
        L.marker([parseFloat(center.latitude), parseFloat(center.longitude)], { icon: dotIcon('#16a34a'), title: center.name })
            .bindPopup(`
                <div style="padding: 10px; max-width: 200px; font-family: 'Inter', sans-serif;">
                    <h6 class="fw-bold mb-1">${center.name}</h6>
                    <div class="badge bg-success mb-2">${center.status}</div>
                    <div class="small text-muted mb-1">
                        <i class="fas fa-users me-1"></i> Capacity: <strong>${center.capacity}</strong>
                    </div>
                    <div class="small text-muted">
                        <i class="fas fa-user-check me-1"></i> Occupied: <strong>${center.occupied}</strong>
                    </div>
                    <a class="btn btn-sm btn-outline-primary mt-2" target="_blank" rel="noopener" href="https://www.openstreetmap.org/directions?to=${encodeURIComponent(center.latitude)},${encodeURIComponent(center.longitude)}">Get directions</a>
                </div>
            `).addTo(map);
    });

    // User Geolocation
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
                        userMarker.setLatLng([pos.lat, pos.lng]);
                    } else {
                        userMarker = L.circleMarker([pos.lat, pos.lng], { radius: 9, color: '#fff', weight: 3, fillColor: '#dc2626', fillOpacity: 1 }).addTo(map).bindTooltip('Your current location');
                    }

                    if (centerOnFound) {
                        map.setView([pos.lat, pos.lng], 16);
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
        var icon = centerBtn.querySelector('i');
        icon.style.transition = 'transform 0.5s';
        icon.style.transform = 'rotate(360deg)';
        setTimeout(function() { icon.style.transform = 'rotate(0deg)'; }, 500);
    });

    showUserLocation(false);

    function getRiskColor(level) {
        switch((level || '').toLowerCase()) {
            case 'high': return '#ef4444';
            case 'moderate': return '#f97316';
            case 'low':      return '#22c55e';
            default:         return '#3b82f6';
        }
    }
}
initMap();
</script>
