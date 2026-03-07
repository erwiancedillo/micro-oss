<?php
// Modern Mobile Sidebar (Offcanvas)
$current_route = $_GET['route'] ?? 'dashboard';
?>
<div class="offcanvas offcanvas-start mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold text-primary" id="mobileSidebarLabel">
            <i class="fas fa-bars-staggered me-2"></i>Micro OSS
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="sidebar-user-info p-3 mb-2 bg-light">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex align-items-center">
                    <?php
                    $profile_src = (isset($_SESSION['profile_picture']) && !empty($_SESSION['profile_picture']))
                        ? 'assets/uploads/' . $_SESSION['profile_picture']
                        : 'assets/uploads/hazard_maps/default-profile.jpg';
                    ?>
                    <img src="<?php echo htmlspecialchars($profile_src); ?>" alt="Profile" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <div>
                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($_SESSION['role'] ?? 'Member'); ?></small>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex align-items-center text-muted">
                    <i class="fas fa-user-circle fa-3x me-3"></i>
                    <div>
                        <div class="fw-bold">Guest Mode</div>
                        <small>Login to access more features</small>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="list-group list-group-flush sidebar-nav-list">
            <a href="/micro-oss/index.php?route=dashboard" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-house me-3 text-primary"></i>Home
            </a>
            <a href="/micro-oss/index.php?route=community-map" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'community-map' ? 'active' : '' ?>">
                <i class="fas fa-map-location-dot me-3 text-success"></i>Community Map
            </a>

            <div class="sidebar-divider p-2 px-3 bg-light text-muted small fw-bold">EARLY WARNING SYSTEM</div>
            <a href="/micro-oss/index.php?route=alerts" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'alerts' ? 'active' : '' ?>">
                <i class="fas fa-triangle-exclamation me-3 text-warning"></i>Alert Signal
            </a>
            <a href="/micro-oss/index.php?route=hazard" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'hazard' ? 'active' : '' ?>">
                <i class="fas fa-map-area me-3 text-danger"></i>Hazard Map
            </a>
            <a href="/micro-oss/index.php?route=flood-monitoring" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'flood-monitoring' ? 'active' : '' ?>">
                <i class="fas fa-water me-3 text-info"></i>Flood Monitoring
            </a>
            <a href="/micro-oss/index.php?route=evacuation" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'evacuation' ? 'active' : '' ?>">
                <i class="fas fa-route me-3 text-primary"></i>Evacuation Map
            </a>

            <div class="sidebar-divider p-2 px-3 bg-light text-muted small fw-bold">REPORTS</div>
            <a href="/micro-oss/index.php?route=socio" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'socio' ? 'active' : '' ?>">
                <i class="fas fa-users me-3 text-indigo"></i>Socio-Demographics
            </a>
            <a href="/micro-oss/index.php?route=vulnerability" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'vulnerability' ? 'active' : '' ?>">
                <i class="fas fa-shield-halved me-3 text-danger"></i> Hazard Vulnerability
            </a>
            <a href="/micro-oss/index.php?route=purok-demographics" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'purok-demographics' ? 'active' : '' ?>">
                <i class="fas fa-building-user me-3 text-success"></i>Purok Demographics
            </a>
            <a href="/micro-oss/index.php?route=purok-evacuation" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'purok-evacuation' ? 'active' : '' ?>">
                <i class="fas fa-users me-3 text-indigo"></i>Evacuation Population Analysis
            </a>
            <a href="/micro-oss/index.php?route=household-materials" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'household-materials' ? 'active' : '' ?>">
                <i class="fas fa-house me-3 text-info"></i>Household Materials Analysis
            </a>

            <div class="sidebar-divider p-2 px-3 bg-light text-muted small fw-bold">RESOURCES</div>
            <a href="/micro-oss/index.php?route=gallery" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'gallery' ? 'active' : '' ?>">
                <i class="fas fa-images me-3 text-pink"></i>Gallery
            </a>
            <a href="/micro-oss/index.php?route=iks" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'iks' ? 'active' : '' ?>">
                <i class="fas fa-brain me-3 text-primary"></i>IKS
            </a>
            <a href="/micro-oss/index.php?route=publications" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'publications' ? 'active' : '' ?>">
                <i class="fas fa-book me-3 text-secondary"></i>Publications
            </a>
            <a href="/micro-oss/index.php?route=download" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'download' ? 'active' : '' ?>">
                <i class="fas fa-file-arrow-down me-3 text-success"></i>Downloadables
            </a>

            <div class="sidebar-divider p-2 px-3 bg-light text-muted small fw-bold">ACCOUNT</div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/micro-oss/index.php?route=admin-dashboard" class="list-group-item list-group-item-action py-3 border-0 <?= $current_route === 'admin-dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-user-shield me-3 text-danger"></i>Admin Panel
                    </a>
                <?php endif; ?>
                <a href="#" class="list-group-item list-group-item-action py-3 border-0 text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-right-from-bracket me-3"></i>Log Out
                </a>
            <?php else: ?>
                <a href="#" class="list-group-item list-group-item-action py-3 border-0" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fas fa-sign-in-alt me-3 text-primary"></i>Login
                </a>
                <a href="#" class="list-group-item list-group-item-action py-3 border-0" data-bs-toggle="modal" data-bs-target="#signUpModal">
                    <i class="fas fa-user-plus me-3 text-success"></i>Sign Up
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .mobile-sidebar {
        width: 280px !important;
        border-radius: 0 20px 20px 0 !important;
        overflow-y: auto !important;
    }

    .sidebar-nav-list .list-group-item {
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .sidebar-nav-list .list-group-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }

    .sidebar-nav-list .list-group-item i {
        width: 20px;
        text-align: center;
    }

    .text-indigo {
        color: #6366f1;
    }

    .text-pink {
        color: #ec4899;
    }
</style>