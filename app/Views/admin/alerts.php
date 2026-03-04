<!-- Admin Alerts View -->
<style>
    :root {
        --alert-green: #22c55e;
        --alert-yellow: #eab308;
        --alert-orange: #f97316;
        --alert-red: #ef4444;
    }

    .admin-layout { display: flex; min-height: calc(100vh - 70px); background: #f8fafc; }
    .admin-main { flex: 1; padding: 2rem; overflow-x: hidden; }

    .alert-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }

    .level-badge {
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .level-0 { background: rgba(34, 197, 94, 0.1); color: var(--alert-green); }
    .level-1 { background: rgba(234, 179, 8, 0.1); color: var(--alert-yellow); }
    .level-2 { background: rgba(249, 115, 22, 0.1); color: var(--alert-orange); }
    .level-3 { background: rgba(239, 68, 68, 0.1); color: var(--alert-red); }

    .table th { background: #f1f5f9; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border: none; }
    
    .panel-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.4); backdrop-filter: blur(4px);
        z-index: 1060; display: none; align-items: center; justify-content: center;
    }
    
    .panel-content {
        background: white; width: 500px; max-height: 90vh; overflow-y: auto;
        border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    }
    
    #map { height: 250px; width: 100%; border-radius: 1rem; margin-bottom: 1.5rem; display: none; }
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
            <button class="btn btn-light rounded-circle" id="cancelBtn"><i class="fas fa-times"></i></button>
        </div>

        <div id="locationModeBanner" class="alert alert-warning border-0 rounded-3 mb-4 py-2 px-3 small" style="display:none;">
            <i class="fas fa-map-marker-alt me-2"></i> <strong>Mode Active:</strong> Click on the map to pick coordinates.
        </div>

        <div id="map"></div>

        <div class="d-grid gap-3">
            <button type="button" class="btn btn-light btn-sm fw-bold mb-2 py-2" id="detectLocBtn">
                <i class="fas fa-crosshairs me-2 text-primary"></i>Detect My Location
            </button>

            <div class="form-group row g-3">
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Barangay Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 py-2 rounded-start-3" id="fldName" placeholder="e.g. Toril Proper">
                        <button type="button" id="detectInfoBtn" class="btn btn-light border-0" title="Re-detect from coordinates">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Specific Address / Purok</label>
                    <input type="text" id="fldAddress" class="form-control bg-light border-0 py-2 rounded-3" placeholder="Sitio etc.">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Latitude</label>
                    <input type="number" id="fldLat" class="form-control bg-light border-0 py-2 rounded-3" step="0.00001">
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Longitude</label>
                    <input type="number" id="fldLng" class="form-control bg-light border-0 py-2 rounded-3" step="0.00001">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Risk Level</label>
                    <select id="fldLevel" class="form-select bg-light border-0 py-2 rounded-3">
                        <option value="0">Normal (Green)</option>
                        <option value="1">Warning (Yellow)</option>
                        <option value="2">Alert (Orange)</option>
                        <option value="3">Critical (Red)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold text-muted">Official Advisory</label>
                    <textarea id="fldAdvisory" class="form-control bg-light border-0 py-2 rounded-3" rows="3" placeholder="Enter instructions for residents..."></textarea>
                </div>
            </div>

            <button class="btn btn-primary fw-bold py-3 rounded-3 mt-3 shadow-sm border-0" id="saveBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                Update Security Status
            </button>
        </div>
    </div>
</div>

<script>
async function fetchAlerts() {
    const res = await fetch('/micro-oss/api/get-alerts.php');
    const data = await res.json();
    allBarangays = data.barangays || [];
    buildTable(allBarangays);
    if ((data.barangays && data.barangays.length>0) || (data.sitios && data.sitios.length>0)) {
        document.getElementById('initSchemaBtn').style.display='none';
    } else {
        document.getElementById('initSchemaBtn').style.display='block';
    }
}

function buildTable(list) {
    const tbody = document.querySelector('#alertsTable tbody');
    tbody.innerHTML = '';
    list.forEach(item => {
        const tr = document.createElement('tr');
        const levelText = getLevelText(item.alert_level);
        tr.innerHTML = `
            <td class="ps-4">
                <div class="fw-bold text-dark">${item.name}</div>
                <div class="small text-muted">${item.full_address || 'Toril District'}</div>
            </td>
            <td>
                <span class="level-badge level-${item.alert_level}">${levelText}</span>
            </td>
            <td>
                <div class="text-truncate small text-muted" style="max-width: 300px;">${item.flood_advisory || 'No advisory issued'}</div>
            </td>
            <td class="text-end pe-4">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick='openEditFromData(${JSON.stringify(item).replace(/'/g, "&apos;")})'><i class="fas fa-edit me-2 text-primary"></i> Edit Alert</a></li>
                    </ul>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function getLevelText(n) {
    switch(+n){ case 0: return 'Normal'; case 1: return 'Warning'; case 2: return 'Alert'; case 3: return 'Critical'; }
    return 'N/A';
}

let map, marker, geocoder, locationSelectionMode = false, allBarangays = [];

function initMap() {
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: { lat: 7.028, lng: 125.448 },
        styles: [
            { "featureType": "poi", "stylers": [{ "visibility": "off" }] }
        ]
    });
    marker = new google.maps.Marker({ map: map, draggable: false });
    map.addListener('click', (e) => {
        setAutoCoords(e.latLng.lat(), e.latLng.lng());
    });
}

function setAutoCoords(lat, lng) {
    document.getElementById('fldLat').value = lat.toFixed(6);
    document.getElementById('fldLng').value = lng.toFixed(6);
    const pos = { lat: parseFloat(lat), lng: parseFloat(lng) };
    marker.setPosition(pos);
    marker.setVisible(true);
    
    geocoder.geocode({ location: pos }, (results, status) => {
        if (status === "OK" && results[0]) {
            const addr = results[0];
            document.getElementById('fldAddress').value = addr.formatted_address;
            let brgy = "";
            for (let comp of addr.address_components) {
                if (comp.types.includes("neighborhood") || comp.types.includes("sublocality_level_1")) {
                    brgy = comp.long_name;
                    break;
                }
            }
            if (!brgy) {
                for (let comp of addr.address_components) {
                    if (comp.types.includes("administrative_area_level_3")) {
                        brgy = comp.long_name;
                        break;
                    }
                }
            }
            if (!document.getElementById('fldName').readOnly && brgy) {
                document.getElementById('fldName').value = brgy;
            }
        }
    });
}

function useCurrentLocation() {
    if (navigator.geolocation) {
        document.getElementById('detectLocBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Detecting...';
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                setAutoCoords(pos.coords.latitude, pos.coords.longitude);
                map.setCenter({ lat: pos.coords.latitude, lng: pos.coords.longitude });
                document.getElementById('detectLocBtn').innerHTML = '<i class="fas fa-crosshairs me-2 text-primary"></i>Detect My Location';
            },
            () => {
                alert("Could not detect location.");
                document.getElementById('detectLocBtn').innerHTML = '<i class="fas fa-crosshairs me-2 text-primary"></i>Detect My Location';
            }
        );
    }
}

document.getElementById('detectLocBtn').onclick = useCurrentLocation;
document.getElementById('detectInfoBtn').onclick = () => {
    const lat = parseFloat(document.getElementById('fldLat').value);
    const lng = parseFloat(document.getElementById('fldLng').value);
    if (lat && lng) setAutoCoords(lat, lng);
};

function openEditFromData(data) {
    document.getElementById('panelTitle').innerText = 'Modify Alert';
    document.getElementById('fldName').value = data.name;
    document.getElementById('fldName').readOnly = true;
    document.getElementById('fldLevel').value = data.alert_level;
    document.getElementById('fldAdvisory').value = data.flood_advisory;
    document.getElementById('fldAddress').value = data.full_address || '';
    const lat = data.latitude;
    const lng = data.longitude;
    document.getElementById('fldLat').value = lat || '';
    document.getElementById('fldLng').value = lng || '';
    
    document.getElementById('editOverlay').style.display = 'flex';
    document.getElementById('map').style.display = 'block';
    
    setTimeout(() => {
        google.maps.event.trigger(map, 'resize');
        if (lat && lng) {
            const pos = { lat: parseFloat(lat), lng: parseFloat(lng) };
            map.setCenter(pos);
            marker.setPosition(pos);
            marker.setVisible(true);
        } else {
            marker.setVisible(false);
        }
    }, 100);
}

document.getElementById('addAlertBtn').onclick = () => {
    document.getElementById('panelTitle').innerText = 'Add New Alert';
    document.getElementById('fldName').value = '';
    document.getElementById('fldName').readOnly = false;
    document.getElementById('fldLevel').value = '0';
    document.getElementById('fldAdvisory').value = '';
    document.getElementById('fldLat').value = '';
    document.getElementById('fldLng').value = '';
    document.getElementById('fldAddress').value = '';
    
    document.getElementById('editOverlay').style.display = 'flex';
    document.getElementById('map').style.display = 'block';
    document.getElementById('locationModeBanner').style.display = 'block';
    marker.setVisible(false);
    
    useCurrentLocation();
    
    setTimeout(() => {
        google.maps.event.trigger(map, 'resize');
        map.setCenter({ lat: 7.028, lng: 125.448 });
    }, 100);
};

document.getElementById('cancelBtn').onclick = () => {
    document.getElementById('editOverlay').style.display = 'none';
};

document.getElementById('saveBtn').onclick = async () => {
    const name = document.getElementById('fldName').value;
    const level = document.getElementById('fldLevel').value;
    const advisory = document.getElementById('fldAdvisory').value;
    const address = document.getElementById('fldAddress').value;
    const lat = document.getElementById('fldLat').value;
    const lng = document.getElementById('fldLng').value;
    
    const res = await fetch('/micro-oss/api/save-alert.php', {
        method:'POST', 
        headers:{'Content-Type':'application/json'}, 
        body: JSON.stringify({ type:'barangay', name, level, advisory, address, latitude: lat, longitude: lng })
    });
    const result = await res.json();
    if (result.success) {
        document.getElementById('editOverlay').style.display = 'none';
        fetchAlerts();
    } else {
        alert('Save failed: '+result.message);
    }
};

fetchAlerts();
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8&callback=initMap"></script>
