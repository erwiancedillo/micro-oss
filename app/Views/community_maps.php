<style>
    #map { height: 600px; width: 100%; border-radius: 12px; border: 1px solid #e2e8f0; }
    .map-card { border: none; border-radius: 16px; overflow: hidden; }
    @media (max-width: 768px) {
        #map { height: 400px; }
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card map-card shadow-sm">
            <div class="card-header bg-white p-4 border-0">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <h2 class="fw-bold text-primary mb-0">
                            <i class="fas fa-map-marked-alt me-2"></i>Community Map
                        </h2>
                        <p class="text-muted small mb-0 mt-1">Davao City Disaster Mapping & Resources</p>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="/micro-oss/index.php" class="d-flex align-items-center justify-content-md-end gap-2">
                            <input type="hidden" name="route" value="community-map">
                            <label for="barangay" class="fw-bold text-nowrap d-none d-sm-block">Change Barangay:</label>
                            <select name="barangay" id="barangay" class="form-select w-auto rounded-pill px-3" onchange="this.form.submit()">
                                <option value="Daliao" <?= $barangay=='Daliao'?'selected':'' ?>>Daliao</option>
                                <option value="Lizada" <?= $barangay=='Lizada'?'selected':'' ?>>Lizada</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0 position-relative">
                <?php if (isset($notFound) && $notFound): ?>
                    <div class="alert alert-danger m-3 border-0 shadow-sm">
                        <i class="fas fa-exclamation-circle me-2"></i> No data available for "<?=htmlspecialchars($barangay)?>".
                    </div>
                <?php endif; ?>
                
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8"></script>
<script>
function initMap() {
    var center = { lat: <?= $mapCenter['lat'] ?>, lng: <?= $mapCenter['lng'] ?> };
    var map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 14,
        styles: [{ "featureType": "all", "elementType": "geometry.fill", "stylers": [{ "weight": "2.00" }] }]
    });

    var polygonCoords = <?= $polygonCoordsJS ?>;
    if (polygonCoords.length > 0) {
        new google.maps.Polygon({
            paths: polygonCoords,
            strokeColor: "#4338ca",
            strokeOpacity: 0.8,
            strokeWeight: 2.5,
            fillColor: "#6366f1",
            fillOpacity: 0.2
        }).setMap(map);
    }

    var markers = <?= json_encode($markers) ?>;
    markers.forEach(function(marker) {
        new google.maps.Marker({
            position: {lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude)},
            map: map,
            title: marker.sitio_name,
            icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
        });
    });
}
initMap();
</script>