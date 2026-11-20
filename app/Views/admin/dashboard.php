<!-- Admin Dashboard View - Micro OSS Modern Purple/Indigo Theme -->
<style>
    :root {
        --admin-primary: #667eea;
        --admin-secondary: #764ba2;
        --admin-purple-light: #c084fc;
        --admin-lavender: #eef2ff;
        --admin-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --admin-gradient-hover: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        --admin-bg: #f8fafc;
        --admin-card-bg: #ffffff;
        --admin-card-radius: 20px;
        --admin-card-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.8);
        --admin-card-hover-shadow: 0 20px 40px -8px rgba(102, 126, 234, 0.16), 0 0 0 1px rgba(139, 92, 246, 0.25);
    }

    body {
        background-color: var(--admin-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .admin-layout {
        display: flex;
        min-height: calc(100vh - 70px);
        background: var(--admin-bg);
    }

    .admin-main {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
    }

    /* Modern Dashboard Header Banner */
    .dashboard-header-banner {
        background: linear-gradient(135deg, #0f142b 0%, #171d42 100%);
        border-radius: var(--admin-card-radius);
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

    .pulse-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse 1.8s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
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

    /* Primary Gradient Button */
    .btn-gradient-primary {
        background: var(--admin-gradient);
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
        background: var(--admin-gradient-hover);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(118, 75, 162, 0.45);
    }

    /* Stats Cards */
    .stats-card {
        background: var(--admin-card-bg);
        border-radius: var(--admin-card-radius);
        padding: 1.5rem;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--admin-card-shadow);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle at 100% 0%, rgba(102, 126, 234, 0.08), transparent 70%);
        pointer-events: none;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--admin-card-hover-shadow);
        border-color: rgba(139, 92, 246, 0.3);
    }

    .stats-icon {
        width: 3.25rem;
        height: 3.25rem;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .stats-num {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.1;
    }

    .stats-label {
        font-size: 0.825rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .bg-soft-primary { background: #eef2ff; color: #667eea; }
    .bg-soft-success { background: #ecfdf5; color: #10b981; }
    .bg-soft-warning { background: #fffbeb; color: #f59e0b; }
    .bg-soft-danger  { background: #fef2f2; color: #ef4444; }

    /* Map & Metrics Cards */
    .content-card {
        background: var(--admin-card-bg);
        border-radius: var(--admin-card-radius);
        padding: 1.5rem;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--admin-card-shadow);
        margin-bottom: 2rem;
    }

    .card-header-styled {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1.25rem;
    }

    .card-header-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-title i {
        color: var(--admin-primary);
    }

    #map {
        height: 480px;
        width: 100%;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
    }

    .legend-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: 0.775rem;
        font-weight: 600;
        color: #475569;
    }

    .legend-indicator {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }

    /* Table & Directory View */
    .table-container-card {
        background: var(--admin-card-bg);
        border-radius: var(--admin-card-radius);
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--admin-card-shadow);
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
        border-top: none;
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

    .status-badge {
        padding: 5px 12px;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Search Bar */
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
        border-color: var(--admin-primary);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
        outline: none;
    }

    /* Slide-out Edit Panel */
    .edit-panel-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1050;
        transition: opacity 0.3s ease;
    }

    .edit-panel {
        position: fixed;
        right: 0;
        top: 0;
        width: min(460px, 100vw);
        height: 100vh;
        background: #ffffff;
        box-shadow: -15px 0 50px rgba(15, 23, 42, 0.2);
        padding: 2.25rem 2rem;
        overflow-y: auto;
        z-index: 1051;
        transform: translateX(100%);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .edit-panel.active {
        transform: translateX(0);
    }

    .form-input-styled {
        height: 48px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 0.9rem;
        color: #0f172a;
        background: #ffffff;
        transition: all 0.2s ease;
        width: 100%;
    }

    .form-input-styled:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3.5px rgba(102, 126, 234, 0.12);
        outline: none;
    }

    /* Custom Toast */
    .custom-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        background: #ffffff;
        color: #1e293b;
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 15px 35px -5px rgba(102, 126, 234, 0.2), 0 0 0 1px rgba(139, 92, 246, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 320px;
        animation: slideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideInRight {
        from { transform: translateX(120%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .custom-toast.hide {
        animation: fadeOutToast 0.3s ease forwards;
    }

    @keyframes fadeOutToast {
        to { transform: translateX(120%); opacity: 0; }
    }
</style>

<?php
if (empty($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'master'])) {
    echo '<div class="alert alert-warning m-4 rounded-4">Access denied. Administrators only.</div>';
    exit;
}
?>

<div class="admin-layout">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <!-- Main Content -->
    <main class="admin-main">

        <!-- Top Welcome Banner -->
        <div class="dashboard-header-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="header-badge-tag">
                    <span class="pulse-dot"></span>
                    <span>Live Tracking Active</span>
                </div>
                <h1 class="dashboard-title-text">
                    Monitoring <span class="highlight-purple">Dashboard</span>
                </h1>
                <p class="text-white-50 mb-0 small">
                    Live evacuation centers, capacity tracking, and community disaster coordination.
                </p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-gradient-primary" onclick="openPanel()">
                    <i class="fas fa-plus"></i>
                    <span>New Center</span>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-primary">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stats-label">Total Centers</div>
                    <div class="stats-num" id="totalCenters">0</div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-success">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="stats-label">Total Capacity</div>
                    <div class="stats-num" id="totalCapacity">0</div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-warning">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stats-label">Total Occupied</div>
                    <div class="stats-num" id="totalOccupied">0</div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon bg-soft-danger">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-label">System Utilization</div>
                    <div class="stats-num" id="utilization">0%</div>
                </div>
            </div>
        </div>

        <!-- Map & Real-time Metrics Section -->
        <div class="row g-4 mb-4">
            <!-- Left: Interactive Map -->
            <div class="col-lg-8">
                <div class="content-card h-100 mb-0">
                    <div class="card-header-styled">
                        <div class="card-header-title">
                            <i class="fas fa-map-location-dot"></i>
                            <span>Interactive Control Map</span>
                        </div>
                        <div class="small text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-satellite-dish text-success"></i>
                            <span>Real-time GIS Layers</span>
                        </div>
                    </div>

                    <div id="map"></div>

                    <!-- Map Risk Legend -->
                    <div class="mt-3 d-flex gap-2 flex-wrap">
                        <span class="legend-pill">
                            <span class="legend-indicator" style="background: rgba(239, 68, 68, 0.6); border: 1px solid #ef4444;"></span>
                            <span>High Flood Risk</span>
                        </span>
                        <span class="legend-pill">
                            <span class="legend-indicator" style="background: rgba(245, 158, 11, 0.6); border: 1px solid #f59e0b;"></span>
                            <span>Moderate Flood Risk</span>
                        </span>
                        <span class="legend-pill">
                            <span class="legend-indicator" style="background: rgba(16, 185, 129, 0.6); border: 1px solid #10b981;"></span>
                            <span>Low Flood Risk</span>
                        </span>
                        <span class="legend-pill">
                            <span class="legend-indicator" style="background: rgba(102, 126, 234, 0.2); border: 1px solid #667eea;"></span>
                            <span>Barangay Boundary</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Real-time Occupancy Metrics -->
            <div class="col-lg-4">
                <div class="content-card h-100 mb-0 d-flex flex-column justify-content-between">
                    <div>
                        <div class="card-header-styled">
                            <div class="card-header-title">
                                <i class="fas fa-chart-pie"></i>
                                <span>Occupancy Ratio</span>
                            </div>
                        </div>

                        <div style="height: 250px; position: relative;">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">Navigation Guidance</span>
                            <i class="fas fa-compass text-primary small"></i>
                        </div>
                        <div id="directionsPanel" class="bg-light p-3 rounded-3 small text-muted text-center" style="min-height: 120px; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0;">
                            <span>Click any evacuation center on the map to display nearest distance and route info.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Citizen Science Verification -->
        <?php if (isset($pendingReports) && count($pendingReports) > 0): ?>
            <div class="table-container-card mb-4" style="border: 2px solid rgba(245, 158, 11, 0.4);">
                <div class="p-4 bg-white d-flex justify-content-between align-items-center border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <div class="stats-icon bg-soft-warning mb-0" style="width: 2.5rem; height: 2.5rem; font-size: 1.1rem;">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Pending Citizen Science Reports</h5>
                            <small class="text-muted">Awaiting administrator verification</small>
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold">
                        <?= count($pendingReports) ?> Pending
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Timestamp</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingReports as $pr): ?>
                                <tr>
                                    <td>
                                        <a href="/assets/uploads/citizen_science/<?= htmlspecialchars($pr['image']) ?>" target="_blank">
                                            <img src="/assets/uploads/citizen_science/<?= htmlspecialchars($pr['image']) ?>" alt="report" class="rounded-3 object-fit-cover shadow-sm" style="width: 54px; height: 54px; border: 1px solid #e2e8f0;">
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-danger text-danger border border-danger-subtle rounded-pill px-3 py-1">
                                            <?= htmlspecialchars($pr['category']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 220px;" title="<?= htmlspecialchars($pr['description']) ?>">
                                            <?= htmlspecialchars($pr['description'] ?: 'No description provided') ?>
                                        </div>
                                        <small class="text-muted">By: <?= htmlspecialchars($pr['first_name'] . ' ' . $pr['last_name']) ?></small>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($pr['barangay']) ?></strong>
                                        <?php if (!empty($pr['sitio'])): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($pr['sitio']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-muted"><?= date('M j, Y g:i A', strtotime($pr['created_at'])) ?></td>
                                    <td class="text-end">
                                        <a href="index.php?route=admin-citizen-verify&id=<?= $pr['id'] ?>" class="btn btn-sm btn-success rounded-pill px-3 me-1 shadow-sm" title="Verify & Publish">
                                            <i class="fas fa-check me-1"></i> Verify
                                        </a>
                                        <a href="index.php?route=admin-citizen-delete&id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm" title="Reject & Delete" onclick="return confirm('Are you sure you want to reject and delete this report?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Center Management Table -->
        <div class="table-container-card mb-4">
            <div class="p-4 bg-white d-flex justify-content-between align-items-center flex-wrap gap-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="stats-icon bg-soft-primary mb-0" style="width: 2.5rem; height: 2.5rem; font-size: 1.1rem;">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Evacuation Centers Directory</h5>
                        <small class="text-muted">Manage active facilities and shelter capacity</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <?php if (($_SESSION['role'] ?? '') === 'master'): ?>
                    <div class="btn-group btn-group-sm shadow-sm" role="group" id="masterBarangayFilterGroup" style="border-radius: 10px; overflow: hidden;">
                        <button type="button" class="btn btn-primary active px-3 fw-bold" onclick="filterMasterBarangay('all', this)" id="btnFilterAll">All Barangays</button>
                        <button type="button" class="btn btn-outline-primary px-3 fw-bold" onclick="filterMasterBarangay('Lizada', this)">Lizada</button>
                        <button type="button" class="btn btn-outline-primary px-3 fw-bold" onclick="filterMasterBarangay('Dalio', this)">Dalio</button>
                    </div>
                    <?php endif; ?>

                    <!-- Search Input -->
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;"></i>
                        <input type="text" class="table-search-input" id="centerSearchInput" placeholder="Filter centers..." oninput="filterCentersTable()">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="centersTable">
                    <thead>
                        <tr>
                            <th>Center Name</th>
                            <?php if (($_SESSION['role'] ?? '') === 'master'): ?>
                            <th>Barangay</th>
                            <?php endif; ?>
                            <th>GPS Coordinates</th>
                            <th>Capacity / Occupied</th>
                            <th>Utilization</th>
                            <th>Status</th>
                            <th>Evacuees</th>
                            <th class="text-end">Manage</th>
                        </tr>
                    </thead>
                    <tbody id="centersList">
                        <!-- Populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Capacity Overview Bar Chart -->
        <div class="content-card mb-4">
            <div class="card-header-styled">
                <div class="card-header-title">
                    <i class="fas fa-chart-column"></i>
                    <span>Capacity Overview per Center</span>
                </div>
                <div class="small text-muted">Comparative Occupancy Analysis</div>
            </div>
            <div style="height: 340px; position: relative;">
                <canvas id="barChart"></canvas>
            </div>
        </div>

    </main>
</div>

<!-- Slide-out Drawer: Add/Edit Center Panel -->
<div id="editPanelOverlay" class="edit-panel-overlay" style="display:none;" onclick="closePanel()"></div>
<div id="editPanel" class="edit-panel">
    <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <div class="stats-icon bg-soft-primary mb-0" style="width: 2.5rem; height: 2.5rem; font-size: 1.1rem;">
                <i class="fas fa-building-circle-check"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0 text-dark" id="panelTitle">New Center</h4>
                <small class="text-muted">Evacuation center information</small>
            </div>
        </div>
        <button class="btn btn-light rounded-circle border" onclick="closePanel()" style="width: 36px; height: 36px;" aria-label="Close">
            <i class="fas fa-times text-muted"></i>
        </button>
    </div>

    <div id="locationModeBanner" class="alert alert-warning border-0 rounded-3 shadow-sm mb-4 small" style="display:none;">
        <i class="fas fa-map-pin me-2"></i> <strong>Map Selection Mode:</strong> Click any point on the map to set coordinates automatically.
    </div>

    <form id="editForm">
        <input type="hidden" id="centerId">

        <?php if (($_SESSION['role'] ?? '') === 'master'): ?>
        <div class="mb-3" id="barangaySelectContainer">
            <label class="form-label fw-bold small text-muted">Assign to Barangay</label>
            <select class="form-input-styled form-select" id="centerBarangay" required>
                <option value="Dalio">Barangay Dalio</option>
                <option value="Lizada">Barangay Lizada</option>
            </select>
        </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label fw-bold small text-muted">Center Name</label>
            <input type="text" class="form-input-styled" id="centerName" placeholder="e.g. Toril Covered Court" required>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Latitude</label>
                <input type="number" class="form-input-styled" id="centerLat" step="any" placeholder="7.0280" required>
            </div>
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Longitude</label>
                <input type="number" class="form-input-styled" id="centerLng" step="any" placeholder="125.4480" required>
            </div>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-light border w-100 py-2 fw-semibold rounded-3 text-primary" onclick="toggleMapLocationSelection()" id="mapSelectBtn">
                <i class="fas fa-map-location-dot me-2"></i>Pick Coordinates from Map
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Maximum Capacity</label>
                <input type="number" class="form-input-styled" id="centerCapacity" placeholder="e.g. 500" required>
            </div>
            <div class="col-6">
                <label class="form-label fw-bold small text-muted">Current Occupancy</label>
                <input type="number" class="form-input-styled" id="centerOccupied" placeholder="e.g. 120" required>
            </div>
        </div>

        <button type="submit" class="btn btn-gradient-primary w-100 py-3 rounded-3 fw-bold shadow-sm justify-content-center" id="saveCenterBtn">
            <i class="fas fa-save me-2"></i> Save Evacuation Center
        </button>
    </form>
</div>

<!-- Charts & Maps Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let map, markers = [],
        barChart, pieChart, userLocation = null,
        userMarker = null,
        nearestCenter = null,
        allCenters = [];
    let locationSelectionMode = false,
        locationSelectMarker = null,
        routeLayer = null;
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
                nearest = { ...c, distance: dist };
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
                    if (userMarker) userMarker.setLatLng([userLocation.lat, userLocation.lng]);
                    else userMarker = L.circleMarker([userLocation.lat, userLocation.lng], { radius: 8, color: '#fff', weight: 3, fillColor: '#2563eb', fillOpacity: 1 }).addTo(map).bindTooltip('Your Location');
                    nearestCenter = findNearestCenter();
                    if (nearestCenter && document.getElementById('directionsPanel')) {
                        document.getElementById('directionsPanel').innerHTML = `
                            <div class="text-start w-100">
                                <div class="fw-bold text-dark fs-6">${nearestCenter.name}</div>
                                <div class="small text-muted mt-1"><i class="fas fa-route text-primary me-1"></i> Distance: <strong>${nearestCenter.distance.toFixed(2)} km</strong> | Status: <span class="badge ${nearestCenter.status === 'Full' ? 'bg-danger' : 'bg-success'} rounded-pill">${nearestCenter.status}</span></div>
                            </div>`;
                    }
                },
                err => console.log("Location unavailable")
            );
        }
    }

    function getMarkerColor(status) {
        let color = '#16a34a';
        switch (status) {
            case 'Full':
                color = '#dc2626';
                break;
            case 'Limited':
                color = '#f97316';
                break;
        }
        return L.divIcon({ className: 'admin-center-marker', html: `<span style="display:block;width:20px;height:20px;border:2px solid #fff;border-radius:50%;background:${color};box-shadow:0 1px 5px #555"></span>`, iconSize: [20, 20], iconAnchor: [10, 10] });
    }

    async function loadDashboard() {
        try {
            const dashRes = await fetch('/api/dashboard_data.php');
            const dashData = await dashRes.json();

            document.getElementById('totalCenters').innerText = dashData.totalCenters;
            document.getElementById('totalCapacity').innerText = dashData.totalCapacity;
            document.getElementById('totalOccupied').innerText = dashData.totalOccupied;
            const util = dashData.totalCapacity > 0 ? ((dashData.totalOccupied / dashData.totalCapacity) * 100).toFixed(1) : '0';
            document.getElementById('utilization').innerText = util + '%';

            const labels = dashData.centers.map(c => c.name),
                capacity = dashData.centers.map(c => c.capacity),
                occupied = dashData.centers.map(c => c.occupied);

            // Bar Chart
            if (!barChart) {
                barChart = new Chart(document.getElementById('barChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Capacity',
                                data: capacity,
                                backgroundColor: '#667eea',
                                borderRadius: 8
                            },
                            {
                                label: 'Occupied',
                                data: occupied,
                                backgroundColor: '#ec4899',
                                borderRadius: 8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    font: { family: "'Inter', sans-serif", size: 12 }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9' }
                            },
                            x: {
                                grid: { display: false }
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

            // Pie/Donut Chart
            if (!pieChart) {
                pieChart = new Chart(document.getElementById('pieChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Vacant', 'Limited', 'Full'],
                        datasets: [{
                            data: [dashData.statusCount.Vacant, dashData.statusCount.Limited, dashData.statusCount.Full],
                            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            cutout: '72%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 18,
                                    usePointStyle: true,
                                    font: { family: "'Inter', sans-serif", size: 12 }
                                }
                            }
                        }
                    }
                });
            } else {
                pieChart.data.datasets[0].data = [dashData.statusCount.Vacant, dashData.statusCount.Limited, dashData.statusCount.Full];
                pieChart.update();
            }

            const mapRes = await fetch('/api/get-centers.php');
            allCenters = await mapRes.json();

            markers.forEach(m => map && map.removeLayer(m));
            markers = [];

            if (!map) {
                map = L.map('map').setView([7.028, 125.448], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
                addLeafletFullscreenControl(map);
                map.on('click', e => {
                    if (locationSelectionMode) selectLocationOnMap(e.latlng);
                });
                getUserLocation();
                renderBarangayPolygons();
                renderFloodZones();
            }

            const bounds = L.latLngBounds([]);
            allCenters.forEach(c => {
                const lat = parseFloat(c.latitude),
                    lng = parseFloat(c.longitude);
                if (isNaN(lat) || isNaN(lng)) return;
                const brgyTag = c.barangay ? `<span class="badge ${c.barangay.toLowerCase() === 'dalio' ? 'bg-info' : 'bg-primary'} mb-1">${c.barangay}</span>` : '';
                const marker = L.marker([lat, lng], { title: c.name, icon: getMarkerColor(c.status) }).addTo(map);
                marker.bindPopup(`
                        <div class="p-2" style="font-family: 'Inter', sans-serif;">
                            ${brgyTag}
                            <h6 class="fw-bold mb-1">${c.name}</h6>
                            <div class="small text-muted mb-2">
                                Occupants: <strong class="text-primary">${c.occupied}/${c.capacity}</strong>
                            </div>
                            <div>
                                <span class="badge ${c.status === 'Full' ? 'bg-danger' : (c.status === 'Limited' ? 'bg-warning text-dark' : 'bg-success')} rounded-pill px-2">${c.status}</span>
                            </div>
                        </div>`);
                marker.on('click', async () => {
                    if (!userLocation) return;
                    try {
                        const route = await mapServices.route(userLocation, { lat, lng });
                        if (routeLayer) map.removeLayer(routeLayer);
                        routeLayer = L.polyline(route.coordinates, { color: '#667eea', weight: 5, opacity: 0.8 }).addTo(map);
                        if (document.getElementById('directionsPanel')) {
                            document.getElementById('directionsPanel').innerHTML = `<div class="text-start w-100"><strong>${c.name}</strong><br>${route.distanceText} · ${route.durationText}</div>`;
                        }
                    } catch (error) {
                        console.warn('Directions unavailable:', error);
                    }
                });
                markers.push(marker);
                bounds.extend(marker.getLatLng());
            });

            renderCentersTableRows(allCenters);

            if (markers.length > 0 && !locationSelectionMode) map.fitBounds(bounds);
        } catch (err) {
            console.error("Dashboard load error:", err);
        }
    }

    let currentMasterFilter = 'all';

    function filterMasterBarangay(brgy, btn) {
        currentMasterFilter = brgy;
        if (btn) {
            document.querySelectorAll('#masterBarangayFilterGroup button').forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-primary');
            });
            btn.classList.add('btn-primary', 'active');
            btn.classList.remove('btn-outline-primary');
        }

        const filtered = (brgy === 'all') 
            ? allCenters 
            : allCenters.filter(c => (c.barangay || '').toLowerCase() === brgy.toLowerCase());

        renderCentersTableRows(filtered);

        // Update markers visibility
        if (markers && markers.length > 0) {
            const bounds = L.latLngBounds([]);
            let visibleCount = 0;
            markers.forEach((m, idx) => {
                const c = allCenters[idx];
                if (!c) return;
                const match = (brgy === 'all') || ((c.barangay || '').toLowerCase() === brgy.toLowerCase());
                if (match) m.addTo(map);
                else map.removeLayer(m);
                if (match) {
                    bounds.extend(m.getLatLng());
                    visibleCount++;
                }
            });
            if (visibleCount > 0 && map && !locationSelectionMode) {
                map.fitBounds(bounds);
            }
        }

        // Update stats cards based on filter
        let totCenters = filtered.length;
        let totCap = 0;
        let totOcc = 0;
        let vCount = 0, lCount = 0, fCount = 0;
        filtered.forEach(c => {
            totCap += parseInt(c.capacity) || 0;
            totOcc += parseInt(c.occupied) || 0;
            if (c.status === 'Full') fCount++;
            else if (c.status === 'Limited') lCount++;
            else vCount++;
        });

        document.getElementById('totalCenters').innerText = totCenters;
        document.getElementById('totalCapacity').innerText = totCap.toLocaleString();
        document.getElementById('totalOccupied').innerText = totOcc.toLocaleString();
        const util = totCap > 0 ? Math.round((totOcc / totCap) * 100) : 0;
        document.getElementById('utilization').innerText = util + '%';

        // Update Pie Chart
        if (pieChart) {
            pieChart.data.datasets[0].data = [vCount, lCount, fCount];
            pieChart.update();
        }

        // Update Bar Chart
        if (barChart) {
            barChart.data.labels = filtered.map(c => c.name.length > 15 ? c.name.substring(0, 15) + '...' : c.name);
            barChart.data.datasets[0].data = filtered.map(c => c.capacity);
            barChart.data.datasets[1].data = filtered.map(c => c.occupied);
            barChart.update();
        }
    }

    function renderCentersTableRows(centers) {
        const tbody = document.getElementById('centersList');
        tbody.innerHTML = '';
        const isMaster = document.getElementById('masterBarangayFilterGroup') !== null;
        if (centers.length === 0) {
            const colSpan = isMaster ? 8 : 7;
            tbody.innerHTML = `<tr><td colspan="${colSpan}" class="text-center py-4 text-muted">No evacuation centers found.</td></tr>`;
            return;
        }

        centers.forEach(c => {
            const utilization = c.capacity > 0 ? Math.round((c.occupied / c.capacity) * 100) : 0;
            const statusClass = c.status === 'Full' ? 'bg-soft-danger text-danger' : (c.status === 'Limited' ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success');
            const brgyCol = isMaster ? `
                <td>
                    <span class="badge rounded-pill fw-bold" style="${(c.barangay || '').toLowerCase() === 'dalio' ? 'background:#f3e8ff; color:#7e22ce; border:1px solid #d8b4fe;' : 'background:#dbeafe; color:#1e40af; border:1px solid #bfdbfe;'}">
                        ${c.barangay || 'Lizada'}
                    </span>
                </td>` : '';

            tbody.innerHTML += `
                <tr>
                    <td>
                        <div class="fw-bold text-dark">${c.name}</div>
                        <div class="text-muted small">Evacuation Shelter</div>
                    </td>
                    ${brgyCol}
                    <td>
                        <div class="font-monospace small text-muted">${parseFloat(c.latitude).toFixed(4)}, ${parseFloat(c.longitude).toFixed(4)}</div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">${c.occupied} <span class="text-muted font-normal">/ ${c.capacity}</span></div>
                    </td>
                    <td style="width: 180px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height: 6px; border-radius: 9999px;">
                                <div class="progress-bar ${utilization > 85 ? 'bg-danger' : (utilization > 50 ? 'bg-warning' : 'bg-primary')}" style="width: ${utilization}%; border-radius: 9999px;"></div>
                            </div>
                            <span class="small fw-bold">${utilization}%</span>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge ${statusClass}">
                            <i class="fas fa-circle" style="font-size: 6px;"></i> ${c.status}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm rounded-pill px-3 text-white border-0 shadow-sm" 
                                style="font-size: 0.775rem; background: var(--admin-gradient);"
                                onclick="addEvacuees(${c.id})">
                            <i class="fas fa-user-plus me-1"></i> Add
                        </button>
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle border" data-bs-toggle="dropdown" aria-label="Actions">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2">
                                <li>
                                    <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="javascript:void(0)" onclick="editCenter(${c.id})">
                                        <i class="fas fa-edit text-primary"></i> <span>Edit Center</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-danger d-flex align-items-center gap-2" href="javascript:void(0)" onclick="deleteCenter(${c.id})">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>`;
        });
    }

    function filterCentersTable() {
        const query = document.getElementById('centerSearchInput').value.toLowerCase().trim();
        let list = allCenters;
        if (currentMasterFilter !== 'all') {
            list = list.filter(c => (c.barangay || '').toLowerCase() === currentMasterFilter.toLowerCase());
        }
        const filtered = list.filter(c => 
            c.name.toLowerCase().includes(query) || 
            c.status.toLowerCase().includes(query) ||
            (c.barangay && c.barangay.toLowerCase().includes(query))
        );
        renderCentersTableRows(filtered);
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
                return { lat: parseFloat(pair[0]), lng: parseFloat(pair[1]) };
            });
        }

        barangayPolygonsRaw.forEach(bp => {
            const paths = parseWKT(bp.polygon);
            if (!paths) return;

            const polygon = L.polygon(paths, { color: '#667eea', opacity: 0.6, weight: 1.5, fillColor: '#667eea', fillOpacity: 0.1 }).addTo(map);
            polygon.on('mouseover', function() { this.setStyle({ fillOpacity: 0.22, weight: 2.5 }); });
            polygon.on('mouseout', function() { this.setStyle({ fillOpacity: 0.1, weight: 1.5 }); });
            polygon.bindPopup(`<div style="padding: 8px 12px; font-weight: 700; font-family: 'Inter', sans-serif;">Barangay ${bp.name} Boundary</div>`);

            barangayPolygons.push(polygon);
        });
    }

    function renderFloodZones() {
        const floodZones = <?= json_encode($floodZones) ?>;

        const getRiskColor = (level) => {
            if (level === "high") return "#ef4444";
            if (level === "moderate") return "#f59e0b";
            if (level === "low") return "#10b981";
            return "#667eea";
        };

        floodZones.forEach(zone => {
            const polygon = L.polygon(zone.polygon, { fillColor: getRiskColor(zone.risk_level), fillOpacity: 0.28, color: getRiskColor(zone.risk_level), weight: 1.5 }).addTo(map);
            polygon.bindPopup(`<div style="padding: 10px; font-family: 'Inter', sans-serif;">
                    <div style="font-weight: 800; color: ${getRiskColor(zone.risk_level)}">${zone.zone_name}</div>
                    <div class="small text-muted mt-1">Flood Risk Level: <strong>${zone.risk_level.toUpperCase()}</strong></div>
                </div>`);
        });
    }

    loadDashboard();
    setInterval(loadDashboard, 15000);

    function toggleMapLocationSelection() {
        locationSelectionMode = !locationSelectionMode;
        const btn = document.getElementById('mapSelectBtn');
        const banner = document.getElementById('locationModeBanner');
        if (locationSelectionMode) {
            btn.innerHTML = '<i class="fas fa-times me-2"></i>Cancel Map Picking';
            btn.classList.add('btn-danger', 'text-white');
            btn.classList.remove('btn-light', 'text-primary');
            banner.style.display = 'block';
            document.getElementById('map').style.cursor = 'crosshair';
        } else {
            btn.innerHTML = '<i class="fas fa-map-location-dot me-2"></i>Pick Coordinates from Map';
            btn.classList.remove('btn-danger', 'text-white');
            btn.classList.add('btn-light', 'text-primary');
            banner.style.display = 'none';
            document.getElementById('map').style.cursor = 'default';
            if (locationSelectMarker) {
                map.removeLayer(locationSelectMarker);
                locationSelectMarker = null;
            }
        }
    }

    function selectLocationOnMap(latLng) {
        const lat = latLng.lat,
            lng = latLng.lng;
        document.getElementById('centerLat').value = lat.toFixed(6);
        document.getElementById('centerLng').value = lng.toFixed(6);
        if (locationSelectMarker) map.removeLayer(locationSelectMarker);
    const selectionIcon = L.divIcon({ className: 'selected-location-marker', html: '<span style="display:block;width:22px;height:22px;border:3px solid #fff;border-radius:50%;background:#eab308;box-shadow:0 1px 6px #444"></span>', iconSize: [22, 22], iconAnchor: [11, 11] });
    locationSelectMarker = L.marker([lat, lng], { title: 'Selected Point', icon: selectionIcon }).addTo(map);
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
            map.removeLayer(locationSelectMarker);
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
        if (document.getElementById('centerBarangay') && center.barangay) {
            document.getElementById('centerBarangay').value = center.barangay;
        }
        document.getElementById('editPanel').classList.add('active');
        document.getElementById('editPanelOverlay').style.display = 'block';
    }

    function showToast(title, desc) {
        const existing = document.querySelector('.custom-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'custom-toast';
        toast.innerHTML = `
            <div class="toast-icon text-success" style="font-size: 1.35rem;">
                <i class="fas fa-circle-check"></i>
            </div>
            <div class="toast-content">
                <h6 class="fw-bold mb-0 text-dark">${title}</h6>
                <small class="text-muted">${desc}</small>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    document.getElementById('editForm').addEventListener('submit', async e => {
        e.preventDefault();
        const id = document.getElementById('centerId').value;
        const brgyInput = document.getElementById('centerBarangay');
        const data = {
            name: document.getElementById('centerName').value,
            latitude: parseFloat(document.getElementById('centerLat').value),
            longitude: parseFloat(document.getElementById('centerLng').value),
            capacity: parseInt(document.getElementById('centerCapacity').value),
            occupied: parseInt(document.getElementById('centerOccupied').value),
            barangay: brgyInput ? brgyInput.value : undefined
        };
        try {
            const res = await fetch(id ? '/api/update-center.php' : '/api/add-center.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ...data, id })
            });
            const result = await res.json();
            if (result.success) {
                loadDashboard();
                closePanel();
                showToast(id ? 'Center Updated' : 'Center Created', `"${data.name}" has been saved successfully.`);
            } else {
                alert('Save failed: ' + result.message);
            }
        } catch (err) {
            console.error(err);
            alert('Error saving center.');
        }
    });

    async function addEvacuees(id) {
        try {
            const res = await fetch('/api/add-evacuee.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            const result = await res.json();
            if (result.success) {
                loadDashboard();
                showToast('Evacuee Recorded', 'Occupancy count incremented.');
            } else {
                alert('Action failed: ' + result.message);
            }
        } catch (err) {
            console.error(err);
            alert('Error adding evacuee.');
        }
    }

    async function deleteCenter(id) {
        if (!confirm('Are you sure you want to delete this evacuation center?')) return;
        try {
            const res = await fetch('/api/delete-center.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            const result = await res.json();
            if (result.success) {
                loadDashboard();
                showToast('Center Deleted', 'The evacuation center was removed.');
            } else {
                alert('Delete failed: ' + result.message);
            }
        } catch (err) {
            console.error(err);
            alert('Error deleting center.');
        }
    }
</script>
