<aside class="admin-sidebar d-none d-lg-flex bg-white border-end" style="width: 280px; min-height: calc(100vh - 70px);">
    <div class="p-4">
        <h6 class="text-uppercase text-muted fw-bold small opacity-75 mb-4" style="letter-spacing: 1px;">Admin Console</h6>
        
        <nav>
            <a href="index.php?route=admin-dashboard" class="admin-sidebar-link <?= ($route === 'admin-dashboard') ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="index.php?route=admin-alerts" class="admin-sidebar-link <?= ($route === 'admin-alerts') ? 'active' : '' ?>">
                <i class="fas fa-bell"></i> Manage Alerts
            </a>
            <a href="index.php?route=admin-hazard-maps" class="admin-sidebar-link <?= (strpos($route, 'admin-hazard-map') !== false) ? 'active' : '' ?>">
                <i class="fas fa-map-marked-alt"></i> Hazard Maps
            </a>
            <a href="index.php?route=admin-flood-zones" class="admin-sidebar-link <?= (strpos($route, 'admin-flood-zones') !== false) ? 'active' : '' ?>">
                <i class="fas fa-water"></i> Flood Zones
            </a>
            <a href="index.php?route=admin-iks" class="admin-sidebar-link <?= (strpos($route, 'admin-iks') !== false) ? 'active' : '' ?>">
                <i class="fas fa-feather-alt"></i> Indigenous Knowledge
            </a>
            <hr class="my-4 opacity-50">
            <a href="index.php?route=dashboard" class="admin-sidebar-link">
                <i class="fas fa-home"></i> User Dashboard
            </a>
        </nav>
    </div>
</aside>

<style>
    .admin-sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.875rem 1.25rem;
        color: #64748b;
        text-decoration: none;
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .admin-sidebar-link:hover {
        background: #f1f5f9;
        color: #667eea;
    }

    .admin-sidebar-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(118, 75, 162, 0.25);
    }

    .admin-sidebar-link i {
        width: 1.5rem;
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }
</style>
