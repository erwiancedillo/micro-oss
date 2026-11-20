<link href="/assets/css/flood_monitoring.css" rel="stylesheet">

<div class="container-fluid px-4 pt-4">
    <div class="page-header mb-4 me-3">
        <h1 class="page-title d-flex align-items-center">
            <i class="fas fa-water me-3 text-primary"></i>
            Flood Monitoring System
        </h1>
        <p class="text-muted">Real-time river sensors and flood risk assessment for Toril areas.</p>
    </div>
</div>

<div class="flood-dashboard">
    <div class="map-card">
        <div id="map"></div>
    </div>

        <!-- Floating Side Panel -->
        <div class="side-panel">
            <!-- Weather Widget -->
            <div class="glass-panel">
                <div class="panel-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-cloud-sun"></i> Weather Overview</span>
                    <span class="badge bg-success rounded-pill" style="font-size: 0.6rem; letter-spacing: 0.5px;">LIVE</span>
                </div>
                <div class="weather-widget">
                    <div class="weather-info">
                        <p class="mb-1"><?= $weather['condition'] ?></p>
                        <h2><?= $weather['temp'] ?></h2>
                        <p><i class="fas fa-tint me-1"></i> Rain: <?= $weather['rainfall'] ?></p>
                    </div>
                    <div class="weather-icon">
                        <i class="<?= $weather['icon'] ?>"></i>
                    </div>
                </div>
            </div>

            <!-- Sensor Stream -->
            <div class="glass-panel mt-3">
                <div class="panel-title">
                    <i class="fas fa-broadcast-tower"></i> Live River Sensors
                </div>
                <div class="sensor-list">
                    <?php foreach($sensors as $sensor): ?>
                        <div class="sensor-item">
                            <div class="sensor-header">
                                <span class="sensor-name"><?= $sensor['name'] ?></span>
                                <span class="sensor-value"><?= $sensor['level'] ?></span>
                            </div>
                            <div class="sensor-meta">
                                <span class="badge-status status-<?= strtolower($sensor['status']) ?>">
                                    <?= $sensor['status'] ?>
                                </span>
                                <span class="text-muted">
                                    <i class="fas <?= $sensor['trend'] === 'Rising' ? 'fa-arrow-up text-danger' : ($sensor['trend'] === 'Falling' ? 'fa-arrow-down text-success' : 'fa-minus') ?> me-1"></i>
                                    <?= $sensor['trend'] ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Legend Panel -->
        <div class="bottom-panel glass-panel py-2 px-3">
            <div class="legend-grid">
                <div class="legend-item">
                    <div class="color-box" style="background: rgba(255, 0, 0, 0.4); border: 2px solid red;"></div>
                    High Risk Zone
                </div>
                <div class="legend-item">
                    <div class="color-box" style="background: rgba(255, 165, 0, 0.4); border: 2px solid orange;"></div>
                    Moderate Risk Zone
                </div>
                <div class="legend-item">
                    <div class="color-box" style="background: rgba(0, 128, 0, 0.4); border: 2px solid green;"></div>
                    Low Risk Zone
                </div>
                <div class="legend-item">
                    <div class="color-box" style="background: #319795;"></div>
                    Safe Zone
                </div>
                <div class="legend-item">
                    <div class="color-box" style="background: #ef4444; border-radius: 50%;"></div>
                    Red Alert (Brgy)
                </div>
                <div class="legend-item">
                    <div class="color-box" style="background: #eab308; border-radius: 50%;"></div>
                    Yellow Alert (Brgy)
                </div>
            </div>
        </div>


        <!-- OpenWeatherMap Layer Control -->
        <div class="map-controls-group glass-panel">
            <div class="control-section border-bottom pb-2 mb-2">
                <div class="owm-control-header">
                    <i class="fas fa-map"></i>
                    <span>Basemap</span>
                </div>
                <div class="map-type-buttons">
                    <button class="map-type-btn active" data-type="roadmap" title="Road Map">
                        <i class="fas fa-road"></i>
                        <span>Map</span>
                    </button>
                    <button class="map-type-btn" data-type="satellite" title="Satellite View">
                        <i class="fas fa-satellite"></i>
                        <span>Satellite</span>
                    </button>
                </div>
            </div>
            <div class="control-section">
                <div class="owm-control-header">
                    <i class="fas fa-layer-group"></i>
                    <span>Weather Layers</span>
                </div>
                <div class="owm-layer-buttons">
                    <button class="owm-layer-btn" data-layer="precipitation_new" title="Precipitation">
                        <i class="fas fa-cloud-rain"></i>
                        <span>Rain</span>
                    </button>
                    <button class="owm-layer-btn" data-layer="clouds_new" title="Cloud Cover">
                        <i class="fas fa-cloud"></i>
                        <span>Clouds</span>
                    </button>
                    <button class="owm-layer-btn" data-layer="temp_new" title="Temperature">
                        <i class="fas fa-thermometer-half"></i>
                        <span>Temp</span>
                    </button>
                    <button class="owm-layer-btn" data-layer="wind_new" title="Wind Speed">
                        <i class="fas fa-wind"></i>
                        <span>Wind</span>
                    </button>
                    <button class="owm-layer-btn" data-layer="pressure_new" title="Pressure">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Pressure</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Active Alerts Overlay (Left Side) -->
        <div class="alerts-overlay">
            <div class="glass-panel">
                <div class="panel-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-exclamation-triangle"></i> Active Alerts</span>
                    <a href="/index.php?route=alerts" class="btn btn-sm btn-outline-primary rounded-pill" style="font-size: 0.65rem; padding: 0.2rem 0.6rem;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <!-- Alert Summary Badges -->
                <div class="d-flex gap-2 mb-2 flex-wrap">
                    <?php foreach(['Red' => 'danger', 'Orange' => 'warning', 'Yellow' => 'info', 'Green' => 'success'] as $color => $bs): ?>
                        <div class="alert-summary-badge bg-<?= $bs ?> bg-opacity-10 border border-<?= $bs ?> rounded-pill px-2 py-1 d-flex align-items-center gap-1" style="font-size: 0.7rem;">
                            <span class="fw-bold text-<?= $bs ?>"><?= $alertSummary[$color] ?></span>
                            <span class="text-<?= $bs ?>" style="opacity: 0.8;"><?= $color ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Non-green alert list -->
                <div class="alert-scroll-list" style="max-height: 120px; overflow-y: auto; scrollbar-width: thin;">
                    <?php 
                    $activeAlerts = array_filter($barangayAlerts, fn($a) => $a['level'] > 0);
                    if (count($activeAlerts) > 0): 
                        foreach ($activeAlerts as $a): 
                            $badgeClass = match($a['color']) {
                                'Red' => 'bg-danger',
                                'Orange' => 'bg-warning text-dark',
                                'Yellow' => 'bg-info text-dark',
                                default => 'bg-success'
                            };
                    ?>
                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom" style="border-color: rgba(0,0,0,0.05) !important; font-size: 0.8rem;">
                            <a href="/index.php?route=alerts&barangay=<?= urlencode($a['name']) ?>" class="text-decoration-none text-dark fw-medium">
                                <?= htmlspecialchars($a['name']) ?>
                            </a>
                            <span class="badge <?= $badgeClass ?> rounded-pill" style="font-size: 0.6rem;">
                                <?= strtoupper($a['color']) ?>
                            </span>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="text-center py-2">
                            <small class="text-success"><i class="fas fa-check-circle me-1"></i>All barangays are clear</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</div>

    <!-- Detailed Weekly Forecast Section -->
    <div class="container-fluid px-4 py-4">
        <div class="row mt-5">
            <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-calendar-week me-2 text-primary"></i>Weekly Weather Outlook
                    </h5>
                    <span class="badge bg-light text-dark border rounded-pill px-3">Toril, Davao City</span>
                </div>
                <div class="card-body p-0">
                    <!-- Desktop Table View -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover align-middle mb-0 forecast-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 small text-uppercase fw-bold text-muted">Day</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-muted text-center">Condition</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-muted text-center">Temp Max/Min</th>
                                    <th class="py-3 border-0 small text-uppercase fw-bold text-muted text-center">Precipitation</th>
                                    <th class="pe-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Atmospheric Risk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($forecast as $day): ?>
                                    <tr class="forecast-row">
                                        <td class="ps-4" data-label="Day">
                                            <div class="fw-bold"><?= $day['day'] ?></div>
                                            <div class="small text-muted"><?= $day['date'] ?></div>
                                        </td>
                                        <td class="text-center" data-label="Condition">
                                            <div class="fs-4 mb-1"><i class="<?= $day['icon'] ?> text-primary"></i></div>
                                            <div class="small fw-medium"><?= $day['text'] ?></div>
                                        </td>
                                        <td class="text-center" data-label="Temp Max/Min">
                                            <span class="fw-bold fs-5 text-dark"><?= $day['temp_max'] ?></span>
                                            <span class="text-muted ms-1">/ <?= $day['temp_min'] ?></span>
                                        </td>
                                        <td class="text-center" data-label="Precipitation">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <i class="fas fa-tint text-info"></i>
                                                <span class="fw-bold"><?= $day['rain'] ?></span>
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end" data-label="Atmospheric Risk">
                                            <?php 
                                                $rainVal = (float)str_replace('mm', '', $day['rain']);
                                                if ($rainVal > 50) echo '<span class="badge bg-danger rounded-pill px-3">High Flood Risk</span>';
                                                elseif ($rainVal > 20) echo '<span class="badge bg-warning text-dark rounded-pill px-3">Notice Needed</span>';
                                                else echo '<span class="badge bg-success rounded-pill px-3">Low Risk</span>';
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Auto-Play Swipeable Carousel View -->
                    <div id="mobileForecastCarousel" class="carousel slide d-block d-md-none py-4 bg-light" data-bs-ride="carousel" data-bs-interval="3500">
                        <div class="carousel-inner">
                            <?php $isActive = true; foreach($forecast as $day): ?>
                                <div class="carousel-item <?= $isActive ? 'active' : '' ?>">
                                    <?php $isActive = false; ?>
                                    <div class="card border-0 shadow-sm mx-auto" style="border-radius: 1.25rem; width: 85%; background: #ffffff;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                                <div>
                                                    <div class="fw-bold fs-4 text-dark"><?= $day['day'] ?></div>
                                                    <div class="small text-muted fw-medium"><?= $day['date'] ?></div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="fs-1 mb-1"><i class="<?= $day['icon'] ?> text-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;"></i></div>
                                                    <div class="small fw-bold text-muted text-uppercase tracking-wide" style="font-size: 0.7rem;"><?= $day['text'] ?></div>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3 mt-1">
                                                <div class="col-6">
                                                    <span class="d-block small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Temp</span>
                                                    <span class="fw-bold fs-4 text-dark"><?= $day['temp_max'] ?></span>
                                                    <span class="text-muted fw-medium fs-6">/ <?= $day['temp_min'] ?></span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="d-block small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Precip</span>
                                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                                        <i class="fas fa-tint text-info fs-5"></i>
                                                        <span class="fw-bold fs-4 text-dark"><?= $day['rain'] ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3 text-center">
                                                    <?php 
                                                        $rainVal = (float)str_replace('mm', '', $day['rain']);
                                                        if ($rainVal > 50) echo '<span class="badge bg-danger rounded-pill px-4 py-2 w-100 fw-bold shadow-sm" style="font-size: 0.85rem;"><i class="fas fa-exclamation-triangle me-2"></i>High Flood Risk</span>';
                                                        elseif ($rainVal > 20) echo '<span class="badge bg-warning text-dark rounded-pill px-4 py-2 w-100 fw-bold shadow-sm" style="font-size: 0.85rem;"><i class="fas fa-exclamation-circle me-2"></i>Notice Needed</span>';
                                                        else echo '<span class="badge bg-success rounded-pill px-4 py-2 w-100 fw-bold shadow-sm" style="font-size: 0.85rem;"><i class="fas fa-check-circle me-2"></i>Low Risk</span>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Carousel Status Indicators -->
                        <div class="carousel-indicators position-relative mt-4 mb-0 pb-2">
                            <?php $idx = 0; foreach($forecast as $day): ?>
                                <button type="button" data-bs-target="#mobileForecastCarousel" data-bs-slide-to="<?= $idx ?>" class="<?= $idx === 0 ? 'active' : '' ?> bg-primary rounded-circle shadow-sm" style="width: 8px; height: 8px;" aria-current="true"></button>
                            <?php $idx++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-center">
                    <small class="text-muted">Data precisely synchronized from OpenWeather API</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/floodzones.js"></script>
<script>
    let map;
    const defaultCenter = { lat: 7.028012, lng: 125.447948 }; // Toril Center

    function initMap() {
        map = L.map('map').setView([defaultCenter.lat, defaultCenter.lng], 13);
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19, attribution: 'Tiles &copy; Esri'
        });
        addLeafletFullscreenControl(map);
        let currentBaseLayer = streetLayer;
        const dotIcon = (color, size = 16) => L.divIcon({
            className: 'leaflet-alert-marker',
            html: `<span style="display:block;width:${size}px;height:${size}px;border:2px solid #fff;border-radius:50%;background:${color};box-shadow:0 1px 5px #555"></span>`,
            iconSize: [size, size], iconAnchor: [size / 2, size / 2]
        });

        // Load flood zones using the existing JS function
        if (typeof loadFloodZones === 'function') {
            loadFloodZones();
        }

        // Add Weather Control to Map
        const weatherControl = document.createElement('div');
        weatherControl.innerHTML = `
            <div class="map-weather-badge glass-panel m-3 p-2 d-flex align-items-center gap-2 shadow-sm" style="background: rgba(255,255,255,0.9); border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; pointer-events: none;">
                <div class="fs-4 text-primary"><i class="<?= $weather['icon'] ?>"></i></div>
                <div>
                    <div class="fw-bold" style="font-size: 0.85rem; line-height: 1;"><?= $weather['temp'] ?></div>
                    <div class="text-muted" style="font-size: 0.7rem;"><?= $weather['condition'] ?></div>
                </div>
            </div>
        `;
        const weatherControlInstance = L.control({ position: 'topright' });
        weatherControlInstance.onAdd = function() {
            const container = L.DomUtil.create('div');
            container.innerHTML = weatherControl.innerHTML;
            return container;
        };
        weatherControlInstance.addTo(map);

        // --- OpenWeatherMap Tile Layer Integration ---
        const OWM_KEY = '<?= $openWeatherKey ?>';
        let activeOWMOverlay = null;
        let activeLayerName = null;

        function createOWMLayer(layerName) {
            return L.tileLayer(`https://tile.openweathermap.org/map/${layerName}/{z}/{x}/{y}.png?appid=${OWM_KEY}`, { opacity: 0.6, attribution: '&copy; OpenWeatherMap' });
        }

        // Toggle OWM weather layer
        function toggleOWMLayer(layerName, btn) {
            // If clicking the same layer, just turn it off
            if (activeLayerName === layerName) {
                if (activeOWMOverlay) {
                    map.removeLayer(activeOWMOverlay);
                    activeOWMOverlay = null;
                }
                activeLayerName = null;
                btn.classList.remove('active');
                return;
            }

            // Remove existing overlay
            if (activeOWMOverlay) {
                map.removeLayer(activeOWMOverlay);
                activeOWMOverlay = null;
            }

            // Deactivate all buttons
            document.querySelectorAll('.owm-layer-btn').forEach(b => b.classList.remove('active'));

            // Add new overlay
            activeOWMOverlay = createOWMLayer(layerName);
            activeOWMOverlay.addTo(map);
            activeLayerName = layerName;
            btn.classList.add('active');
        }

        // Initialize OWM Layer Control
        document.querySelectorAll('.owm-layer-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                toggleOWMLayer(this.dataset.layer, this);
            });
        });

        // --- Map Type Switching ---
        function setMapType(type, btn) {
            const nextLayer = type === 'satellite' ? satelliteLayer : streetLayer;
            if (currentBaseLayer !== nextLayer) {
                map.removeLayer(currentBaseLayer);
                currentBaseLayer = nextLayer.addTo(map);
            }
            document.querySelectorAll('.map-type-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        document.querySelectorAll('.map-type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                setMapType(this.dataset.type, this);
            });
        });

        // --- Barangay Alert Markers ---
        const alertColorMap = {
            'Green':  '#22c55e',
            'Yellow': '#eab308',
            'Orange': '#f97316',
            'Red':    '#ef4444'
        };

        const barangayAlerts = <?= json_encode($barangayAlerts) ?>;
        barangayAlerts.forEach(alert => {
            if (!alert.lat || !alert.lng) return;

            const color = alertColorMap[alert.color] || '#22c55e';
            L.marker([alert.lat, alert.lng], { title: alert.name + ' — ' + alert.color + ' Alert', icon: dotIcon(color, alert.level > 0 ? 20 : 14), zIndexOffset: (alert.level + 1) * 10 })
                .addTo(map).bindPopup((() => {
                const advisory = alert.advisory || 'No advisory issued.';
                return `
                    <div style="max-width: 220px; font-family: 'Inter', sans-serif;">
                        <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 4px;">${alert.name}</div>
                        <div style="display: inline-block; background: ${color}; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; margin-bottom: 6px;">
                            ${alert.color.toUpperCase()} ALERT
                        </div>
                        <p style="font-size: 0.8rem; color: #555; margin: 6px 0 8px;">${advisory}</p>
                        <a href="/index.php?route=alerts&barangay=${encodeURIComponent(alert.name)}" 
                           style="font-size: 0.75rem; color: #667eea; text-decoration: none; font-weight: 600;">
                            View Full Alert Details â†’
                        </a>
                    </div>
                `;
            })());
        });

        // --- Barangay Polygons (Areas) ---
        const barangayPolygonsRaw = <?= json_encode($barangayPolygons) ?>;
        
        function parseWKT(wkt) {
            if (!wkt) return null;
            const match = wkt.match(/\(\((.*)\)\)/);
            if (!match) return null;
            const points = match[1].split(',');
            return points.map(p => {
                const pair = p.trim().split(/\s+/);
                return { lat: parseFloat(pair[0]), lng: parseFloat(pair[1]) };
            });
        }

        barangayPolygonsRaw.forEach(bp => {
            const paths = parseWKT(bp.polygon);
            if (!paths) return;

            const polygon = L.polygon(paths, { color: '#4a5568', opacity: 0.5, weight: 1, fillColor: '#667eea', fillOpacity: 0.1 }).addTo(map);

            // Add basic interaction: highlight on hover
            polygon.on('mouseover', function() { this.setStyle({ fillOpacity: 0.2, weight: 2 }); });
            polygon.on('mouseout', function() { this.setStyle({ fillOpacity: 0.1, weight: 1 }); });

            // Clicking the area shows the barangay name
            polygon.bindPopup(`<div style="padding: 10px; font-weight: 700;">Barangay ${bp.name} Zone</div>`);
        });
        
        // --- Evacuation Centers ---
        const evacuationCenters = <?= json_encode($evacuationCenters) ?>;
        const evacMarkers = [];

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        evacuationCenters.forEach(evac => {
            const marker = L.marker([parseFloat(evac.latitude), parseFloat(evac.longitude)], { title: evac.name, icon: dotIcon('#16a34a', 20) }).addTo(map);
            marker.bindPopup(`
                    <div style="max-width: 250px; font-family: 'Inter', sans-serif;">
                        <div style="font-weight: 700; font-size: 1rem; margin-bottom: 4px; color: #2d3748;">${evac.name}</div>
                        <div style="background: ${evac.status === 'Full' ? '#f56565' : '#48bb78'}; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; margin-bottom: 8px;">
                            ${evac.status.toUpperCase()}
                        </div>
                        <div style="font-size: 0.85rem; color: #4a5568; margin-bottom: 12px;">
                            Capacity: ${evac.occupied}/${evac.capacity} persons
                        </div>
                        <a href="https://www.openstreetmap.org/directions?to=${encodeURIComponent(evac.latitude)},${encodeURIComponent(evac.longitude)}" target="_blank" rel="noopener" class="btn btn-primary btn-sm w-100 py-2 rounded-3 fw-bold" style="background: #3182ce; border: none; font-size: 0.8rem; color: white; display: block; text-align: center; text-decoration: none;">
                            <i class="fas fa-directions me-2"></i>Navigate to Center
                        </a>
                    </div>
                `);

            evacMarkers.push({ marker, data: evac });
        });

        // --- Citizen Science Reports ---
        const citizenReports = <?= json_encode($citizenReports ?? []) ?>;
        citizenReports.forEach(report => {
            if (!report.latitude || !report.longitude) return;
            L.marker([parseFloat(report.latitude), parseFloat(report.longitude)], { title: report.category, icon: dotIcon('#f97316', 20) }).addTo(map)
                .bindPopup((() => {
                const imgTag = report.image ? `<img src="/assets/uploads/citizen_science/${report.image}" style="width:100%; border-radius:5px; margin-top:5px; max-height:100px; object-fit:cover;">` : '';
                return `<div style="font-family:Inter,sans-serif; max-width: 200px;">
                        <h6 style="color:#f97316; font-weight:bold; margin-bottom:2px;"><i class="fas fa-camera me-1"></i>${report.category}</h6>
                        <p style="font-size:12px; margin-bottom:5px;">${report.description}</p>
                        <small style="color:#666; display:block;">By: ${report.first_name} | ${report.status}</small>
                        ${imgTag}
                    </div>`;
            })());
        });

        // Show user location if available and find nearest evac center
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLocation = { 
                    lat: position.coords.latitude, 
                    lng: position.coords.longitude 
                };

                L.circleMarker([userLocation.lat, userLocation.lng], { radius: 8, color: '#fff', weight: 3, fillColor: '#2563eb', fillOpacity: 1 }).addTo(map).bindTooltip('Your Location');

                // Find nearest evacuation center if any exist
                if (evacMarkers.length > 0) {
                    let nearest = null;
                    let minDistance = Infinity;

                    evacMarkers.forEach(item => {
                        const dist = calculateDistance(
                            userLocation.lat, userLocation.lng,
                            item.data.latitude, item.data.longitude
                        );
                        if (dist < minDistance) {
                            minDistance = dist;
                            nearest = item;
                        }
                    });

                    if (nearest) {
                        nearest.marker.openPopup();
                        map.panTo(nearest.marker.getLatLng());
                    }
                }
            });
        }
    }

    // --- Map Download Feature ---
    document.getElementById('downloadMapBtn')?.addEventListener('click', function() {
        const btn = this;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Capturing...';
        btn.disabled = true;

        const mapElement = document.getElementById('map');
        
        // Wait a bit for map to stabilize if layers were just turned on
        setTimeout(() => {
            html2canvas(mapElement, {
                useCORS: true,
                allowTaint: true,
                backgroundColor: null,
                scale: 2 // Higher quality
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `flood-monitoring-map-${new Date().toISOString().slice(0,10)}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
                
                btn.innerHTML = '<i class="fas fa-check"></i> Downloaded';
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }, 2000);
            }).catch(err => {
                console.error('Capture failed:', err);
                alert('Could not capture the map. Please try again.');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            });
        }, 500);
    });

    initMap();
</script>

