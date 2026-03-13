<style>
    :root {
        --alert-green: #22c55e;
        --alert-yellow: #eab308;
        --alert-orange: #f97316;
        --alert-red: #ef4444;
        --admin-primary: #4338ca;
    }

    .admin-layout {
        display: flex;
        min-height: calc(100vh - 70px);
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .admin-main {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
    }

    .alert-card {
        background: white;
        border-radius: 1.25rem;
        padding: 0;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .level-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .level-0 { background: rgba(34, 197, 94, 0.1); color: var(--alert-green); }
    .level-1 { background: rgba(234, 179, 8, 0.1); color: var(--alert-yellow); }
    .level-2 { background: rgba(249, 115, 22, 0.1); color: var(--alert-orange); }
    .level-3 { background: rgba(239, 68, 68, 0.1); color: var(--alert-red); }

    .table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
    }

    .panel-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(8px);
        z-index: 1060;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .panel-content {
        background: white;
        width: 100%;
        max-width: 550px;
        max-height: 95vh;
        overflow-y: auto;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    #map {
        height: 280px;
        width: 100%;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .type-tab {
        flex: 1;
        text-align: center;
        padding: 0.75rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        border-radius: 0.75rem;
        transition: all 0.2s;
        color: #64748b;
    }

    .type-tab.active {
        background: var(--admin-primary);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(67, 56, 202, 0.3);
    }

    #locationStatus {
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .status-valid { color: var(--alert-green); }
    .status-invalid { color: var(--alert-red); }
    .status-warning { color: var(--alert-orange); }
</style>

<div class="admin-layout d-flex">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="admin-main p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Flood Alert Management</h2>
                <p class="text-muted">Issue and update flood status for specific barangays and sitios</p>
            </div>
            <div class="d-flex gap-2">
                <button id="addAlertBtn" class="btn btn-primary rounded-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="fas fa-plus me-2"></i>New Alert
                </button>
                <button id="initSchemaBtn" class="btn btn-outline-secondary rounded-3 px-4" style="display:none;">
                    Initialize Schema
                </button>
            </div>
        </div>

        <div class="alert-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-light bg-opacity-50">
                <h5 class="fw-bold mb-0">Active Alerts</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="alertsTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Barangay / Sitio</th>
                            <th>Alert Level</th>
                            <th>Current Advisory</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic list -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="message" class="mt-3 text-danger small"></div>
    </main>
</div>

<!-- Edit Overlay -->
<div id="editOverlay" class="panel-overlay">
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0" id="panelTitle">Modify Alert</h3>
            <button class="btn btn-light rounded-circle shadow-sm" id="cancelBtn"><i class="fas fa-times"></i></button>
        </div>

        <!-- Alert Type Toggle -->
        <div class="d-flex bg-light p-1 rounded-3 mb-4" id="typeToggle">
            <div class="type-tab active" data-type="barangay">Barangay</div>
            <div class="type-tab" data-type="sitio">Sitio / Area</div>
        </div>

        <div id="locationModeBanner" class="alert alert-primary border-0 rounded-3 mb-4 py-2 px-3 small" style="display:none;">
            <i class="fas fa-info-circle me-2"></i> Click on the map to set location coordinates.
        </div>

        <div id="map"></div>

        <div id="locationStatus" class="mb-3 px-1"></div>

        <input type="hidden" id="fldId">
        
        <div class="d-grid gap-3">
            <button type="button" class="btn btn-light btn-sm fw-bold mb-2 py-2 border shadow-sm" id="detectLocBtn">
                <i class="fas fa-crosshairs me-2 text-primary"></i>Use My Current Location
            </button>

            <div class="form-group row g-3">
                <div class="col-12" id="parentBarangayGroup" style="display:none;">
                    <label class="form-label small fw-bold text-muted">Parent Barangay</label>
                    <select id="fldParent" class="form-select bg-light border-0 py-2 rounded-3">
                        <option value="">-- Select Barangay --</option>
                        <!-- Dynamic list -->
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted" id="nameLabel">Barangay Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 py-2 rounded-start-3" id="fldName" placeholder="e.g. Lizada">
                        <button type="button" id="detectInfoBtn" class="btn btn-light border border-start-0" title="Re-detect from coordinates">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12" id="addressGroup">
                    <label class="form-label small fw-bold text-muted">Display Address / Details</label>
                    <input type="text" id="fldAddress" class="form-control bg-light border-0 py-2 rounded-3" placeholder="Additional location info">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Latitude</label>
                    <input type="number" id="fldLat" class="form-control bg-light border-0 py-2 rounded-3" step="0.000001">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Longitude</label>
                    <input type="number" id="fldLng" class="form-control bg-light border-0 py-2 rounded-3" step="0.000001">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Alert Level</label>
                    <select id="fldLevel" class="form-select bg-light border-0 py-2 rounded-3">
                        <option value="0">SAFE (Green)</option>
                        <option value="1">WARNING (Yellow)</option>
                        <option value="2">ALERT (Orange)</option>
                        <option value="3">CRITICAL (Red)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Broadcast Advisory</label>
                    <textarea id="fldAdvisory" class="form-control bg-light border-0 py-2 rounded-3" rows="3" placeholder="What should residents do?"></textarea>
                </div>
            </div>

            <button class="btn btn-primary fw-bold py-3 rounded-3 mt-3 shadow-sm border-0" id="saveBtn" style="background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);">
                Push Alert Update
            </button>
        </div>
    </div>
</div>

<script>
    let allBarangays = [], allSitios = [];
    let currentType = 'barangay';

    async function fetchAlerts() {
        const res = await fetch('/micro-oss/api/get-alerts.php');
        const data = await res.json();
        allBarangays = data.barangays || [];
        allSitios = data.sitios || [];
        buildTable();
        populateParentDropdown();
    }

    function populateParentDropdown() {
        const select = document.getElementById('fldParent');
        const currentVal = select.value;
        select.innerHTML = '<option value="">-- Select Barangay --</option>';
        allBarangays.forEach(b => {
            const opt = document.createElement('option');
            opt.value = b.name;
            opt.innerText = b.name;
            select.appendChild(opt);
        });
        select.value = currentVal;
    }

    function buildTable() {
        const tbody = document.querySelector('#alertsTable tbody');
        tbody.innerHTML = '';
        
        // Add Barangays
        allBarangays.forEach(item => {
            appendRow(tbody, item, 'barangay');
        });

        // Add Sitios
        allSitios.forEach(item => {
            appendRow(tbody, item, 'sitio');
        });
    }

    function appendRow(tbody, item, type) {
        const tr = document.createElement('tr');
        const levelText = getLevelText(item.alert_level || item.flood_level);
        const level = item.alert_level || item.flood_level;
        const name = item.name || item.sitio_name;
        const address = type === 'barangay' ? (item.full_address || 'District Center') : `Area in ${item.barangay}`;
        const advisory = item.flood_advisory || 'No active advisory';

        tr.innerHTML = `
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <div class="me-3 p-2 bg-light rounded-3 text-primary">
                        <i class="fas ${type === 'barangay' ? 'fa-building' : 'fa-map-pin'}"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark">${name}</div>
                        <div class="small text-muted">${address}</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="level-badge level-${level}">${levelText}</span>
            </td>
            <td>
                <div class="text-truncate small text-muted" style="max-width: 250px;">${advisory}</div>
            </td>
            <td class="text-end pe-4">
                <button class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick='openEditFromData(${JSON.stringify({ ...item, _type: type }).replace(/'/g, "&apos;")})'>
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function getLevelText(n) {
        switch (+n) {
            case 0: return 'Safe';
            case 1: return 'Warning';
            case 2: return 'Alert';
            case 3: return 'Critical';
        }
        return 'N/A';
    }

    let map, marker, geocoder, currentPolygon;

    function initMap() {
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: { lat: 7.028, lng: 125.448 },
            disableDefaultUI: true,
            zoomControl: true,
            styles: [
                { "featureType": "poi", "stylers": [{ "visibility": "off" }] },
                { "featureType": "transit", "stylers": [{ "visibility": "off" }] }
            ]
        });
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });
        map.addListener('click', (e) => {
            setAutoCoords(e.latLng.lat(), e.latLng.lng());
        });
        marker.addListener('dragend', (e) => {
            setAutoCoords(e.latLng.lat(), e.latLng.lng());
        });

        // Add input listeners for manual coordinate entry
        ['fldLat', 'fldLng'].forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                const lat = parseFloat(document.getElementById('fldLat').value);
                const lng = parseFloat(document.getElementById('fldLng').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const pos = { lat, lng };
                    marker.setPosition(pos);
                    map.panTo(pos);
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
                // Fetch polygon if not already matching
                if (!currentPolygon || currentPolygon._name !== parentBrgy) {
                    const res = await fetch(`/micro-oss/api/get-barangay-polygon.php?name=${encodeURIComponent(parentBrgy)}`);
                    const data = await res.json();
                    if (data.success) {
                        if (window._activePolygon) window._activePolygon.setMap(null);
                        window._activePolygon = new google.maps.Polygon({
                            paths: data.polygon,
                            strokeColor: "#4338ca",
                            strokeOpacity: 0.5,
                            strokeWeight: 1,
                            fillColor: "#6366f1",
                            fillOpacity: 0.1,
                            map: map
                        });
                        currentPolygon = window._activePolygon;
                        currentPolygon._name = parentBrgy;
                        currentPolygon._coords = data.polygon;
                    }
                }

                if (currentPolygon) {
                    const isInside = google.maps.geometry.poly.containsLocation(new google.maps.LatLng(lat, lng), currentPolygon);
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
            geocoder.geocode({ location: pos }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const addr = results[0];
                    statusEl.innerHTML += `<div class="mt-1 opacity-75 small"><i class="fas fa-map-marker-alt me-1"></i> ${addr.formatted_address}</div>`;
                }
            });
        }
    }

    function setAutoCoords(lat, lng) {
        document.getElementById('fldLat').value = lat.toFixed(6);
        document.getElementById('fldLng').value = lng.toFixed(6);
        marker.setPosition({ lat, lng });
        marker.setVisible(true);
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
                window._activePolygon.setMap(null);
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
                    map.setCenter({ lat: pos.coords.latitude, lng: pos.coords.longitude });
                    map.setZoom(16);
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
        document.getElementById('fldName').readOnly = (data._type === 'barangay'); // Barangays are protected
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
        document.getElementById('typeToggle').style.pointerEvents = 'none'; // Lock type on edit
        document.getElementById('typeToggle').style.opacity = '0.6';

        setTimeout(() => {
            google.maps.event.trigger(map, 'resize');
            if (lat && lng) {
                const pos = { lat: parseFloat(lat), lng: parseFloat(lng) };
                map.setCenter(pos);
                map.setZoom(16);
                marker.setPosition(pos);
                marker.setVisible(true);
            } else {
                marker.setVisible(false);
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
        marker.setVisible(false);

        setTimeout(() => {
            google.maps.event.trigger(map, 'resize');
            map.setCenter({ lat: 7.028, lng: 125.448 });
            map.setZoom(13);
        }, 100);
    };

    document.getElementById('cancelBtn').onclick = () => {
        document.getElementById('editOverlay').style.display = 'none';
        if (window._activePolygon) {
            window._activePolygon.setMap(null);
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
            const res = await fetch('/micro-oss/api/save-alert.php', {
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
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8&libraries=geometry&callback=initMap"></script>
