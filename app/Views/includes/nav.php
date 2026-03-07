<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$current_route = $_GET['route'] ?? 'dashboard';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm d-none d-lg-block" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/micro-oss/index.php?route=dashboard">
            <i class="fas fa-shield-alt me-2"></i>
            <span>Micro OSS</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?= $current_route === 'dashboard' ? 'active fw-bold' : '' ?>" href="/micro-oss/index.php?route=dashboard">
                        <i class="fas fa-th-large me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_route === 'community-map' ? 'active fw-bold' : '' ?>" href="/micro-oss/index.php?route=community-map">
                        <i class="fas fa-map me-1"></i> Community Map
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_route === 'alerts' ? 'active fw-bold' : '' ?>" href="/micro-oss/index.php?route=alerts">
                        <i class="fas fa-bell me-1"></i> Alerts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_route === 'hazard' ? 'active fw-bold' : '' ?>" href="/micro-oss/index.php?route=hazard">
                        <i class="fas fa-exclamation-triangle me-1"></i> Hazard Map
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($current_route, ['vulnerability', 'purok-demographics', 'household-materials', 'purok-evacuation', 'socio']) ? 'active fw-bold' : '' ?>" href="#" id="analyticsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-pie me-1"></i> Reports
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="analyticsDropdown">
                        <li><a class="dropdown-item <?= $current_route === 'socio' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=socio"><i class="fas fa-users me-2 text-dark"></i>Socio-Demographic</a></li>
                        <li><a class="dropdown-item <?= $current_route === 'vulnerability' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=vulnerability"><i class="fas fa-shield-alt me-2 text-danger"></i>Hazard Vulnerability</a></li>
                        <li><a class="dropdown-item <?= $current_route === 'purok-demographics' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=purok-demographics"><i class="fas fa-map-marked-alt me-2 text-success"></i>Purok Demographics</a></li>
                        <li><a class="dropdown-item <?= $current_route === 'household-materials' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=household-materials"><i class="fas fa-home me-2 text-warning"></i>Household Materials Analysis</a></li>
                        <li><a class="dropdown-item <?= $current_route === 'purok-evacuation' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=purok-evacuation"><i class="fas fa-route me-2 text-info"></i>Purok Evacuation</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h me-1"></i> More
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="moreDropdown">
                        <li><a class="dropdown-item <?= $current_route === 'flood-monitoring' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=flood-monitoring"><i class="fas fa-water me-2 text-primary"></i>Flood Monitoring</a></li>
                        <li><a class="dropdown-item" href="/micro-oss/index.php?route=evacuation"><i class="fas fa-running me-2 text-primary"></i>Evacuation</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/micro-oss/index.php?route=publications"><i class="fas fa-file-alt me-2 text-primary"></i>Publications</a></li>
                    </ul>
                </li>

                <?php if ($is_admin): ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light btn-sm rounded-pill px-3" href="/micro-oss/index.php?route=admin-dashboard">
                            <i class="fas fa-user-shield me-1"></i> Admin
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item ms-lg-2">
                    <a class="nav-link text-warning" href="/micro-oss/index.php?route=logout" onclick="return confirm('Are you sure you want to logout?')">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: #fff !important;
        transform: translateY(-1px);
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            margin: 1rem -1rem -0.5rem -1rem;
            padding: 1rem;
            border-radius: 0 0 1rem 1rem;
        }
    }
</style>