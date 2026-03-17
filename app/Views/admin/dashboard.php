<!-- Admin Dashboard View -->
<style>
    :root {
        --admin-sidebar-width: 280px;
        --admin-primary: #667eea;
        --admin-secondary: #764ba2;
        --admin-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --admin-bg: #f8fafc;
        --admin-card-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--admin-bg);
    }

    .admin-layout {
        display: flex;
        min-height: calc(100vh - 70px);
    }

    .admin-main {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
        transition: var(--admin-transition);
    }

    .stats-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        border: none;
        box-shadow: var(--admin-card-shadow);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .bg-soft-primary {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .bg-soft-success {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .bg-soft-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .bg-soft-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .map-section {
        background: white;
        border-radius: 1.25rem;
        padding: 1.5rem;
        box-shadow: var(--admin-card-shadow);
        margin-bottom: 2rem;
    }

    #map {
        height: 500px;
        width: 100%;
        border-radius: 0.75rem;
    }

    .table-responsive {
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8fafc;
        color: #64748b;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        padding: 1rem;
        border-bottom: 2px solid #edf2f7;
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        font-size: 0.875rem;
        border-bottom: 1px solid #edf2f7;
    }

    /* Edit Panel Refinements */
    .edit-panel {
        position: fixed;
        right: 0;
        top: 0;
        width: 450px;
        height: 100vh;
        background: white;
        box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        overflow-y: auto;
        z-index: 1051;
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .edit-panel.active {
        transform: translateX(0);
    }

    .btn-action {
        border-radius: 0.6rem;
        padding: 0.5rem 1rem;
    }
</style>
<?php
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<div class="alert alert-warning m-3">Access denied. Admins only.</div>';
    exit;
}
?>
<div class="admin-layout d-flex">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <!-- Main Content -->
    <main class="admin-main flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Monitoring Dashboard</h2>
                <p class="text-muted mb-0">Live evacuation centers and resource allocation</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success rounded-3 px-4 shadow-sm" onclick="openPanel()">
                    <i class="fas fa-plus me-2"></i>New Center
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-primary"><i class="fas fa-building"></i></div>
                    <div class="text-muted small mb-1">Total Centers</div>
                    <h3 class="fw-bold mb-0" id="totalCenters">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-success"><i class="fas fa-users-cog"></i></div>
                    <div class="text-muted small mb-1">Total Capacity</div>
                    <h3 class="fw-bold mb-0" id="totalCapacity">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-warning"><i class="fas fa-user-check"></i></div>
                    <div class="text-muted small mb-1">Total Occupied</div>
                    <h3 class="fw-bold mb-0" id="totalOccupied">0</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-danger"><i class="fas fa-chart-line"></i></div>
                    <div class="text-muted small mb-1">Utilization</div>
                    <h3 class="fw-bold mb-0" id="utilization">0%</h3>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="row mb-5">
            <div class="col-lg-8">
                <div class="map-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Interactive Control Map</h5>
                        <div class="small text-muted"><i class="fas fa-info-circle me-1"></i> Live tracking active</div>
                    </div>
                    <div id="map"></div>
                    <div class="mt-3 d-flex gap-3 flex-wrap small">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: rgba(255, 0, 0, 0.4); border: 1px solid red;"></div>
                            <span>High Flood Risk</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: rgba(255, 165, 0, 0.4); border: 1px solid orange;"></div>
                            <span>Moderate Flood Risk</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: rgba(0, 128, 0, 0.4); border: 1px solid green;"></div>
                            <span>Low Flood Risk</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; border: 1px solid #4a5568; background: rgba(102, 126, 234, 0.1);"></div>
                            <span>Barangay Area</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                    <h5 class="fw-bold mb-4">Real-time Metrics</h5>
                    <div class="mb-4">
                        <label class="small text-muted mb-2">Occupancy Distribution</label>
                        <div style="height: 280px;"><canvas id="pieChart"></canvas></div>
                    </div>
                    <hr class="opacity-10 my-4">
                    <h6 class="fw-bold small text-uppercase mb-3 opacity-50">Quick Navigation</h6>
                    <div id="directionsPanel" class="bg-light p-3 rounded-3 small text-muted text-center" style="min-height: 150px; display: flex; align-items: center; justify-content: center;">
                        <span>Select a destination on the map or detect location to see directions.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Table -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white border-0 py-4 px-4">
                <h5 class="fw-bold mb-0">Center Management</h5>
            </div>
            <div class="table-responsive px-4 pb-4">
                <table class="table table-hover align-middle mb-0" id="centersTable">
                    <thead>
                        <tr>
                            <th>Center Details</th>
                            <th>Coordinates</th>
                            <th>Capacity</th>
                            <th>Utilization</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="centersList">
                        <!-- Loaded via JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
            <h5 class="fw-bold mb-4">Capacity Overview per Center</h5>
            <canvas id="barChart" style="max-height: 400px;"></canvas>
        </div>
    </main>
</div>

<!-- Edit Panel -->
<div id="editPanelOverlay" class="edit-panel-overlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.4); z-index:1050; backdrop-filter: blur(4px);"></div>
<div id="editPanel" class="edit-panel">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold mb-0" id="panelTitle">Add Center</h2>
        <button class="btn btn-light rounded-circle" onclick="closePanel()" style="width: 40px; height: 40px;"><i class="fas fa-times"></i></button>
    </div>

    <div id="locationModeBanner" class="alert alert-warning border-0 rounded-4 shadow-sm mb-4" style="display:none;">
        <i class="fas fa-map-pin me-2"></i> <strong>Mode Active:</strong> Click on the map to set coordinates.
    </div>

    <form id="editForm">
        <input type="hidden" id="centerId">
        <div class="mb-4">
            <label class="form-label fw-bold small text-muted">Center Name</label>
            <input type="text" class="form-control rounded-3 p-3 bg-light border-0" id="centerName" placeholder="e.g. Toril Covered Court" required>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Latitude</label>
                <input type="number" class="form-control rounded-3 p-3 bg-light border-0" id="centerLat" step="0.00001" placeholder="7.0000" required>
            </div>
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Longitude</label>
                <input type="number" class="form-control rounded-3 p-3 bg-light border-0" id="centerLng" step="0.00001" placeholder="125.0000" required>
            </div>
        </div>
        <div class="mb-4">
            <button type="button" class="btn btn-soft-primary w-100 p-3 fw-bold rounded-3" onclick="toggleMapLocationSelection()" id="mapSelectBtn">
                <i class="fas fa-map-marker-alt me-2"></i>Pick from Map
            </button>
        </div>
        <div class="row g-3 mb-5">
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Max Capacity</label>
                <input type="number" class="form-control rounded-3 p-3 bg-light border-0" id="centerCapacity" required>
            </div>
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Current Occupancy</label>
                <input type="number" class="form-control rounded-3 p-3 bg-light border-0" id="centerOccupied" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 p-4 fw-bold rounded-4 shadow-lg border-0" style="background: var(--admin-gradient);">
            Save Changes
        </button>
    </form>
</div>

<!-- Charts & Maps Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8&libraries=geometry,directions"></script>

<script>
    let map, markers = [],
        barChart, pieChart, userLocation = null,
        userMarker = null,
        nearestCenter = null,
        directionsService, directionsRenderer, allCenters = [];
    let locationSelectionMode = false,
        locationSelectMarker = null,
        mapClickListener = null;
    let barangayPolygons = []; // To store polygon objects

    function calculateDistance(lat1, lon1, lat2, lon2) {
        if (!lat1 || !lon1 || !lat2 || !lon2) return 0;
        const R = 6371,
            dLat = (lat2 - lat1) * Math.PI / 180,
            dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function findNearestCenter() {
        if (!userLocation || !allCenters.length) return null;
        let nearest = null,
            minDistance = Infinity;
        allCenters.forEach(c => {
            const dist = calculateDistance(userLocation.lat, userLocation.lng, parseFloat(c.latitude), parseFloat(c.longitude));
            if (dist < minDistance) {
                minDistance = dist;
                nearest = {
                    ...c,
                    distance: dist
                };
            }
        });
        return nearest;
    }

    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(
                pos => {
                    userLocation = {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude
                    };
                    if (userMarker) userMarker.setPosition(userLocation);
                    else userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'Your Location',
                        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                    });
                    nearestCenter = findNearestCenter();
                    if (nearestCenter && document.getElementById('directionsPanel')) {
                        document.getElementById('directionsPanel').innerHTML = `<div class="text-start w-100">
                        <div class="fw-bold text-dark">${nearestCenter.name}</div>
                        <div class="small">Dist: ${nearestCenter.distance.toFixed(2)} km | Status: ${nearestCenter.status}</div>
                    </div>`;
                    }
                },
                err => console.log("Location unavailable")
            );
        }
    }

    function getMarkerColor(status) {
        switch (status) {
            case 'Full':
                return 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
            case 'Limited':
                return 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png';
            default:
                return 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        }
    }

    async function loadDashboard() {
        try {
            const dashRes = await fetch('/micro-oss/api/dashboard_data.php');
            const dashData = await dashRes.json();

            document.getElementById('totalCenters').innerText = dashData.totalCenters;
            document.getElementById('totalCapacity').innerText = dashData.totalCapacity;
            document.getElementById('totalOccupied').innerText = dashData.totalOccupied;
            const util = dashData.totalCapacity > 0 ? ((dashData.totalOccupied / dashData.totalCapacity) * 100).toFixed(1) : '0';
            document.getElementById('utilization').innerText = util + '%';

            const labels = dashData.centers.map(c => c.name),
                capacity = dashData.centers.map(c => c.capacity),
                occupied = dashData.centers.map(c => c.occupied);

            if (!barChart) {
                barChart = new Chart(document.getElementById('barChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Capacity',
                                data: capacity,
                                backgroundColor: '#667eea',
                                borderRadius: 8
                            },
                            {
                                label: 'Occupied',
                                data: occupied,
                                backgroundColor: '#ef4444',
                                borderRadius: 8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                barChart.data.labels = labels;
                barChart.data.datasets[0].data = capacity;
                barChart.data.datasets[1].data = occupied;
                barChart.update();
            }

            if (!pieChart) {
                pieChart = new Chart(document.getElementById('pieChart'), {
                    type: 'dodge' in Chart ? 'dodge' : 'doughnut', // using doughnut for better look
                    data: {
                        labels: ['Vacant', 'Limited', 'Full'],
                        datasets: [{
                            data: [dashData.statusCount.Vacant, dashData.statusCount.Limited, dashData.statusCount.Full],
                            backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                            borderWidth: 0,
                            cutout: '70%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 30
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    padding: 25,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                pieChart.data.datasets[0].data = [dashData.statusCount.Vacant, dashData.statusCount.Limited, dashData.statusCount.Full];
                pieChart.update();
            }

            const mapRes = await fetch('/micro-oss/api/get-centers.php');
            allCenters = await mapRes.json();

            markers.forEach(m => m.setMap(null));
            markers = [];

            if (!map) {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: {
                        lat: 7.028,
                        lng: 125.448
                    },
                    styles: [{
                            "featureType": "administrative",
                            "elementType": "geometry",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.icon",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "transit",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        }
                    ]
                });
                directionsService = new google.maps.DirectionsService();
                directionsRenderer = new google.maps.DirectionsRenderer({
                    map: map,
                    panel: document.getElementById('directionsPanel')
                });
                getUserLocation();

                // Render Polygons
                renderBarangayPolygons();
                renderFloodZones();
            }

            const bounds = new google.maps.LatLngBounds();
            allCenters.forEach(c => {
                const lat = parseFloat(c.latitude),
                    lng = parseFloat(c.longitude);
                if (isNaN(lat) || isNaN(lng)) return;
                const marker = new google.maps.Marker({
                    position: {
                        lat,
                        lng
                    },
                    map: map,
                    title: c.name,
                    icon: getMarkerColor(c.status)
                });
                const infoWindow = new google.maps.InfoWindow({
                    content: `<div class="p-2">
                    <h6 class="fw-bold mb-1">${c.name}</h6>
                    <div class="small">Capacity: ${c.capacity}</div>
                    <div class="small">Occupancy: ${c.occupied}</div>
                    <div class="mt-2"><span class="badge ${c.status === 'Full' ? 'bg-danger' : (c.status === 'Limited' ? 'bg-warning' : 'bg-success')}">${c.status}</span></div>
                </div>`
                });
                marker.addListener('click', () => infoWindow.open(map, marker));
                markers.push(marker);
                bounds.extend(marker.position);
            });

            const tbody = document.getElementById('centersList');
            tbody.innerHTML = '';
            allCenters.forEach(c => {
                const utilization = c.capacity > 0 ? Math.round((c.occupied / c.capacity) * 100) : 0;
                const statusClass = c.status === 'Full' ? 'bg-soft-danger' : (c.status === 'Limited' ? 'bg-soft-warning' : 'bg-soft-success');
                const statusText = c.status === 'Full' ? 'text-danger' : (c.status === 'Limited' ? 'text-warning' : 'text-success');

                tbody.innerHTML += `<tr>
                <td>
                    <div class="fw-bold text-dark">${c.name}</div>
                    <div class="text-muted small">Evacuation Center</div>
                </td>
                <td>
                    <div class="font-monospace small text-muted">${parseFloat(c.latitude).toFixed(4)}, ${parseFloat(c.longitude).toFixed(4)}</div>
                </td>
                <td>
                    <div class="fw-bold">${c.capacity}</div>
                    <div class="small text-muted">Max spots</div>
                </td>
                <td style="width: 200px;">
                    <div class="d-flex align-items-center">
                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                            <div class="progress-bar ${utilization > 80 ? 'bg-danger' : (utilization > 50 ? 'bg-warning' : 'bg-success')}" style="width: ${utilization}%"></div>
                        </div>
                        <span class="small fw-bold">${utilization}%</span>
                    </div>
                </td>
                <td>
                    <span class="badge ${statusClass} ${statusText} rounded-pill px-3">${c.status}</span>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                            <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="editCenter(${c.id})"><i class="fas fa-edit me-2 text-primary"></i> Edit Center</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="javascript:void(0)" onclick="deleteCenter(${c.id})"><i class="fas fa-trash me-2"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>`;
            });
            if (markers.length > 0) map.fitBounds(bounds);
        } catch (err) {
            console.error("Dashboard load error:", err);
        }
    }

    function renderBarangayPolygons() {
        const barangayPolygonsRaw = <?= json_encode($barangayPolygons) ?>;

        function parseWKT(wkt) {
            if (!wkt) return null;
            const match = wkt.match(/\(\((.*)\)\)/);
            if (!match) return null;
            const points = match[1].split(',');
            return points.map(p => {
                const pair = p.trim().split(/\s+/);
                return {
                    lat: parseFloat(pair[0]),
                    lng: parseFloat(pair[1])
                };
            });
        }

        barangayPolygonsRaw.forEach(bp => {
            const paths = parseWKT(bp.polygon);
            if (!paths) return;

            const polygon = new google.maps.Polygon({
                paths: paths,
                strokeColor: '#4a5568',
                strokeOpacity: 0.5,
                strokeWeight: 1,
                fillColor: '#667eea',
                fillOpacity: 0.1,
                map: map,
                zIndex: 1
            });

            // Highlight on hover
            google.maps.event.addListener(polygon, 'mouseover', function() {
                this.setOptions({
                    fillOpacity: 0.2,
                    strokeWeight: 2
                });
            });
            google.maps.event.addListener(polygon, 'mouseout', function() {
                this.setOptions({
                    fillOpacity: 0.1,
                    strokeWeight: 1
                });
            });

            // Click to show barangay name
            google.maps.event.addListener(polygon, 'click', function(event) {
                const content = `<div style="padding: 10px; font-weight: 700;">Barangay ${bp.name} Zone</div>`;
                const infoWindow = new google.maps.InfoWindow({
                    content: content,
                    position: event.latLng
                });
                infoWindow.open(map);
            });

            barangayPolygons.push(polygon);
        });
    }

    function renderFloodZones() {
        const floodZones = <?= json_encode($floodZones) ?>;

        const getRiskColor = (level) => {
            if (level === "high") return "red";
            if (level === "moderate") return "orange";
            if (level === "low") return "green";
            return "#319795";
        };

        floodZones.forEach(zone => {
            const polygon = new google.maps.Polygon({
                paths: zone.polygon,
                fillColor: getRiskColor(zone.risk_level),
                fillOpacity: 0.3,
                strokeColor: "#000",
                strokeWeight: 1,
                map: map,
                zIndex: 2 // Above barangay areas, below markers
            });

            // Click to show zone details
            google.maps.event.addListener(polygon, 'click', function(event) {
                const content = `<div style="padding: 10px;">
                    <div style="font-weight: 700; color: ${getRiskColor(zone.risk_level)}">${zone.zone_name}</div>
                    <div class="small">Risk Level: ${zone.risk_level.toUpperCase()}</div>
                </div>`;
                const infoWindow = new google.maps.InfoWindow({
                    content: content,
                    position: event.latLng
                });
                infoWindow.open(map);
            });
        });
    }

    loadDashboard();
    setInterval(loadDashboard, 15000);

    function toggleMapLocationSelection() {
        locationSelectionMode = !locationSelectionMode;
        const btn = document.getElementById('mapSelectBtn');
        const banner = document.getElementById('locationModeBanner');
        if (locationSelectionMode) {
            btn.innerHTML = '<i class="fas fa-times me-2"></i>Cancel Picking';
            btn.classList.add('btn-danger');
            btn.classList.remove('btn-soft-primary');
            banner.style.display = 'block';
            document.getElementById('map').style.cursor = 'crosshair';
            if (!mapClickListener) mapClickListener = map.addListener('click', e => {
                if (locationSelectionMode) selectLocationOnMap(e.latLng);
            });
        } else {
            btn.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i>Pick from Map';
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-soft-primary');
            banner.style.display = 'none';
            document.getElementById('map').style.cursor = 'default';
            if (locationSelectMarker) {
                locationSelectMarker.setMap(null);
                locationSelectMarker = null;
            }
        }
    }

    function selectLocationOnMap(latLng) {
        const lat = latLng.lat(),
            lng = latLng.lng();
        document.getElementById('centerLat').value = lat.toFixed(6);
        document.getElementById('centerLng').value = lng.toFixed(6);
        if (locationSelectMarker) locationSelectMarker.setMap(null);
        locationSelectMarker = new google.maps.Marker({
            position: {
                lat,
                lng
            },
            map: map,
            title: 'Selected Location',
            icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
        });
        toggleMapLocationSelection();
    }

    function openPanel() {
        if (locationSelectionMode) toggleMapLocationSelection();
        document.getElementById('panelTitle').innerText = 'New Evacuation Center';
        document.getElementById('editForm').reset();
        document.getElementById('centerId').value = '';
        document.getElementById('editPanel').classList.add('active');
        document.getElementById('editPanelOverlay').style.display = 'block';
    }

    function closePanel() {
        if (locationSelectionMode) toggleMapLocationSelection();
        if (locationSelectMarker) {
            locationSelectMarker.setMap(null);
            locationSelectMarker = null;
        }
        document.getElementById('editPanel').classList.remove('active');
        document.getElementById('editPanelOverlay').style.display = 'none';
    }

    function editCenter(id) {
        const center = allCenters.find(c => c.id == id);
        if (!center) return;
        document.getElementById('panelTitle').innerText = 'Modify Center';
        document.getElementById('centerId').value = center.id;
        document.getElementById('centerName').value = center.name;
        document.getElementById('centerLat').value = center.latitude;
        document.getElementById('centerLng').value = center.longitude;
        document.getElementById('centerCapacity').value = center.capacity;
        document.getElementById('centerOccupied').value = center.occupied;
        document.getElementById('editPanel').classList.add('active');
        document.getElementById('editPanelOverlay').style.display = 'block';
    }

    document.getElementById('editForm').addEventListener('submit', async e => {
        e.preventDefault();
        const id = document.getElementById('centerId').value;
        const data = {
            name: document.getElementById('centerName').value,
            latitude: parseFloat(document.getElementById('centerLat').value),
            longitude: parseFloat(document.getElementById('centerLng').value),
            capacity: parseInt(document.getElementById('centerCapacity').value),
            occupied: parseInt(document.getElementById('centerOccupied').value)
        };
        try {
            const res = await fetch(id ? '/micro-oss/api/update-center.php' : '/micro-oss/api/add-center.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ...data,
                    id
                })
            });
            const result = await res.json();
            if (result.success) {
                loadDashboard();
                closePanel();
            } else alert('Save failed: ' + result.message);
        } catch (err) {
            console.error(err);
            alert('Error saving center');
        }
    });

    async function deleteCenter(id) {
        if (!confirm('This will permanently remove the evacuation center. Continue?')) return;
        try {
            const res = await fetch('/micro-oss/api/delete-center.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id
                })
            });
            const result = await res.json();
            if (result.success) {
                loadDashboard();
            } else alert('Delete failed: ' + result.message);
        } catch (err) {
            console.error(err);
            alert('Error deleting center');
        }
    }
</script>