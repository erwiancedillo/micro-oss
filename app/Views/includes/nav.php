<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$current_route = $_GET['route'] ?? 'dashboard';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm d-none d-lg-block" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none; z-index: 1045 !important;">
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
                        <li><a class="dropdown-item <?= $current_route === 'purok-evacuation' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=purok-evacuation"><i class="fas fa-route me-2 text-info"></i>Purok Evacuation Population</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-h me-1"></i> More
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="moreDropdown">
                        <li><a class="dropdown-item <?= $current_route === 'flood-monitoring' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=flood-monitoring"><i class="fas fa-water me-2 text-primary"></i>Flood Monitoring</a></li>
                        <li><a class="dropdown-item" href="/micro-oss/index.php?route=evacuation"><i class="fas fa-running me-2 text-primary"></i>Evacuation</a></li>
                        <li><a class="dropdown-item <?= $current_route === 'iks' ? 'active shadow-sm' : '' ?>" href="/micro-oss/index.php?route=iks"><i class="fas fa-feather-alt me-2 text-success"></i>Indigenous Knowledge</a></li>
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
                    <a class="nav-link text-warning" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" title="Log Out">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered logout-modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden glass-modal-content">
            <div class="modal-body text-center p-4 p-md-5">
                <div class="logout-icon-container bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-4">
                    <i class="fas fa-right-from-bracket fa-2x"></i>
                </div>
                <h4 class="fw-bold mb-2 text-dark">Confirm Log Out</h4>
                <p class="text-muted mb-4 px-2">Are you sure you want to log out of your account?</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light py-2 px-4 rounded-pill fw-semibold border w-100" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <a href="/micro-oss/index.php?route=logout" class="btn btn-danger py-2 px-4 rounded-pill fw-semibold w-100 btn-logout-confirm shadow-sm d-flex align-items-center justify-content-center">
                        Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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

    /* Responsive dialog width & centering for Logout Modal */
    .logout-modal-dialog {
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Glassmorphism styling for Logout Modal */
    .glass-modal-content {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }

    .logout-icon-container {
        width: 60px;
        height: 60px;
        background-color: rgba(239, 68, 68, 0.1);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        animation: scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .btn-logout-confirm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        border: none !important;
        transition: all 0.2s ease-in-out;
        color: white !important;
    }

    .btn-logout-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px -4px rgba(239, 68, 68, 0.4) !important;
        filter: brightness(1.05);
    }

    /* Mobile specific modal shrinkage */
    @media (max-width: 575.98px) {
        .logout-modal-dialog {
            max-width: 300px !important;
            width: 85% !important;
            margin: 1.75rem auto !important;
        }
        .glass-modal-content .modal-body {
            padding: 1.75rem 1.25rem !important;
        }
        .logout-icon-container {
            width: 48px !important;
            height: 48px !important;
            margin-bottom: 1rem !important;
        }
        .logout-icon-container i {
            font-size: 1.25rem !important;
        }
        .glass-modal-content h4 {
            font-size: 1.15rem !important;
            margin-bottom: 0.25rem !important;
        }
        .glass-modal-content p {
            font-size: 0.85rem !important;
            margin-bottom: 1.25rem !important;
            padding: 0 !important;
        }
        .glass-modal-content .btn {
            font-size: 0.85rem !important;
            padding: 0.45rem 1rem !important;
        }
    }

    @keyframes scaleIn {
        0% { transform: scale(0.6); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>