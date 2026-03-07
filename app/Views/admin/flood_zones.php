<!-- Admin Flood Zones View -->
<style>
    .admin-layout {
        display: flex;
        min-height: calc(100vh - 70px);
        background: #f8fafc;
    }

    .admin-main {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
        transition: var(--admin-transition);
    }

    .flood-card {
        background: white;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .risk-badge {
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .risk-high {
        background: rgba(255, 0, 0, 0.1);
        color: red;
    }

    .risk-moderate {
        background: rgba(255, 165, 0, 0.1);
        color: orange;
    }

    .risk-low {
        background: rgba(0, 128, 0, 0.1);
        color: green;
    }

    .risk-safe {
        background: rgba(49, 151, 149, 0.1);
        color: #319795;
    }

    .table th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        border: none;
    }

    .panel-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 1060;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .panel-content {
        background: white;
        width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<div class="admin-layout d-flex">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="admin-main p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Flood Zones Management</h2>
                <p class="text-muted">Manage boundaries and risk levels for flood-prone areas.</p>
            </div>
            <button class="btn btn-primary rounded-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;" onclick="openAdd()">
                <i class="fas fa-plus me-2"></i>New Flood Zone
            </button>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div><?= $_SESSION['flash_message'];
                        unset($_SESSION['flash_message']); ?></div>
            </div>
        <?php endif; ?>

        <div class="flood-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Zone Name & Risk Level</th>
                            <th>Polygon Nodes</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($zones)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No flood zones defined yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($zones as $zone): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($zone['zone_name']) ?></div>
                                        <span class="risk-badge risk-<?= htmlspecialchars($zone['risk_level']) ?> small"><?= htmlspecialchars($zone['risk_level']) ?></span>
                                    </td>
                                    <td>
                                        <div class="text-truncate small text-muted" style="max-width: 400px; font-family: monospace;">
                                            <?= htmlspecialchars(json_encode($zone['polygon'])) ?>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <?php
                                        // Prepare item data for the JS editor
                                        $editData = [
                                            'id' => $zone['id'],
                                            'zone_name' => $zone['zone_name'],
                                            'risk_level' => $zone['risk_level'],
                                            'polygon' => json_encode($zone['polygon'])
                                        ];
                                        ?>
                                        <button class="btn btn-light btn-sm rounded-circle me-1" onclick='openEdit(<?= json_encode($editData) ?>)'><i class="fas fa-edit text-primary"></i></button>
                                        <a href="index.php?route=admin-flood-zones-delete&id=<?= $zone['id'] ?>" class="btn btn-light btn-sm rounded-circle text-danger" onclick="return confirm('Remove this flood zone boundary?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Edit Overlay -->
<div id="itemOverlay" class="panel-overlay">
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0" id="panelTitle">Flood Zone</h3>
            <button class="btn btn-light rounded-circle" onclick="closePanel()"><i class="fas fa-times"></i></button>
        </div>

        <form id="itemForm" action="index.php?route=admin-flood-zones-create" method="POST">
            <input type="hidden" name="id" id="itemId">

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Zone Name</label>
                <input type="text" name="zone_name" id="itemTitle" class="form-control bg-light border-0 py-2 rounded-3" required placeholder="e.g. Toril River Bank">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Risk Level</label>
                <select name="risk_level" id="itemCategory" class="form-select bg-light border-0 py-2 rounded-3" required>
                    <option value="safe">Safe (Elevated/Secure)</option>
                    <option value="low">Low Risk</option>
                    <option value="moderate">Moderate Risk</option>
                    <option value="high">High Risk</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted d-flex justify-content-between">
                    <span>Draw Polygon on Map</span>
                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="clearMap()"><i class="fas fa-eraser me-1"></i>Clear Map</button>
                </label>
                <div id="drawingMap" style="height: 300px; width: 100%; border-radius: 0.5rem; border: 1px solid #e2e8f0; margin-bottom: 0.5rem;"></div>
                <textarea name="polygon" id="itemDescription" class="form-control bg-light border-0 py-2 rounded-3" rows="3" required style="font-family: monospace; font-size: 0.75rem;" placeholder='[{"lat": 7.031, "lng": 125.446}, ...]' readonly></textarea>
                <small class="text-muted d-block mt-1">Use the shape tool on the map to draw boundaries. The coordinates will update automatically.</small>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold py-3 rounded-3 mt-2 shadow-sm border-0" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                Save Flood Zone
            </button>
        </form>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8&libraries=drawing,geometry"></script>
<script>
    let map;
    let drawingManager;
    let currentPolygon = null;

    function initMap() {
        map = new google.maps.Map(document.getElementById("drawingMap"), {
            center: {
                lat: 7.028012,
                lng: 125.447948
            }, // Toril Center
            zoom: 14,
            mapTypeId: 'roadmap',
            streetViewControl: false,
            mapTypeControl: true,
            fullscreenControl: false
        });

        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON],
            },
            polygonOptions: {
                fillColor: '#3b82f6',
                fillOpacity: 0.4,
                strokeWeight: 2,
                clickable: false,
                editable: true,
                zIndex: 1,
            },
        });

        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
            if (currentPolygon) currentPolygon.setMap(null); // Replace existing
            currentPolygon = polygon;
            drawingManager.setDrawingMode(null); // Stop drawing

            updatePolygonData();

            // Listen for edits
            google.maps.event.addListener(polygon.getPath(), 'set_at', updatePolygonData);
            google.maps.event.addListener(polygon.getPath(), 'insert_at', updatePolygonData);
        });
    }

    function updatePolygonData() {
        if (!currentPolygon) return;
        const path = currentPolygon.getPath();
        const coords = [];
        for (let i = 0; i < path.getLength(); i++) {
            const point = path.getAt(i);
            coords.push({
                lat: point.lat(),
                lng: point.lng()
            });
        }
        document.getElementById('itemDescription').value = JSON.stringify(coords);
    }

    function clearMap() {
        if (currentPolygon) {
            currentPolygon.setMap(null);
            currentPolygon = null;
        }
        document.getElementById('itemDescription').value = '';
        drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
    }

    function loadPolygonToMap(coordsJson) {
        if (currentPolygon) {
            currentPolygon.setMap(null);
        }
        document.getElementById('itemDescription').value = coordsJson;

        try {
            const coords = JSON.parse(coordsJson);
            if (coords && coords.length > 0) {
                currentPolygon = new google.maps.Polygon({
                    paths: coords,
                    fillColor: '#3b82f6',
                    fillOpacity: 0.4,
                    strokeWeight: 2,
                    editable: true,
                    map: map
                });
                drawingManager.setDrawingMode(null); // Switch to edit mode

                // Listen for edits on loaded polygon
                google.maps.event.addListener(currentPolygon.getPath(), 'set_at', updatePolygonData);
                google.maps.event.addListener(currentPolygon.getPath(), 'insert_at', updatePolygonData);

                // Center map on polygon
                const bounds = new google.maps.LatLngBounds();
                coords.forEach(c => bounds.extend(new google.maps.LatLng(c.lat, c.lng)));
                map.fitBounds(bounds);
            } else {
                drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
            }
        } catch (e) {
            console.error("Invalid polygon JSON", e);
            drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        }
    }

    function openAdd() {
        document.getElementById('panelTitle').innerText = 'New Flood Zone';
        document.getElementById('itemForm').action = 'index.php?route=admin-flood-zones-create';
        document.getElementById('itemId').value = '';
        document.getElementById('itemForm').reset();
        document.getElementById('itemOverlay').style.display = 'flex';

        // Auto-init map or clear if needed
        if (!map) initMap();
        else {
            clearMap();
            map.setCenter({
                lat: 7.028012,
                lng: 125.447948
            });
            map.setZoom(14);
        }
    }

    function openEdit(item) {
        document.getElementById('panelTitle').innerText = 'Modify Flood Zone';
        document.getElementById('itemForm').action = 'index.php?route=admin-flood-zones-edit';
        document.getElementById('itemId').value = item.id;
        document.getElementById('itemTitle').value = item.zone_name;
        document.getElementById('itemCategory').value = item.risk_level;

        document.getElementById('itemOverlay').style.display = 'flex';

        if (!map) initMap();

        // Load existing polygon onto the map and into textarea
        setTimeout(() => {
            loadPolygonToMap(item.polygon);
        }, 100);
    }

    function closePanel() {
        document.getElementById('itemOverlay').style.display = 'none';
    }

    window.addEventListener('load', initMap);
</script>