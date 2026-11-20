<aside id="adminSidebar" class="admin-sidebar d-none d-lg-flex bg-white">
    <div class="sidebar-header d-flex align-items-center justify-content-between p-4 border-bottom border-light">
        <div class="d-flex align-items-center gap-2 sidebar-title-wrap">
            <div class="sidebar-brand-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <h6 class="sidebar-title text-uppercase fw-bold small mb-0" style="letter-spacing: 1px; color: #1e293b;">Admin Console</h6>
        </div>
        <button id="sidebarToggle" class="btn btn-sm btn-light rounded-circle shadow-sm border" title="Toggle Sidebar">
            <i class="fas fa-chevron-left toggle-icon"></i>
        </button>
    </div>

    <div class="px-3 py-3">
        <nav class="d-flex flex-column gap-1">
            <a href="index.php?route=admin-dashboard" class="admin-sidebar-link <?= ($route === 'admin-dashboard') ? 'active' : '' ?>" title="Dashboard">
                <i class="fas fa-chart-pie"></i><span class="link-text">Dashboard</span>
            </a>
            <a href="index.php?route=admin-alerts" class="admin-sidebar-link <?= ($route === 'admin-alerts') ? 'active' : '' ?>" title="Manage Alerts">
                <i class="fas fa-bell"></i><span class="link-text">Manage Alerts</span>
            </a>
            <a href="index.php?route=admin-hazard-maps" class="admin-sidebar-link <?= (strpos($route, 'admin-hazard-map') !== false) ? 'active' : '' ?>" title="Hazard Maps">
                <i class="fas fa-map-marked-alt"></i><span class="link-text">Hazard Maps</span>
            </a>
            <a href="index.php?route=admin-flood-zones" class="admin-sidebar-link <?= (strpos($route, 'admin-flood-zones') !== false) ? 'active' : '' ?>" title="Flood Zones">
                <i class="fas fa-water"></i><span class="link-text">Flood Zones</span>
            </a>
            <a href="index.php?route=admin-iks" class="admin-sidebar-link <?= (strpos($route, 'admin-iks') !== false) ? 'active' : '' ?>" title="Indigenous Knowledge">
                <i class="fas fa-feather-alt"></i><span class="link-text">Indigenous Knowledge</span>
            </a>
            <a href="index.php?route=admin-users" class="admin-sidebar-link <?= (strpos($route, 'admin-user') !== false) ? 'active' : '' ?>" title="User Management">
                <i class="fas fa-users"></i><span class="link-text">User Management</span>
            </a>
            <a href="index.php?route=admin-citizen-science" class="admin-sidebar-link <?= ($route === 'admin-citizen-science') ? 'active' : '' ?>" title="Citizen Science List">
                <i class="fas fa-camera-retro"></i><span class="link-text">Citizen Science</span>
            </a>
            <a href="index.php?route=resource-assessment" class="admin-sidebar-link <?= ($route === 'resource-assessment') ? 'active' : '' ?>" title="Resource Management">
                <i class="fas fa-boxes-stacked"></i><span class="link-text">Resources</span>
            </a>
            <hr class="my-2 opacity-25">
            <a href="index.php?route=dashboard" class="admin-sidebar-link" title="User Dashboard">
                <i class="fas fa-arrow-left"></i><span class="link-text">Back to Public View</span>
            </a>
        </nav>
    </div>
</aside>

<style>
    :root {
        --admin-sidebar-width: 270px;
        --admin-sidebar-collapsed-width: 78px;
        --admin-transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        --brand-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .admin-sidebar {
        width: var(--admin-sidebar-width);
        min-height: calc(100vh - 70px);
        transition: var(--admin-transition);
        position: sticky;
        top: 70px;
        z-index: 1040;
        height: calc(100vh - 70px);
        flex-direction: column;
        overflow-x: hidden;
        border-right: 1px solid rgba(139, 92, 246, 0.12) !important;
        background: #ffffff;
    }

    .admin-sidebar.collapsed {
        width: var(--admin-sidebar-collapsed-width);
    }

    .sidebar-brand-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(102, 126, 234, 0.12);
        color: #667eea;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .sidebar-title {
        transition: var(--admin-transition);
        white-space: nowrap;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .admin-sidebar.collapsed .sidebar-title-wrap {
        display: none !important;
    }

    .admin-sidebar.collapsed .sidebar-header {
        justify-content: center !important;
        padding: 1.25rem 0.5rem !important;
    }

    .admin-sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #64748b;
        text-decoration: none;
        border-radius: 12px;
        transition: var(--admin-transition);
        font-weight: 500;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .admin-sidebar-link:hover {
        background: rgba(102, 126, 234, 0.08);
        color: #667eea;
        transform: translateX(2px);
    }

    .admin-sidebar-link.active {
        background: var(--brand-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.35);
        font-weight: 600;
    }

    .admin-sidebar-link i {
        min-width: 1.5rem;
        margin-right: 0.75rem;
        font-size: 1.05rem;
        transition: var(--admin-transition);
    }

    .admin-sidebar.collapsed .admin-sidebar-link {
        padding: 0.75rem 0;
        justify-content: center;
    }

    .admin-sidebar.collapsed .admin-sidebar-link i {
        margin-right: 0;
    }

    .admin-sidebar.collapsed .link-text {
        display: none;
    }

    #sidebarToggle {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--admin-transition);
        color: #64748b;
    }

    #sidebarToggle:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .admin-sidebar.collapsed #sidebarToggle .toggle-icon {
        transform: rotate(180deg);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        if (sidebar && toggleBtn) {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                window.dispatchEvent(new Event('resize'));
            });
        }
    });
</script>
