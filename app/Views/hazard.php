<?php
// session_start(); // Session is usually handled in controller or index.php
// include('config.php'); // Not needed if using MVC
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hazard Map - Micro OSS App</title>
    <!-- Use Bootstrap 5 for consistency -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="/micro-oss/assets/css/hazard.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <?php include __DIR__ . '/includes/nav.php'; ?>

    <!-- Mobile Sidebar Toggle Button -->
    <button class="btn btn-primary d-lg-none shadow-sm position-fixed mobile-sidebar-toggle"
        style="top: 15px; left: 15px; z-index: 1040; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#mobileSidebar"
        aria-controls="mobileSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <?php include __DIR__ . '/includes/mobile-sidebar.php'; ?>
    <?php include __DIR__ . '/includes/mobile-bottom-nav.php'; ?>

    <div class="main-container">
        <div class="row">
            <!-- Map Image Section -->
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <h4 class="section-title">
                        <i class="fas fa-map me-2"></i>Hazard Map
                    </h4>
                    <div class="image-wrapper" id="map-container">
                        <?php
                        $defaultMap = $formattedMaps[0] ?? ['image_url' => 'toril.png', 'name' => 'Toril District'];
                        ?>
                        <img id="hazard-map" src="<?= htmlspecialchars($defaultMap['image_url']) ?>" alt="<?= htmlspecialchars($defaultMap['name']) ?>" />
                        <div class="zoom-controls">
                            <button onclick="zoomIn()" title="Zoom In"><i class="fas fa-plus"></i></button>
                            <button onclick="zoomOut()" title="Zoom Out"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controls Section -->
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <h4 class="section-title">
                        <i class="fas fa-columns me-2"></i>Barangay Details
                    </h4>

                    <div class="alert-info-custom mb-4">
                        <strong><i class="fas fa-search me-1"></i> Search for Barangay:</strong>
                        <p class="mb-0 mt-1 small">Select a barangay to view detailed risk areas.</p>
                    </div>

                    <form>
                        <div class="mb-3">
                            <label for="barangaySelect" class="form-label fw-bold">Barangay</label>
                            <select class="form-select" id="barangaySelect" onchange="updateImage()">
                                <option value="">-- Select --</option>
                                <?php foreach ($formattedMaps as $map): ?>
                                    <option value="<?= $map['id'] ?>"><?= htmlspecialchars($map['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                    <div class="mt-4 border-top pt-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Risk Level Legend</h5>
                        <div class="risk-legend">
                            <div class="legend-item level-safe">
                                <div class="level-color"><i class="fas fa-check"></i></div>
                                <div class="level-info">
                                    <div class="level-name">Safe (Low Risk)</div>
                                    <p class="level-desc">Normal conditions. Stay alert for updates.</p>
                                </div>
                            </div>
                            <div class="legend-item level-advisory">
                                <div class="level-color"><i class="fas fa-info"></i></div>
                                <div class="level-info">
                                    <div class="level-name">Advisory (Moderate Risk)</div>
                                    <p class="level-desc">Potential flood threat. Prepare necessary items.</p>
                                </div>
                            </div>
                            <div class="legend-item level-watch">
                                <div class="level-color"><i class="fas fa-eye"></i></div>
                                <div class="level-info">
                                    <div class="level-name">Watch (High Risk)</div>
                                    <p class="level-desc">Flooding is possible. Be ready for evacuation.</p>
                                </div>
                            </div>
                            <div class="legend-item level-warning">
                                <div class="level-color"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="level-info">
                                    <div class="level-name">Warning (Critical Risk)</div>
                                    <p class="level-desc">Flooding imminent. Evacuate immediately.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>


    <script>
        const hazardMapsData = <?= json_encode($formattedMaps) ?>;
        let scale = 1;

        function zoomIn() {
            scale += 0.1;
            document.getElementById('hazard-map').style.transform = `scale(${scale})`;
        }

        function zoomOut() {
            scale = Math.max(0.1, scale - 0.1);
            document.getElementById('hazard-map').style.transform = `scale(${scale})`;
        }

        function updateImage() {
            const selectedId = document.getElementById('barangaySelect').value;
            const mapData = hazardMapsData.find(m => m.id == selectedId);
            const img = document.getElementById('hazard-map');

            if (!mapData) {
                // Default back to first if none selected
                const defaultMap = hazardMapsData[0];
                img.src = defaultMap.image_url;
                return;
            }

            // Add fade effect
            img.style.opacity = '0';
            setTimeout(() => {
                img.src = mapData.image_url;
                img.style.opacity = '1';
            }, 300);

            // Reset zoom
            scale = 1;
            img.style.transform = `scale(${scale})`;
            img.style.transformOrigin = 'center center';
        }
    </script>


    <?php include __DIR__ . '/includes/scripts.php'; ?>
</body>

</html>