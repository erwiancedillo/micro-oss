<!-- User POV - Flood Alert System (Micro OSS Modern Purple/Indigo Theme) -->
<style>
    :root {
        --brand-primary: #667eea;
        --brand-secondary: #764ba2;
        --brand-purple-vibrant: #8b5cf6;
        --brand-purple-light: #c084fc;
        --brand-lavender: #eef2ff;
        --brand-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --brand-gradient-hover: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        --alert-green: #10b981;
        --alert-yellow: #f59e0b;
        --alert-orange: #f97316;
        --alert-red: #ef4444;
        --card-radius: 20px;
        --card-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.85);
    }

    body {
        background-color: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .alerts-container {
        padding: 1.5rem 0 3.5rem;
    }

    /* Top Hero Header Banner */
    .alerts-hero-banner {
        background: 
            radial-gradient(circle at 12% 18%, rgba(102, 126, 234, 0.32), transparent 45%),
            radial-gradient(circle at 88% 82%, rgba(118, 75, 162, 0.28), transparent 45%),
            linear-gradient(135deg, #090c16 0%, #111531 50%, #191c42 100%);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        box-shadow: 0 16px 40px -10px rgba(15, 20, 43, 0.45);
        border: 1px solid rgba(139, 92, 246, 0.25);
    }

    .alerts-hero-banner::after {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(192, 132, 252, 0.25), transparent 70%);
        pointer-events: none;
    }

    .hero-badge-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(102, 126, 234, 0.2);
        border: 1px solid rgba(139, 92, 246, 0.35);
        color: #c084fc;
        padding: 5px 14px;
        border-radius: 9999px;
        font-size: 0.775rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }

    .pulse-dot-beacon {
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        animation: pulseBeacon 1.8s infinite;
    }

    @keyframes pulseBeacon {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .hero-title-text {
        font-size: clamp(1.75rem, 3vw, 2.35rem);
        font-weight: 800;
        letter-spacing: -0.8px;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .hero-title-text .highlight-purple {
        background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtext {
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.95rem;
        max-width: 620px;
        margin-bottom: 0;
        line-height: 1.5;
    }

    .timestamp-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Weather Connection Card */
    .weather-sync-banner {
        background: #ffffff;
        border-radius: var(--card-radius);
        padding: 1.25rem 1.75rem;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .weather-sync-banner::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: var(--brand-gradient);
    }

    /* Main Alert Card Frame */
    .main-alert-frame {
        background: #ffffff;
        border-radius: var(--card-radius);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    /* Form Select Dropdown */
    .styled-barangay-select {
        height: 52px;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        font-weight: 600;
        font-size: 0.95rem;
        color: #0f172a;
        padding: 0 1.25rem;
        transition: all 0.2s ease;
    }

    .styled-barangay-select:focus {
        border-color: var(--brand-primary);
        background-color: #ffffff;
        box-shadow: 0 0 0 3.5px rgba(102, 126, 234, 0.15);
        outline: none;
    }

    /* Map Box */
    #map-alerts {
        height: 420px;
        width: 100%;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .map-legend-overlay {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        padding: 12px 16px;
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 0.775rem;
        font-weight: 700;
        color: #334155;
    }

    .legend-item:last-child { margin-bottom: 0; }

    .legend-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    /* Dynamic Alert Level Boxes */
    .alert-banner-box {
        border-radius: 16px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .alert-box-Green  { background: #ecfdf5; border: 1.5px solid rgba(16, 185, 129, 0.3); color: #065f46; }
    .alert-box-Yellow { background: #fffbeb; border: 1.5px solid rgba(245, 158, 11, 0.35); color: #92400e; }
    .alert-box-Orange { background: #fff7ed; border: 1.5px solid rgba(249, 115, 22, 0.35); color: #9a3412; }
    .alert-box-Red    { background: #fef2f2; border: 1.5px solid rgba(239, 68, 68, 0.4); color: #991b1b; }

    .level-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
    }

    .bg-Green  { background-color: var(--alert-green); }
    .bg-Yellow { background-color: var(--alert-yellow); }
    .bg-Orange { background-color: var(--alert-orange); }
    .bg-Red    { background-color: var(--alert-red); }

    .text-Green  { color: #047857; }
    .text-Yellow { color: #b45309; }
    .text-Orange { color: #c2410c; }
    .text-Red    { color: #b91c1c; }

    /* Sitio Alert Cards */
    .sitio-alert-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem 1.4rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        transition: all 0.25s ease;
        height: 100%;
    }

    .sitio-alert-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.12);
    }

    .status-pill-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 0.725rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="container alerts-container">

    <!-- Top Hero Header Banner -->
    <div class="alerts-hero-banner d-flex justify-content-between align-items-center flex-wrap gap-4">
        <div>
            <div class="hero-badge-tag">
                <span class="pulse-dot-beacon"></span>
                <span>Early Warning & Flood Advisory</span>
            </div>
            <h1 class="hero-title-text">
                Flood Alert <span class="highlight-purple">System</span>
            </h1>
            <p class="hero-subtext">
                Real-time flood risk levels, broadcast advisories, and emergency protocols across partner barangays.
            </p>
        </div>

        <div class="timestamp-badge">
            <i class="far fa-clock text-warning"></i>
            <span><?= $timestamp ?></span>
        </div>
    </div>

    <!-- Weather Synchronization Banner -->
    <?php if (isset($weather) && $weather): ?>
        <div class="weather-sync-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-2 text-primary">
                    <i class="<?= $weather['icon'] ?>"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                        <?= $weather['temp'] ?> &bull; <?= $weather['condition'] ?>
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-droplet me-1 text-info"></i>Rainfall Intensity: <strong><?= $weather['rainfall'] ?></strong>
                        <?php if ((float)str_replace('mm', '', $weather['rainfall']) > 20): ?>
                            <span class="badge bg-warning text-dark ms-2 rounded-pill">Heavy Precipitation</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <a href="/index.php?route=flood-monitoring" class="btn btn-sm rounded-pill px-3 py-2 text-white border-0 shadow-sm" style="background: var(--brand-gradient); font-weight: 600;">
                <i class="fas fa-water me-1"></i> Open Flood Monitoring Map
            </a>
        </div>
    <?php endif; ?>

    <!-- Main Alert Card Container -->
    <div class="main-alert-frame p-4 p-md-5">

        <!-- Barangay Selection Dropdown -->
        <div class="mb-4 pb-3 border-bottom">
            <label class="form-label fw-bold text-dark mb-2">
                <i class="fas fa-location-dot me-2 text-primary"></i> Select Barangay to Inspect
            </label>
            <form method="GET" action="/index.php" id="alertForm">
                <input type="hidden" name="route" value="alerts">
                <select name="barangay" class="form-select styled-barangay-select" onchange="this.form.submit()" required>
                    <option value="">-- Choose Barangay (e.g. Lizada, Dalio) --</option>
                    <?php foreach ($barangayList as $b): ?>
                        <option value="<?= htmlspecialchars($b) ?>" <?= ($barangay === $b) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <?php if ($barangay !== null): ?>
            <!-- Interactive Flood Map -->
            <div class="position-relative mb-4">
                <div id="map-alerts"></div>
                <div class="map-legend-overlay">
                    <div class="legend-item">
                        <span class="legend-indicator bg-Red"></span>
                        <span>Level 3 (Red / Critical)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-indicator bg-Orange"></span>
                        <span>Level 2 (Orange / Alert)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-indicator bg-Yellow"></span>
                        <span>Level 1 (Yellow / Warning)</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-indicator bg-Green"></span>
                        <span>Level 0 (Green / Safe)</span>
                    </div>
                </div>
            </div>

            <!-- Current Alert Level Broadcast Box -->
            <div class="alert-banner-box alert-box-<?= $alertColors[$barangayAlert] ?> mb-4 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="level-dot bg-<?= $alertColors[$barangayAlert] ?> animate-pulse"></span>
                    <h3 class="mb-0 fw-bold text-<?= $alertColors[$barangayAlert] ?>">
                        Barangay <?= htmlspecialchars($barangay) ?>: Level <?= $barangayAlert ?> &mdash; <?= strtoupper($alertColors[$barangayAlert]) ?>
                    </h3>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold mb-1 opacity-75 small text-uppercase" style="letter-spacing: 0.5px;">Official Broadcast Advisory:</h6>
                    <p class="mb-0 fs-5 fw-semibold">
                        <?= !empty($barangayAdvisory) ? htmlspecialchars($barangayAdvisory) : "No severe flood advisory currently issued for this location." ?>
                    </p>
                </div>

                <div class="p-3 bg-white bg-opacity-75 rounded-3 shadow-xs">
                    <h6 class="fw-bold mb-1 text-muted small text-uppercase">Emergency Protocol Action:</h6>
                    <p class="mb-0 small text-dark fw-medium"><?= $educationMsg[$barangayAlert] ?></p>
                </div>
            </div>

            <!-- Sitio-Level Alerts Grid -->
            <div class="mt-4 pt-2">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="fas fa-map-pin text-danger"></i>
                    <span>Sitio-Level Status Breakdown</span>
                </h5>

                <div class="row g-3">
                    <?php if (count($sitios) > 0): ?>
                        <?php foreach ($sitios as $s): ?>
                            <?php $sLevel = (int)($s['flood_level'] ?? 0); ?>
                            <div class="col-md-6">
                                <div class="sitio-alert-card" style="border-left: 4px solid var(--alert-<?= strtolower($alertColors[$sLevel]) ?>);">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($s['sitio_name']) ?></h6>
                                        <span class="status-pill-badge bg-<?= $alertColors[$sLevel] ?> text-white">
                                            <?= $alertColors[$sLevel] ?>
                                        </span>
                                    </div>
                                    <p class="small text-muted mb-0">
                                        <?= !empty($s['flood_advisory']) ? htmlspecialchars($s['flood_advisory']) : "Normal conditions reported." ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-4 bg-light rounded-4 text-muted small">
                                No sitio-level data recorded for Barangay <?= htmlspecialchars($barangay) ?>.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <!-- Global Active Alerts Summary -->
            <div class="mb-4">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="fas fa-bullhorn text-primary"></i>
                    <span>Active Alerts Across Partner Communities</span>
                </h5>

                <div class="row g-3">
                    <?php 
                    $activeCount = 0;
                    foreach ($allAlerts as $item): 
                        if ($item['alert_level'] > 0): 
                            $activeCount++;
                    ?>
                        <div class="col-md-6">
                            <a href="?route=alerts&barangay=<?= urlencode($item['name']) ?>" class="text-decoration-none">
                                <div class="sitio-alert-card" style="border-left: 4px solid var(--alert-<?= strtolower($alertColors[$item['alert_level']]) ?>);">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0">Barangay <?= htmlspecialchars($item['name']) ?></h6>
                                        <span class="status-pill-badge bg-<?= $alertColors[$item['alert_level']] ?> text-white">
                                            <?= strtoupper($alertColors[$item['alert_level']]) ?>
                                        </span>
                                    </div>
                                    <div class="text-muted small text-truncate">
                                        <?= $item['flood_advisory'] ?: 'Active alert currently in effect.' ?>
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
                            <div class="p-4 bg-light rounded-4 text-center">
                                <i class="fas fa-circle-check text-success fs-2 mb-2"></i>
                                <h6 class="fw-bold text-dark mb-1">All Partner Barangays Normal</h6>
                                <p class="text-muted small mb-0">No active flood warnings currently issued. Continue monitoring official weather feeds.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Guidance State -->
            <div class="text-center py-5 border-top">
                <div class="mb-3 text-primary opacity-50">
                    <i class="fas fa-map-location-dot fa-3x"></i>
                </div>
                <h5 class="fw-bold text-dark">Explore Geographic Information</h5>
                <p class="text-muted small max-w-md mx-auto" style="max-width: 480px;">
                    Select a barangay from the dropdown above to display boundary maps, hazard zones, and sitio-level warning markers.
                </p>
            </div>
        <?php endif; ?>

    </div>

</div>

<script>
function initMap() {
    var centerMap = <?= json_encode($mapCenter) ?>;
    var map = L.map('map-alerts').setView([centerMap.lat, centerMap.lng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    addLeafletFullscreenControl(map);
    const alertColors = { green: '#22c55e', yellow: '#eab308', orange: '#f97316', red: '#ef4444' };
    const alertIcon = (colorName, square = false) => {
        const color = alertColors[colorName] || alertColors.green;
        return L.divIcon({ className: 'alert-location-marker', html: `<span style="display:block;width:18px;height:18px;border:2px solid #fff;border-radius:${square ? '3px' : '50%'};background:${color};box-shadow:0 1px 5px #555"></span>`, iconSize: [18, 18], iconAnchor: [9, 9] });
    };

    var polygonCoords = <?= $polygonCoordsJS ?>;
    if (polygonCoords.length > 0) {
        L.polygon(polygonCoords, { color: '#4338ca', opacity: 0.8, weight: 2.5, fillColor: '#6366f1', fillOpacity: 0.15 }).addTo(map);
    }

    var sitios = <?= json_encode($sitios) ?>;
    var alertColorsMap = {0: 'green', 1: 'yellow', 2: 'orange', 3: 'red'};

    <?php if ($barangay !== null): ?>
    (function(){
        var brgyData = <?= json_encode(['name' => $barangay, 'level' => $barangayAlert, 'lat' => $mapCenter['lat'], 'lng' => $mapCenter['lng'], 'advisory' => $barangayAdvisory]) ?>;
        if (polygonCoords.length === 0 || (brgyData.lat !== 7.028 || brgyData.lng !== 125.448)) {
            var colorName = alertColorsMap[brgyData.level] || 'green';
            L.marker([brgyData.lat, brgyData.lng], { title: brgyData.name, icon: alertIcon(colorName, true), zIndexOffset: 1000 })
                .addTo(map).bindPopup(`
                    <div style="padding: 10px; max-width: 250px; font-family: 'Inter', sans-serif;">
                        <h6 class="fw-bold mb-1">${brgyData.name}</h6>
                        <div class="badge bg-${colorName.charAt(0).toUpperCase() + colorName.slice(1)} mb-2">${colorName.toUpperCase()}</div>
                        <div class="small">${brgyData.advisory || 'Normal conditions.'}</div>
                    </div>
                `);
        }
    })();
    <?php endif; ?>

    sitios.forEach(function(sitio) {
        if (sitio.latitude && sitio.longitude) {
            var level = parseInt(sitio.flood_level || 0);
            var colorName = alertColorsMap[level] || 'green';
            
            L.marker([parseFloat(sitio.latitude), parseFloat(sitio.longitude)], { title: sitio.sitio_name, icon: alertIcon(colorName) })
                .addTo(map).bindPopup(`
                    <div style="padding: 10px; max-width: 250px; font-family: 'Inter', sans-serif;">
                        <h6 class="fw-bold mb-1">${sitio.sitio_name}</h6>
                        <div class="badge bg-${colorName.charAt(0).toUpperCase() + colorName.slice(1)} mb-2">${colorName.toUpperCase()}</div>
                        <div class="small text-muted">${sitio.flood_advisory || 'Normal conditions.'}</div>
                    </div>
                `);
        }
    });
}
if (document.getElementById('map-alerts')) {
    initMap();
}
</script>
