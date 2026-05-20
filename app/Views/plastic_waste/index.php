<style>
    .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .hero-waste {
        background: linear-gradient(135deg, #22c55e 0%, #166534 100%);
        border-radius: 15px; color: white; padding: 2.5rem; margin-bottom: 2rem;
    }
    #garbageMap { height: 350px; border-radius: 10px; border: 1px solid #e2e8f0; }
    .badge-soft-success { background: #dcfce7; color: #166534; }
</style>

<div class="container mb-5">
    <div class="hero-waste shadow">
        <h2 class="fw-bold"><i class="fas fa-recycle me-3"></i>Plastic Waste Management</h2>
        <p class="mb-0 text-white-50">Track your recycled materials and find the nearest junkshops.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <h5 class="text-success fw-bold border-bottom pb-2 mb-3"><i class="fas fa-plus-circle me-2"></i>"My Junk" Listing</h5>
                <form id="wasteListingForm">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Material Type</label>
                        <select class="form-select bg-light border-0" name="type" required>
                            <option value="Plastic Bottles (PET)">Plastic Bottles (PET)</option>
                            <option value="Hard Plastics">Hard Plastics</option>
                            <option value="Cardboard/Paper">Cardboard/Paper</option>
                            <option value="Scrap Metal">Scrap Metal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Estimated Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" class="form-control bg-light border-0" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-muted fw-bold">Pickup Location / Address</label>
                        <input type="text" name="location" class="form-control bg-light border-0" required>
                    </div>
                    
                    <input type="hidden" name="latitude" id="latInput">
                    <input type="hidden" name="longitude" id="lngInput">
                    <p class="small text-muted mb-2"><i id="gpsStatusIcon" class="fas fa-satellite-dish me-1"></i> <span id="gpsStatus">Acquiring GPS location...</span></p>

                    <button class="btn btn-success w-100 rounded-pill shadow-sm fw-bold">List for Pickup</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-card p-4 h-100">
                <h5 class="text-success fw-bold border-bottom pb-2 mb-3"><i class="fas fa-truck me-2"></i>Garbage Pickup Locator</h5>
                <div id="garbageMap"></div>
            </div>
        </div>
        
        <div class="col-12 mt-4">
            <div class="glass-card p-4">
                <h5 class="text-success fw-bold border-bottom pb-2 mb-3"><i class="fas fa-list me-2"></i>Recent Community Listings</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Material</th>
                                <th>Weight</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Date listed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($allListings as $list): ?>
                            <tr>
                                <td><?= htmlspecialchars($list['first_name'] . ' ' . $list['last_name']) ?></td>
                                <td><i class="fas fa-box-open text-muted me-2"></i><?= htmlspecialchars($list['type']) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($list['weight']) ?> kg</td>
                                <td><?= htmlspecialchars($list['location']) ?></td>
                                <td><span class="badge badge-soft-success border px-2 py-1 rounded-pill"><?= ucfirst(htmlspecialchars($list['status'])) ?></span></td>
                                <td class="text-muted small"><?= date('M d, Y', strtotime($list['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($allListings)): ?>
                                <tr><td colspan="6" class="text-center py-4 text-muted">No listings found. Be the first to recycle!</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8"></script>
<script>
// Geolocation capture
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
        document.getElementById('latInput').value = position.coords.latitude;
        document.getElementById('lngInput').value = position.coords.longitude;
        document.getElementById('gpsStatus').innerText = 'GPS location locked';
        document.getElementById('gpsStatus').className = 'text-success';
        document.getElementById('gpsStatusIcon').className = 'fas fa-map-marker-alt text-success me-1';
    }, error => {
        document.getElementById('gpsStatus').innerText = 'Unable to get location.';
    });
}

document.getElementById('wasteListingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('/micro-oss/index.php?route=api-waste-add', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert(res.message); window.location.reload();
            } else {
                alert('Error: ' + res.message);
            }
        });
});

let map;
function initMap() {
    map = new google.maps.Map(document.getElementById('garbageMap'), {
        center: {lat: 7.0280, lng: 125.4480}, // Default to Lizada/Daliao area
        zoom: 14,
        styles: [
            { "featureType": "poi", "stylers": [{ "visibility": "off" }] }
        ]
    });

    const listings = <?= json_encode($allListings) ?>;
    const greenMarker = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";

    listings.forEach(list => {
        if (list.latitude && list.longitude && list.status === 'pending') {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(list.latitude), lng: parseFloat(list.longitude) },
                map: map,
                title: list.type,
                icon: greenMarker
            });

            const infowindow = new google.maps.InfoWindow({
                content: `<div style="font-family: Inter, sans-serif; max-width: 200px;">
                    <h6 class="fw-bold text-success mb-1"><i class="fas fa-trash me-2"></i>Pickup Request</h6>
                    <p class="small mb-1"><strong>Material:</strong> ${list.type}</p>
                    <p class="small mb-1"><strong>Weight:</strong> ${list.weight} kg</p>
                    <p class="small mb-0 text-muted">Posted: ${new Date(list.created_at).toLocaleDateString()}</p>
                </div>`
            });

            marker.addListener("click", () => {
                infowindow.open(map, marker);
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', initMap);
</script>
