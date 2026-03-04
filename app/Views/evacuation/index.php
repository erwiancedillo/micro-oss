<!-- Evacuation Map View -->
<style>
    .map-container { height: 75vh; min-height: 500px; width: 100%; border-radius: 15px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .location-badge { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2); }
    .info-panel { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 150px; }
    .btn-action { font-weight: 600; border-radius: 10px; padding: 12px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
    .status-badge { padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; }
    .status-vacant { background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .status-limited { background-color: #fffbeb; color: #92400e; border: 1px solid #fef3c7; }
    .status-full { background-color: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
    
    @media (max-width: 991.98px) {
        .map-container { height: 60vh; }
        .row-reverse-mobile { flex-direction: column-reverse; }
    }
</style>

<div class="main-container py-4">
    <div class="page-header mb-4">
        <h1 class="page-title d-flex align-items-center">
            <i class="fas fa-running me-3 text-primary"></i>
            Evacuation & Navigation
        </h1>
        <p class="text-muted">Find the nearest evacuation centers and get real-time directions based on your location.</p>
    </div>

    <div class="row row-reverse-mobile g-4">
        <!-- MAP SECTION -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-2 position-relative">
                    <div id="map" class="map-container"></div>
                    <button id="sidebarToggle" class="btn btn-sm btn-light border shadow-sm d-lg-none position-absolute" style="top:20px; right:20px; z-index:1000; border-radius: 8px;">
                        <i class="fas fa-info-circle me-1 text-primary"></i> Station Info
                    </button>
                </div>
            </div>
        </div>

        <!-- SIDEBAR SECTION -->
        <div id="sidebar" class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-primary">
                            <i class="fas fa-location-arrow fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Navigation Controls</h5>
                    </div>

                    <div class="location-badge shadow-sm" id="location-display">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            <span>Initializing GPS...</span>
                        </div>
                    </div>

                    <div class="d-grid gap-3 mb-4">
                        <button class="btn btn-primary btn-action shadow-sm" onclick="findNearest()">
                            <i class="fas fa-search-location me-2"></i>Find Nearest Center
                        </button>
                        <button class="btn btn-outline-secondary btn-action" onclick="resetMap()">
                            <i class="fas fa-redo-alt me-2"></i>Reset Map & Route
                        </button>
                    </div>
                    
                    <hr class="my-4 opacity-10">
                    
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-info-circle text-muted me-2"></i>
                        <h6 class="fw-bold text-muted mb-0 small text-uppercase" style="letter-spacing: 1px;">Selected Center Details</h6>
                    </div>
                    
                    <div id="info-panel" class="info-panel d-flex flex-column justify-content-center align-items-center text-muted text-center py-4 rounded-3 border-dashed" style="border: 2px dashed #e2e8f0; background: #fafafa;">
                        <i class="fas fa-map-marked-alt fa-3x mb-3 opacity-20"></i>
                        <p class="small mb-0">Select an evacuation center marker on the map to see real-time updates and capacity.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC7jJfgpwDI4SU8CmxD3OUsgIJ_OXpnl8&libraries=geometry,directions"></script>
<script src="/micro-oss/assets/js/map-init.js"></script>
<script src="/micro-oss/assets/js/floodzones.js"></script>

<script>
    function updateLocationDisplay() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(position => {
                const lat = position.coords.latitude.toFixed(6);
                const lng = position.coords.longitude.toFixed(6);
                const accuracy = position.coords.accuracy.toFixed(0);
                document.getElementById('location-display').innerHTML = 
                    `<div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Live GPS Active</div>
                            <div class="small opacity-75">${lat}, ${lng} (±${accuracy}m)</div>
                        </div>
                    </div>`;
            }, () => {
                document.getElementById('location-display').innerHTML = 
                    `<div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span>Location Access Denied</span>
                    </div>`;
            }, { enableHighAccuracy: true });
        }
    }

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            if (sidebar.classList.contains('d-none')) {
                sidebar.classList.remove('d-none');
                sidebarToggle.innerHTML = '<i class="fas fa-times me-1"></i> Close Info';
            } else {
                sidebar.classList.add('d-none');
                sidebarToggle.innerHTML = '<i class="fas fa-info-circle me-1"></i> Station Info';
            }
        });
    }

    function checkLayout() {
        if (window.innerWidth < 992) {
            if (!sidebar.classList.contains('d-none')) {
                sidebar.classList.add('d-none');
            }
        } else {
            sidebar.classList.remove('d-none');
        }
    }

    window.addEventListener('load', () => {
        updateLocationDisplay();
        checkLayout();
    });
    window.addEventListener('resize', checkLayout);
</script>