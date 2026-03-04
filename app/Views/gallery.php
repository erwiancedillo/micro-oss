
<style>
    /* Styles adapted for MVC layout context */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        flex: 1;
        width: 100%;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0;
        text-align: center;
    }

    .page-subtitle {
        font-size: 1.2rem;
        margin: 10px 0 0 0;
        text-align: center;
        opacity: 0.9;
    }

    .content-container {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border-left: 4px solid #8b5cf6;
    }

    .stats-card h5,
    .stats-card h2 {
        color: #8b5cf6;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .section-title {
        color: #8b5cf6;
        font-weight: bold;
        margin-bottom: 20px;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 10px;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        transition: transform 0.2s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .gallery-card {
        margin-bottom: 20px;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
        border: none;
        background: #fff;
        overflow: hidden;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    #map {
        height: 300px;
        width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    @media (min-width: 768px) {
        #map {
            height: 400px;
        }
    }

    .sticky-search {
        position: sticky;
        top: 20px;
        z-index: 900;
    }

    .modal-header {
        background-color: #8b5cf6;
        color: white;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8&libraries=places"></script>

<div class="main-container mb-5">
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['flash_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-images me-3"></i>Community Gallery
        </h1>
        <p class="page-subtitle">Visual Archive of Barangay Conditions</p>
    </div>

    <div class="row">
        <!-- Gallery Section -->
        <div class="col-lg-8">
            <div class="content-container">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                    <h4 class="mb-0 text-purple" style="color: #8b5cf6; font-weight: bold;">
                        <i class="fas fa-photo-video me-2"></i>Photo Stream
                    </h4>
                    <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                        <i class="fas fa-upload me-2"></i>Upload Photo
                    </button>
                </div>

                <div class="row">
                    <?php if (!empty($photos)): ?>
                        <?php foreach ($photos as $row): 
                            $photo = base64_encode($row['photo']);
                            $barangayName = htmlspecialchars($row['barangay'], ENT_QUOTES, 'UTF-8');
                            $sitioPurokName = htmlspecialchars($row['sitio_purok'], ENT_QUOTES, 'UTF-8');
                            $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
                        ?>
                            <div class="col-6 col-md-6 mb-4">
                                <div class="card gallery-card h-100">
                                    <img src="data:image/jpeg;base64,<?= $photo ?>" class="card-img-top" alt="<?= $barangayName ?> - <?= $sitioPurokName ?>">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted fw-bold"><?= ucfirst($barangayName) ?> - <?= ucfirst($sitioPurokName) ?></h6>
                                        <p class="card-text small"><?= $description ?></p>
                                        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                                            <div class="mt-3 d-flex justify-content-end border-top pt-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="openEditModal(<?= $row['id'] ?>, '<?= addslashes($barangayName) ?>', '<?= addslashes($sitioPurokName) ?>', '<?= addslashes($description) ?>', <?= $row['latitude'] ?>, <?= $row['longitude'] ?>)">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <a href="index.php?route=gallery-delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this photo?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <div class="text-muted"><i class="fas fa-images fa-3x mb-3 text-light"></i><p class="lead">
                            <?php if (!empty($selectedSitio) || !empty($selectedBarangay)): ?>
                                No records found for the selected filters.
                            <?php else: ?>
                                No photos in the gallery yet. Be the first to upload!
                            <?php endif; ?>
                            </p></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="col-lg-4">
            <div class="sticky-search">
                <div class="stats-card">
                    <h5><i class="fas fa-search me-2"></i>Filter Gallery</h5>
                    <form action="index.php?route=gallery" method="post">
                        <div class="mb-3">
                            <label for="filterBarangay" class="form-label text-muted fw-bold">Barangay</label>
                            <select class="form-select bg-light" id="filterBarangay" name="barangay">
                                <option value="">-- All Barangays --</option>
                            </select>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-outline-primary fw-bold">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title fw-bold" id="uploadPhotoModalLabel"><i class="fas fa-cloud-upload-alt me-2"></i><span id="modalActionTitle">Upload Evacuation/Flood Photo</span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="photoForm" action="index.php?route=gallery-upload" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="photoIdModal" value="">
                <div class="modal-body p-4 bg-light">
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label for="barangayModal" class="form-label fw-bold small text-muted">Barangay</label>
                            <select class="form-select border-0 shadow-sm" id="barangayModal" name="barangay" required>
                                <option value="">--Select Barangay--</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="sitioModal" class="form-label fw-bold small text-muted">Exact Address / Location</label>
                            <input type="text" class="form-control border-0 shadow-sm bg-white" id="sitioModal" name="sitio" required readonly placeholder="Map address will appear here">
                        </div>
                    </div>
                    
                    <div class="mb-4 mt-3">
                        <label for="photo" class="form-label fw-bold small text-muted">Photo Selection (Camera)</label>
                        <input type="file" class="form-control border-0 shadow-sm p-3 bg-white" id="photo" name="photo" accept="image/*" capture="environment" onchange="previewPhoto(event)">
                        <small class="text-info" id="editPhotoNote" style="display: none;">Leave blank to keep the current photo.</small>
                    </div>

                    <!-- Location Fields -->
                    <div class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label fw-bold small text-muted">Latitude</label>
                            <input type="text" name="latitude" id="latitude" placeholder="Select on map" class="form-control border-0 shadow-sm bg-white" required readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label fw-bold small text-muted">Longitude</label>
                            <input type="text" name="longitude" id="longitude" placeholder="Select on map" class="form-control border-0 shadow-sm bg-white" required readonly>
                        </div>
                    </div>

                    <div class="mb-4 mt-3">
                        <label class="form-label fw-bold small text-muted">Identify Location on Map</label>
                        <div id="map" class="shadow-sm border-0"></div>
                        <small class="text-secondary d-block mt-2"><i class="fas fa-info-circle me-1"></i>Drag the marker to pinpoint the exact photo location.</small>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="description" class="form-label fw-bold small text-muted">Description (What happened?)</label>
                            <textarea class="form-control border-0 shadow-sm bg-white" id="description" name="description" rows="5" placeholder="Describe the flood situation or community event..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Image Preview</label>
                            <div id="photoPreview" class="text-center p-2 bg-white rounded-3 border-0 shadow-sm d-flex align-items-center justify-content-center" style="height: 125px;">
                                <img id="previewImage" src="#" alt="Photo Preview" class="img-fluid rounded" style="max-height: 100%; display: none;">
                                <span id="previewPlaceholder" class="text-muted small"><i class="fas fa-image fa-2x mb-2 d-block opacity-50"></i>No active image</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 bg-light">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;" id="btnSubmitPhoto">Post Photo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Selected states from PHP
    const currentSelectedBarangay = "<?= $selectedBarangay ?? '' ?>";
    const currentSelectedSitio = "<?= $selectedSitio ?? '' ?>";

    // Dynamic data fetching functions hitting our MVC API route
    async function fetchBarangays() {
        try {
            const response = await fetch('index.php?route=api-locations&action=barangays');
            return await response.json();
        } catch (error) {
            console.error('Error fetching barangays:', error);
            return [];
        }
    }

    async function fetchSitios(barangay) {
        try {
            const response = await fetch(`index.php?route=api-locations&action=sitios&barangay=${encodeURIComponent(barangay)}`);
            return await response.json();
        } catch (error) {
            console.error('Error fetching sitios:', error);
            return [];
        }
    }

    // Populate barangay dropdown
    async function populateBarangayDropdown(selectId, defaultSel = '') {
        const barangays = await fetchBarangays();
        const selectElement = document.getElementById(selectId);
        
        // Save current selection to restore it if needed
        const prevValue = selectElement.value || defaultSel;

        selectElement.innerHTML = selectId.includes('filter') ? '<option value="">-- All Barangays --</option>' : '<option value="">--Select Barangay--</option>';

        barangays.forEach(barangay => {
            const option = document.createElement('option');
            // Keep actual value
            option.value = barangay;
            option.textContent = barangay;
            if (barangay === prevValue || barangay.toLowerCase() === prevValue.toLowerCase()) {
                option.selected = true;
            }
            selectElement.appendChild(option);
        });

        // Trigger change to load sitios if a default was selected
        if (prevValue) {
            selectElement.dispatchEvent(new Event('change'));
        }
    }

    // Update sitio dropdown based on selected barangay
    async function updateSitioOptions(barangayId, sitioId, defaultSitio = '') {
        const barangaySelect = document.getElementById(barangayId);
        const sitioSelect = document.getElementById(sitioId);
        const selectedBarangay = barangaySelect.value;
        const prevSitio = sitioSelect.value || defaultSitio;

        sitioSelect.innerHTML = sitioId.includes('filter') ? '<option value="">-- All Sitios --</option>' : '<option value="">--Select Sitio--</option>';

        if (selectedBarangay) {
            const sitios = await fetchSitios(selectedBarangay);

            sitios.forEach(sitio => {
                const option = document.createElement('option');
                option.value = sitio;
                option.textContent = sitio;
                if (sitio === prevSitio || sitio.toLowerCase() === prevSitio.toLowerCase()) {
                    option.selected = true;
                }
                sitioSelect.appendChild(option);
            });
        }
    }

    // Initialize event listeners
    document.addEventListener("DOMContentLoaded", async () => {
        // Form filters dropdowns
        await populateBarangayDropdown('filterBarangay', currentSelectedBarangay);
        
        // Modal upload dropdowns
        await populateBarangayDropdown('barangayModal');

        // Set up change event listeners for Filter panel
        document.getElementById("filterBarangay").addEventListener("change", () =>
            updateSitioOptions("filterBarangay", "filterSitio", currentSelectedSitio)
        );
        
        // Setup change triggers for Form modal removed, handled visually internally.
        
        // Reset modal to upload mode when hidden
        const modalEl = document.getElementById('uploadPhotoModal');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function() {
                document.getElementById('photoForm').reset();
                document.getElementById('photoForm').action = 'index.php?route=gallery-upload';
                document.getElementById('photoIdModal').value = '';
                document.getElementById('modalActionTitle').innerText = 'Upload Evacuation/Flood Photo';
                document.getElementById('btnSubmitPhoto').innerText = 'Post Photo';
                document.getElementById('photo').required = true;
                document.getElementById('editPhotoNote').style.display = 'none';
                document.getElementById('previewImage').style.display = 'none';
                document.getElementById('previewImage').src = '#';
                document.getElementById('previewPlaceholder').style.display = 'block';
            });
        }
    });

    function openEditModal(id, barangay, sitio, description, lat, lng) {
        document.getElementById('photoForm').action = 'index.php?route=gallery-edit';
        document.getElementById('photoIdModal').value = id;
        document.getElementById('modalActionTitle').innerText = 'Edit Photo Details';
        document.getElementById('btnSubmitPhoto').innerText = 'Save Changes';
        document.getElementById('photo').required = false;
        document.getElementById('editPhotoNote').style.display = 'block';
        
        // Populate fields
        document.getElementById('sitioModal').value = sitio;
        document.getElementById('description').value = description;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        // Select logic
        const brgySelect = document.getElementById('barangayModal');
        brgySelect.value = barangay;
        if (!brgySelect.value) {
            // Search case-insensitive if direct match fails
            for (let i = 0; i < brgySelect.options.length; i++) {
                if (brgySelect.options[i].text.toLowerCase() === barangay.toLowerCase()) {
                    brgySelect.selectedIndex = i;
                    break;
                }
            }
        }
        
        // Move map marker
        if (mapInstance && markerInstance) {
            const loc = new google.maps.LatLng(lat, lng);
            mapInstance.setCenter(loc);
            markerInstance.setPosition(loc);
        } else {
            // Re-init with this loc instead of default Toril
            window.tempEditLocation = { lat: lat, lng: lng };
        }
        
        // Show modal
        const myModal = new bootstrap.Modal(document.getElementById('uploadPhotoModal'));
        myModal.show();
    }

    // Preview uploaded photo
    function previewPhoto(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById("previewImage");
        const placeholder = document.getElementById("previewPlaceholder");

        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                previewImage.src = reader.result;
                previewImage.style.display = "block";
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = "none";
            if (placeholder) placeholder.style.display = 'block';
        }
    }

    // Initialize Google Map only when modal is visible
    let mapInstance = null;
    let markerInstance = null;
    let geocoder = null;

    function initGoogleMap() {
        const defaultLocation = window.tempEditLocation ? window.tempEditLocation : { lat: 7.0280, lng: 125.4480 }; // Toril default
        const mapContainer = document.getElementById("map");

        if (!mapInstance && mapContainer) {
            mapInstance = new google.maps.Map(mapContainer, {
                center: defaultLocation,
                zoom: 14,
                mapTypeId: 'roadmap',
                streetViewControl: false,
                mapTypeControl: true,
                fullscreenControl: false
            });

            markerInstance = new google.maps.Marker({
                position: defaultLocation,
                map: mapInstance,
                draggable: true,
                animation: google.maps.Animation.DROP,
            });

            geocoder = new google.maps.Geocoder();

            // Click on map to move marker
            google.maps.event.addListener(mapInstance, 'click', function(event) {
                markerInstance.setPosition(event.latLng);
                updateMarkerPosition(event.latLng);
            });
            
            // Drag marker to move
            google.maps.event.addListener(markerInstance, "dragend", () => {
                updateMarkerPosition(markerInstance.getPosition());
            });

            // Try to geolocate if possible
            if (window.tempEditLocation) {
                updateMarkerPosition(new google.maps.LatLng(window.tempEditLocation.lat, window.tempEditLocation.lng));
                window.tempEditLocation = null;
            } else if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };
                        mapInstance.setCenter(userLocation);
                        markerInstance.setPosition(userLocation);
                        updateMarkerPosition(new google.maps.LatLng(userLocation.lat, userLocation.lng));
                    },
                    (error) => console.log("Geolocation ignored or error:", error)
                );
            } else {
                updateMarkerPosition(new google.maps.LatLng(defaultLocation.lat, defaultLocation.lng));
            }
        }
    }

    function updateMarkerPosition(latLng) {
        document.getElementById("latitude").value = latLng.lat().toFixed(6);
        document.getElementById("longitude").value = latLng.lng().toFixed(6);

        // Reverse Geocode to identify Barangay and Exact Address
        if (geocoder) {
            geocoder.geocode({ location: latLng }, (results, status) => {
                if (status === "OK") {
                    if (results[0]) {
                        parseAddressToDropdowns(results[0].address_components);
                        document.getElementById("sitioModal").value = results[0].formatted_address;
                    }
                }
            });
        }
    }

    function parseAddressToDropdowns(components) {
        let detectedBarangay = null;
        
        // Scan address components to find local matching names
        components.forEach(component => {
            const types = component.types;
            if (types.includes('neighborhood') || types.includes('sublocality') || types.includes('locality') || types.includes('administrative_area_level_3') || types.includes('route')) {
                const brgySelect = document.getElementById('barangayModal');
                
                for (let i = 0; i < brgySelect.options.length; i++) {
                    const optionName = brgySelect.options[i].text.toLowerCase();
                    const compName = component.long_name.toLowerCase();
                    
                    if (optionName !== '--select barangay--' && optionName.trim() !== '') {
                        if (compName.includes(optionName) || optionName.includes(compName)) {
                            if (!detectedBarangay) {
                                detectedBarangay = brgySelect.options[i].value;
                            }
                        }
                    }
                }
            }
        });

        // Automatically select if found
        if (detectedBarangay) {
            const brgySelect = document.getElementById('barangayModal');
            if (brgySelect.value !== detectedBarangay) {
                brgySelect.value = detectedBarangay;
                
                // Show a quick visual success feedback effect
                brgySelect.style.backgroundColor = '#dcfce7'; 
                brgySelect.style.transition = 'background-color 0.5s ease';
                setTimeout(() => brgySelect.style.backgroundColor = '', 1500);

                // Auto-load related sitios
                brgySelect.dispatchEvent(new Event('change'));
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const modalEl = document.getElementById('uploadPhotoModal');
        if (modalEl) {
            modalEl.addEventListener('shown.bs.modal', function() {
                initGoogleMap();
            });
        }
    });
</script>
