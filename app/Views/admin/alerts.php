<!-- Admin POV - Flood Alert Management (Micro OSS Modern Purple/Indigo Theme) -->
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

    .admin-layout {
        display: flex;
        min-height: calc(100vh - 70px);
        background: #f8fafc;
    }

    .admin-main {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
    }

    /* Top Banner Header */
    .dashboard-header-banner {
        background: linear-gradient(135deg, #0f142b 0%, #171d42 100%);
        border-radius: var(--card-radius);
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        box-shadow: 0 12px 30px -5px rgba(15, 20, 43, 0.35);
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .dashboard-header-banner::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.3), transparent 70%);
        pointer-events: none;
    }

    .header-badge-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(102, 126, 234, 0.2);
        border: 1px solid rgba(139, 92, 246, 0.3);
        color: #c084fc;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .pulse-dot-red {
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        animation: pulseRed 1.8s infinite;
    }

    @keyframes pulseRed {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .dashboard-title-text {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 0.25rem;
    }

    .dashboard-title-text .highlight-purple {
        background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-gradient-primary {
        background: var(--brand-gradient);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 0.65rem 1.4rem;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 18px rgba(118, 75, 162, 0.35);
        transition: all 0.22s ease;
    }

    .btn-gradient-primary:hover {
        background: var(--brand-gradient-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(118, 75, 162, 0.45);
    }

    /* Table Container Card */
    .table-container-card {
        background: #ffffff;
        border-radius: var(--card-radius);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table thead th {
        background-color: #f8fafc;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        padding: 1.1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table tbody td {
        padding: 1.1rem 1.25rem;
        font-size: 0.875rem;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .level-badge {
        padding: 5px 14px;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .level-0 { background: #ecfdf5; color: #047857; border: 1px solid rgba(16, 185, 129, 0.2); }
    .level-1 { background: #fffbeb; color: #b45309; border: 1px solid rgba(245, 158, 11, 0.2); }
    .level-2 { background: #fff7ed; color: #c2410c; border: 1px solid rgba(249, 115, 22, 0.2); }
    .level-3 { background: #fef2f2; color: #b91c1c; border: 1px solid rgba(239, 68, 68, 0.2); }

    /* Search Input */
    .table-search-input {
        height: 42px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 0 14px 0 38px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: #f8fafc;
        width: 260px;
    }

    .table-search-input:focus {
        border-color: var(--brand-primary);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
        outline: none;
    }

    /* Modal / Edit Overlay */
    .panel-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(6px);
        z-index: 1060;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .panel-content {
        background: #ffffff;
        width: 100%;
        max-width: 540px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 24px;
        padding: 2.25rem 2rem;
        box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .type-tab {
        flex: 1;
        text-align: center;
        padding: 0.75rem 1rem;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.875rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        color: #64748b;
    }

    .type-tab.active {
        background: var(--brand-gradient);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(118, 75, 162, 0.3);
    }

    .form-input-styled {
        height: 46px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 0.875rem;
        color: #0f172a;
        background: #ffffff;
        transition: all 0.2s ease;
        width: 100%;
    }

    .form-input-styled:focus {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3.5px rgba(102, 126, 234, 0.12);
        outline: none;
    }

    #map {
        height: 240px;
        width: 100%;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        border: 1px solid #e2e8f0;
    }

    #locationStatus {
        font-size: 0.775rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .status-valid   { color: var(--alert-green); }
    .status-invalid { color: var(--alert-red); }
    .status-warning { color: var(--alert-orange); }
</style>

<div class="admin-layout">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="admin-main">

        <!-- Top Banner Header -->
        <div class="dashboard-header-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="header-badge-tag">
                    <span class="pulse-dot-red"></span>
                    <span>Emergency Warning Dispatcher</span>
                </div>
                <h1 class="dashboard-title-text">
                    Flood Alert <span class="highlight-purple">Management</span>
                </h1>
                <p class="text-white-50 mb-0 small">
                    Issue real-time flood warning signals, broadcast advisories, and manage sitio locations.
                </p>
            </div>
            <div class="d-flex gap-2">
                <button id="addAlertBtn" class="btn btn-gradient-primary">
                    <i class="fas fa-plus"></i>
                    <span>New Alert Signal</span>
                </button>
            </div>
        </div>

        <!-- Alert Cards & Directory Table -->
        <div class="table-container-card">
            <div class="p-4 bg-white d-flex justify-content-between align-items-center flex-wrap gap-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="stats-icon mb-0" style="width: 2.5rem; height: 2.5rem; border-radius: 10px; background: #eef2ff; color: #667eea; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Active Alerts Directory</h5>
                        <small class="text-muted">Broadcast statuses across partner barangays and sitios</small>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="position-relative">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;"></i>
                    <input type="text" class="table-search-input" id="alertSearchInput" placeholder="Filter alerts..." oninput="filterAlertsTable()">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="alertsTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Barangay / Sitio</th>
                            <th>Alert Level</th>
                            <th>Broadcast Advisory</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamically populated via JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="message" class="mt-2 text-danger small"></div>
    </main>
</div>

<!-- Modal / Edit Alert Overlay -->
<div id="editOverlay" class="panel-overlay">
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <div style="width: 32px; height: 32px; border-radius: 10px; background: #eef2ff; color: #667eea; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark" id="panelTitle">Modify Alert Status</h4>
            </div>
            <button class="btn btn-light rounded-circle border" id="cancelBtn" style="width: 36px; height: 36px;">
                <i class="fas fa-times text-muted"></i>
            </button>
        </div>

        <!-- Alert Type Toggle -->
        <div class="d-flex bg-light p-1 rounded-3 mb-4 border" id="typeToggle">
            <div class="type-tab active" data-type="barangay">Barangay Level</div>
            <div class="type-tab" data-type="sitio">Sitio / Specific Area</div>
        </div>

        <div id="locationModeBanner" class="alert alert-primary border-0 rounded-3 mb-3 py-2 px-3 small" style="display:none; background: #eef2ff; color: #4338ca;">
            <i class="fas fa-map-pin me-2"></i> Click on the map to pin exact coordinates.
        </div>

        <div id="map"></div>
        <div id="locationStatus" class="mb-3 px-1"></div>

        <input type="hidden" id="fldId">

        <div class="d-grid gap-3">
            <button type="button" class="btn btn-light btn-sm fw-bold py-2 border rounded-3" id="detectLocBtn" style="color: #667eea;">
                <i class="fas fa-crosshairs me-2"></i>Use My Current Location
            </button>

            <div class="row g-3">
                <div class="col-12" id="parentBarangayGroup" style="display:none;">
                    <label class="form-label small fw-bold text-muted">Parent Barangay</label>
                    <select id="fldParent" class="form-input-styled">
                        <option value="">-- Select Parent Barangay --</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold text-muted" id="nameLabel">Barangay Name</label>
                    <div class="input-group">
                        <input type="text" class="form-input-styled rounded-end-0" id="fldName" placeholder="e.g. Lizada">
                        <button type="button" id="detectInfoBtn" class="btn btn-light border border-start-0 rounded-end-3" title="Sync from GPS coordinates">
                            <i class="fas fa-sync-alt text-muted"></i>
                        </button>
                    </div>
                </div>

                <div class="col-12" id="addressGroup">
                    <label class="form-label small fw-bold text-muted">Display Address / Coverage Details</label>
                    <input type="text" id="fldAddress" class="form-input-styled" placeholder="Additional location info">
                </div>

                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Latitude</label>
                    <input type="number" id="fldLat" class="form-input-styled" step="0.000001">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Longitude</label>
                    <input type="number" id="fldLng" class="form-input-styled" step="0.000001">
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Alert Level</label>
                    <select id="fldLevel" class="form-input-styled">
                        <option value="0">Level 0: SAFE (Green)</option>
                        <option value="1">Level 1: WARNING (Yellow)</option>
                        <option value="2">Level 2: ALERT (Orange)</option>
                        <option value="3">Level 3: CRITICAL (Red)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Broadcast Advisory Notice</label>
                    <textarea id="fldAdvisory" class="form-input-styled" style="height: auto; min-height: 80px; padding: 10px 14px;" rows="3" placeholder="What actions should community members take?"></textarea>
                </div>
            </div>

            <button class="btn btn-gradient-primary w-100 py-3 rounded-3 mt-3 shadow-sm justify-content-center" id="saveBtn">
                <i class="fas fa-paper-plane me-2"></i> Push Alert Update
            </button>
        </div>
    </div>
</div>

<script>
    let allBarangays = [], allSitios = [];
    let currentType = 'barangay';

    async function fetchAlerts() {
        const res = await fetch('/api/get-alerts.php');
        const data = await res.json();
        allBarangays = data.barangays || [];
        allSitios = data.sitios || [];
        buildTable();
        populateParentDropdown();
    }

    function populateParentDropdown() {
        const select = document.getElementById('fldParent');
        const currentVal = select.value;
        select.innerHTML = '<option value="">-- Select Parent Barangay --</option>';
        allBarangays.forEach(b => {
            const opt = document.createElement('option');
            opt.value = b.name;
            opt.innerText = b.name;
            select.appendChild(opt);
        });
        select.value = currentVal;
    }

    function buildTable(filteredBarangays, filteredSitios) {
        const tbody = document.querySelector('#alertsTable tbody');
        tbody.innerHTML = '';

        const bList = filteredBarangays || allBarangays;
        const sList = filteredSitios || allSitios;

        if (bList.length === 0 && sList.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">No alerts match the filter.</td></tr>`;
            return;
        }

        bList.forEach(item => appendRow(tbody, item, 'barangay'));
        sList.forEach(item => appendRow(tbody, item, 'sitio'));
    }

    function appendRow(tbody, item, type) {
        const tr = document.createElement('tr');
        const level = item.alert_level !== undefined ? item.alert_level : item.flood_level;
        const levelText = getLevelText(level);
        const name = item.name || item.sitio_name;
        const address = type === 'barangay' ? (item.full_address || 'District Center') : `Sitio in ${item.barangay}`;
        const advisory = item.flood_advisory || 'Normal conditions. No active advisory.';

        tr.innerHTML = `
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-2 rounded-3" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: ${type === 'barangay' ? '#eef2ff' : '#faf5ff'}; color: ${type === 'barangay' ? '#667eea' : '#8b5cf6'};">
                        <i class="fas ${type === 'barangay' ? 'fa-building' : 'fa-map-pin'}"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">${name}</div>
                        <div class="small text-muted">${address}</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="level-badge level-${level}">
                    <i class="fas fa-circle" style="font-size: 6px;"></i> Level ${level}: ${levelText}
                </span>
            </td>
            <td>
                <div class="text-truncate small text-dark" style="max-width: 280px;" title="${advisory}">${advisory}</div>
            </td>
            <td class="text-end pe-4">
                <button class="btn btn-sm rounded-pill px-3 text-white border-0 shadow-sm" style="background: var(--brand-gradient); font-size: 0.775rem;" onclick='openEditFromData(${JSON.stringify({ ...item, _type: type }).replace(/'/g, "&apos;")})'>
                    <i class="fas fa-edit me-1"></i> Update
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function filterAlertsTable() {
        const query = document.getElementById('alertSearchInput').value.toLowerCase().trim();
        const filteredB = allBarangays.filter(b => (b.name || '').toLowerCase().includes(query) || (b.flood_advisory || '').toLowerCase().includes(query));
        const filteredS = allSitios.filter(s => (s.sitio_name || '').toLowerCase().includes(query) || (s.barangay || '').toLowerCase().includes(query) || (s.flood_advisory || '').toLowerCase().includes(query));
        buildTable(filteredB, filteredS);
    }

    function getLevelText(n) {
        switch (+n) {
            case 0: return 'Safe';
            case 1: return 'Warning';
            case 2: return 'Alert';
            case 3: return 'Critical';
        }
        return 'Safe';
    }

    let map, marker, currentPolygon;

    function initMap() {
        map = L.map('map').setView([7.028, 125.448], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        marker = L.marker([7.028, 125.448], { draggable: true }).addTo(map);
        marker.setOpacity(0);
        map.on('click', (e) => {
            setAutoCoords(e.latlng.lat, e.latlng.lng);
        });
        marker.on('dragend', (e) => {
            setAutoCoords(e.target.getLatLng().lat, e.target.getLatLng().lng);
        });

        ['fldLat', 'fldLng'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                const lat = parseFloat(document.getElementById('fldLat').value);
                const lng = parseFloat(document.getElementById('fldLng').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]).setOpacity(1);
                    map.panTo([lat, lng]);
                    validateLocation(lat, lng);
                }
            });
        });
    }

    async function validateLocation(lat, lng, skipReverseGeocode = false) {
        const statusEl = document.getElementById('locationStatus');
        const pos = { lat: parseFloat(lat), lng: parseFloat(lng) };

        if (currentType === 'sitio') {
            const parentBrgy = document.getElementById('fldParent').value;
            if (parentBrgy) {
                if (!currentPolygon || currentPolygon._name !== parentBrgy) {
                    const res = await fetch(`/api/get-barangay-polygon.php?name=${encodeURIComponent(parentBrgy)}`);
                    const data = await res.json();
                    if (data.success) {
                        if (window._activePolygon) map.removeLayer(window._activePolygon);
                        window._activePolygon = L.polygon(data.polygon, {
                            color: '#667eea', opacity: 0.6, weight: 1.5, fillColor: '#667eea', fillOpacity: 0.12
                        }).addTo(map);
                        currentPolygon = window._activePolygon;
                        currentPolygon._name = parentBrgy;
                        currentPolygon._coords = data.polygon;
                    }
                }

                if (currentPolygon) {
                    const isInside = pointInRing({ lat: Number(lat), lng: Number(lng) }, currentPolygon._coords);
                    if (isInside) {
                        statusEl.innerHTML = '<i class="fas fa-check-circle status-valid me-1"></i> Location confirmed inside ' + parentBrgy;
                    } else {
                        statusEl.innerHTML = '<i class="fas fa-exclamation-triangle status-warning me-1"></i> Warning: Location is outside ' + parentBrgy;
                    }
                }
            } else {
                statusEl.innerHTML = '<i class="fas fa-info-circle text-primary me-1"></i> Select a parent barangay to verify boundary.';
            }
        } else {
            statusEl.innerHTML = '<i class="fas fa-location-arrow text-primary me-1"></i> Point selected.';
        }

        if (!skipReverseGeocode) {
            try {
                const address = await mapServices.reverseGeocode(pos.lat, pos.lng);
                if (address.formatted_address) statusEl.innerHTML += `<div class="mt-1 opacity-75 small"><i class="fas fa-map-marker-alt me-1"></i> ${address.formatted_address}</div>`;
            } catch (error) {
                console.warn('Reverse geocoding unavailable:', error);
            }
        }
    }

    function pointInRing(point, ring) {
        let inside = false;
        for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
            const a = ring[i], b = ring[j];
            if (((a.lat > point.lat) !== (b.lat > point.lat)) &&
                (point.lng < (b.lng - a.lng) * (point.lat - a.lat) / ((b.lat - a.lat) || Number.EPSILON) + a.lng)) inside = !inside;
        }
        return inside;
    }

    function setAutoCoords(lat, lng) {
        document.getElementById('fldLat').value = lat.toFixed(6);
        document.getElementById('fldLng').value = lng.toFixed(6);
        marker.setLatLng([lat, lng]).setOpacity(1);
        validateLocation(lat, lng);
    }

    function switchType(type) {
        currentType = type;
        document.querySelectorAll('.type-tab').forEach(t => t.classList.remove('active'));
        document.querySelector(`.type-tab[data-type="${type}"]`).classList.add('active');

        if (type === 'sitio') {
            document.getElementById('parentBarangayGroup').style.display = 'block';
            document.getElementById('nameLabel').innerText = 'Sitio / Specific Area Name';
            document.getElementById('fldName').placeholder = 'e.g. Purok 5';
        } else {
            document.getElementById('parentBarangayGroup').style.display = 'none';
            document.getElementById('nameLabel').innerText = 'Barangay Name';
            document.getElementById('fldName').placeholder = 'e.g. Lizada';
            if (window._activePolygon) {
                map.removeLayer(window._activePolygon);
                currentPolygon = null;
            }
        }

        const lat = parseFloat(document.getElementById('fldLat').value);
        const lng = parseFloat(document.getElementById('fldLng').value);
        if (!isNaN(lat) && !isNaN(lng)) validateLocation(lat, lng, true);
    }

    document.getElementById('fldParent').onchange = () => {
        const lat = parseFloat(document.getElementById('fldLat').value);
        const lng = parseFloat(document.getElementById('fldLng').value);
        if (!isNaN(lat) && !isNaN(lng)) validateLocation(lat, lng, true);
    };

    document.querySelectorAll('.type-tab').forEach(tab => {
        tab.onclick = () => switchType(tab.dataset.type);
    });

    document.getElementById('detectLocBtn').onclick = () => {
        if (navigator.geolocation) {
            document.getElementById('detectLocBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Detecting...';
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    setAutoCoords(pos.coords.latitude, pos.coords.longitude);
                    map.setView([pos.coords.latitude, pos.coords.longitude], 16);
                    document.getElementById('detectLocBtn').innerHTML = '<i class="fas fa-crosshairs me-2 text-primary"></i>Use My Current Location';
                },
                () => {
                    alert("Could not detect location.");
                    document.getElementById('detectLocBtn').innerHTML = '<i class="fas fa-crosshairs me-2 text-primary"></i>Use My Current Location';
                }
            );
        }
    };

    document.getElementById('detectInfoBtn').onclick = () => {
        const lat = parseFloat(document.getElementById('fldLat').value);
        const lng = parseFloat(document.getElementById('fldLng').value);
        if (lat && lng) setAutoCoords(lat, lng);
    };

    function openEditFromData(data) {
        document.getElementById('panelTitle').innerText = 'Edit Alert Status';
        switchType(data._type);

        document.getElementById('fldId').value = data.id || '';
        document.getElementById('fldName').value = data.name || data.sitio_name;
        document.getElementById('fldName').readOnly = (data._type === 'barangay');
        document.getElementById('fldLevel').value = data.alert_level !== undefined ? data.alert_level : data.flood_level;
        document.getElementById('fldAdvisory').value = data.flood_advisory || '';
        document.getElementById('fldAddress').value = data.full_address || '';
        document.getElementById('fldParent').value = data.barangay || '';

        const lat = data.latitude;
        const lng = data.longitude;
        document.getElementById('fldLat').value = lat || '';
        document.getElementById('fldLng').value = lng || '';

        document.getElementById('editOverlay').style.display = 'flex';
        document.getElementById('map').style.display = 'block';
        document.getElementById('typeToggle').style.pointerEvents = 'none';
        document.getElementById('typeToggle').style.opacity = '0.6';

        setTimeout(() => {
            map.invalidateSize();
            if (lat && lng) {
                const pos = [parseFloat(lat), parseFloat(lng)];
                map.setView(pos, 16);
                marker.setLatLng(pos).setOpacity(1);
            } else {
                marker.setOpacity(0);
            }
        }, 100);
    }

    document.getElementById('addAlertBtn').onclick = () => {
        document.getElementById('panelTitle').innerText = 'Create New Alert';
        switchType('barangay');

        document.getElementById('fldId').value = '';
        document.getElementById('fldName').value = '';
        document.getElementById('fldName').readOnly = false;
        document.getElementById('fldLevel').value = '0';
        document.getElementById('fldAdvisory').value = '';
        document.getElementById('fldLat').value = '';
        document.getElementById('fldLng').value = '';
        document.getElementById('fldAddress').value = '';
        document.getElementById('fldParent').value = '';

        document.getElementById('editOverlay').style.display = 'flex';
        document.getElementById('map').style.display = 'block';
        document.getElementById('typeToggle').style.pointerEvents = 'auto';
        document.getElementById('typeToggle').style.opacity = '1';
        marker.setOpacity(0);

        setTimeout(() => {
            map.invalidateSize();
            map.setView([7.028, 125.448], 13);
        }, 100);
    };

    document.getElementById('cancelBtn').onclick = () => {
        document.getElementById('editOverlay').style.display = 'none';
        if (window._activePolygon) {
            map.removeLayer(window._activePolygon);
            currentPolygon = null;
        }
    };

    document.getElementById('saveBtn').onclick = async () => {
        const id = document.getElementById('fldId').value;
        const name = document.getElementById('fldName').value;
        const level = document.getElementById('fldLevel').value;
        const advisory = document.getElementById('fldAdvisory').value;
        const address = document.getElementById('fldAddress').value;
        const lat = document.getElementById('fldLat').value;
        const lng = document.getElementById('fldLng').value;
        const parent = document.getElementById('fldParent').value;

        if (currentType === 'sitio' && !parent) {
            alert("Please select a parent barangay for the sitio.");
            return;
        }

        document.getElementById('saveBtn').disabled = true;
        document.getElementById('saveBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

        try {
            const res = await fetch('/api/save-alert.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    type: currentType,
                    id: id,
                    barangay: currentType === 'sitio' ? parent : name,
                    name: name,
                    level: level,
                    advisory: advisory,
                    address: address,
                    latitude: lat,
                    longitude: lng
                })
            });
            const result = await res.json();
            if (result.success) {
                document.getElementById('editOverlay').style.display = 'none';
                fetchAlerts();
            } else {
                alert('Update failed: ' + result.message);
            }
        } catch (e) {
            alert('An error occurred while saving.');
        } finally {
            document.getElementById('saveBtn').disabled = false;
            document.getElementById('saveBtn').innerHTML = 'Push Alert Update';
        }
    };

    fetchAlerts();
</script>
<script>initMap();</script>
