<aside id="adminSidebar" class="admin-sidebar d-none d-lg-flex bg-white border-end">
    <div class="sidebar-header d-flex align-items-center justify-content-between p-4">
        <h6 class="sidebar-title text-uppercase text-muted fw-bold small opacity-75 mb-0" style="letter-spacing: 1px;">Admin Console</h6>
        <button id="sidebarToggle" class="btn btn-sm btn-light rounded-circle shadow-sm border" title="Toggle Sidebar">
            <i class="fas fa-chevron-left toggle-icon"></i>
        </button>
    </div>

    <div class="px-3 pb-4">
        <nav>
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
            <hr class="my-3 opacity-50">
            <a href="index.php?route=dashboard" class="admin-sidebar-link" title="User Dashboard">
                <i class="fas fa-home"></i><span class="link-text">User Dashboard</span>
            </a>
        </nav>
    </div>
</aside>

<style>
    :root {
        --admin-sidebar-width: 280px;
        --admin-sidebar-collapsed-width: 80px;
        --admin-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-sidebar {
        width: var(--admin-sidebar-width);
        min-height: calc(100vh - 70px);
        transition: var(--admin-transition);
        position: sticky;
        top: 0;
        z-index: 1040;
        height: 100vh;
        flex-direction: column;
        overflow-x: hidden;
    }

    .admin-sidebar.collapsed {
        width: var(--admin-sidebar-collapsed-width);
    }

    .sidebar-title {
        transition: var(--admin-transition);
        white-space: nowrap;
    }

    .admin-sidebar.collapsed .sidebar-title {
        opacity: 0;
        visibility: hidden;
        width: 0;
    }

    .admin-sidebar.collapsed .sidebar-header {
        justify-content: center !important;
        padding: 1.5rem 0.5rem !important;
    }

    .admin-sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.875rem 1.25rem;
        color: #64748b;
        text-decoration: none;
        border-radius: 0.75rem;
        margin-bottom: 0.25rem;
        transition: var(--admin-transition);
        font-weight: 500;
        white-space: nowrap;
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
        min-width: 1.5rem;
        margin-right: 0.75rem;
        font-size: 1.2rem;
        transition: var(--admin-transition);
    }

    .admin-sidebar.collapsed .admin-sidebar-link {
        padding: 0.875rem 0;
        justify-content: center;
    }

    .admin-sidebar.collapsed .admin-sidebar-link i {
        margin-right: 0;
    }

    .admin-sidebar.collapsed .link-text {
        display: none;
    }

    #sidebarToggle {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: var(--admin-transition);
    }

    .admin-sidebar.collapsed #sidebarToggle {
        transform: rotate(180deg);
    }

    /* Adjust main content area if needed - usually done in the parent layout */
    .admin-main {
        transition: var(--admin-transition);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        if (isCollapsed) {
            sidebar.classList.add('collapsed');
        }

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));

            // Trigger resize event to update charts if any
            window.dispatchEvent(new Event('resize'));
        });
    });
</script>