<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 4rem 0;
        margin-bottom: 3rem;
        box-shadow: inset 0 -10px 20px rgba(0,0,0,0.05);
    }
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 1.5rem;
        height: 100%;
        background: #fff;
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }
    .icon-wrapper {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        margin-bottom: 1rem;
        transition: background-color 0.3s ease;
    }
    .dashboard-card img {
        width: 56px;
        height: 56px;
        object-fit: contain;
    }
    .card-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0;
        line-height: 1.2;
    }
    
    /* Icon background colors */
    .bg-community { background-color: #eff6ff; }
    .bg-alerts { background-color: #fefce8; }
    .bg-hazard { background-color: #fef2f2; }
    .bg-flood { background-color: #eef2ff; }
    .bg-evacuation { background-color: #f0fdf4; }
    .bg-socio { background-color: #faf5ff; }
    .bg-media { background-color: #fdf2f8; }
    .bg-iks { background-color: #fff7ed; }
    .bg-policy { background-color: #f8fafc; }
    .bg-download { background-color: #f0fdfa; }
    .bg-profile { background-color: #eef2ff; }

    .dashboard-card:hover .bg-community { background-color: #dbeafe; }
    .dashboard-card:hover .bg-alerts { background-color: #fef9c3; }
    .dashboard-card:hover .bg-hazard { background-color: #fee2e2; }
    .dashboard-card:hover .bg-flood { background-color: #e0e7ff; }
    .dashboard-card:hover .bg-evacuation { background-color: #dcfce7; }
    .dashboard-card:hover .bg-download { background-color: #ccfbf1; }
    .dashboard-card:hover .bg-profile { background-color: #e0e7ff; }
</style>
<main class="container mb-5">
    <?php if (isset($_SESSION['show_welcome_card']) && $_SESSION['show_welcome_card']): ?>
        <div class="row mb-4 animate__animated animate__fadeInDown">
            <div class="col-12">
                <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center p-4 bg-white" style="border-left: 5px solid #10b981 !important;">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-4 text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="alert-heading fw-bold mb-1 text-dark" style="font-size: 1.1rem;">Log in successfully</h4>
                        <p class="mb-0 text-muted">Welcome back! You are now securely logged into your account.</p>
                    </div>
                    <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['show_welcome_card']); ?>
    <?php endif; ?>

    <div class="row g-4 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5">
        <!-- Community Map -->
        <div class="col">
            <a href="/micro-oss/index.php?route=community-map" class="dashboard-card">
                <div class="icon-wrapper bg-community">
                    <img src="/micro-oss/assets/icons/map.png" alt="Community Map">
                </div>
                <h3 class="card-title">Community Map</h3>
            </a>
        </div>
        <!-- Alert Signals -->
        <div class="col">
            <a href="/micro-oss/index.php?route=alerts" class="dashboard-card">
                <div class="icon-wrapper bg-alerts">
                    <img src="/micro-oss/assets/icons/alert.png" alt="Alert Signals">
                </div>
                <h3 class="card-title">Alert Signals</h3>
            </a>
        </div>
        <!-- Hazard Map -->
        <div class="col">
            <a href="/micro-oss/index.php?route=hazard" class="dashboard-card">
                <div class="icon-wrapper bg-hazard">
                    <img src="/micro-oss/assets/icons/hazardmap.png" alt="Hazard Map">
                </div>
                <h3 class="card-title">Hazard Map</h3>
            </a>
        </div>
        <!-- Flood Monitoring -->
        <div class="col">
            <a href="/micro-oss/index.php?route=flood-monitoring" class="dashboard-card">
                <div class="icon-wrapper bg-flood">
                    <img src="/micro-oss/assets/icons/ews.png" alt="Flood Monitoring">
                </div>
                <h3 class="card-title">Flood Monitoring</h3>
            </a>
        </div>
        <!-- Evacuation Map -->
        <div class="col">
            <a href="/micro-oss/index.php?route=evacuation" class="dashboard-card">
                <div class="icon-wrapper bg-evacuation">
                    <img src="/micro-oss/assets/icons/evacuation-map.png" alt="Evacuation Map">
                </div>
                <h3 class="card-title">Evacuation Map</h3>
            </a>
        </div>

        <!-- Socio-Demographic Data -->
        <div class="col">
            <a href="/micro-oss/index.php?route=socio" class="dashboard-card">
                <div class="icon-wrapper bg-socio">
                    <img src="/micro-oss/assets/icons/socio-data.png" alt="Socio-Demographic Data">
                </div>
                <h3 class="card-title">Socio-Demographic</h3>
            </a>
        </div>
        <!-- Media Gallery -->
        <div class="col">
            <a href="/micro-oss/index.php?route=gallery" class="dashboard-card">
                <div class="icon-wrapper bg-media">
                    <img src="/micro-oss/assets/icons/media-gallery.png" alt="Media Gallery">
                </div>
                <h3 class="card-title">Media Gallery</h3>
            </a>
        </div>
        <!-- Indigenous Knowledge System -->
        <div class="col">
            <a href="/micro-oss/index.php?route=iks" class="dashboard-card">
                <div class="icon-wrapper bg-iks">
                    <img src="/micro-oss/assets/icons/iks.png" alt="Indigenous Knowledge System">
                </div>
                <h3 class="card-title">IKS System</h3>
            </a>
        </div>
        <!-- Policies & Publications -->
        <div class="col">
            <a href="/micro-oss/index.php?route=publications" class="dashboard-card">
                <div class="icon-wrapper bg-policy">
                    <img src="/micro-oss/assets/icons/policy.png" alt="Policies & Publications">
                </div>
                <h3 class="card-title">Publications</h3>
            </a>
        </div>
        <!-- User Profile -->
        <div class="col">
            <a href="/micro-oss/index.php?route=user-profile" class="dashboard-card">
                <div class="icon-wrapper bg-profile">
                    <i class="fas fa-user-circle text-primary fa-2x"></i>
                </div>
                <h3 class="card-title">My Profile</h3>
            </a>
        </div>
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
        <!-- Admin Console -->
        <div class="col">
            <a href="/micro-oss/index.php?route=admin-dashboard" class="dashboard-card border-primary-subtle" style="background-color: #f8fafc;">
                <div class="icon-wrapper bg-white shadow-sm border border-danger-subtle">
                    <i class="fas fa-user-shield text-danger fa-2x"></i>
                </div>
                <h3 class="card-title text-danger">Admin Console</h3>
            </a>
        </div>
        <?php endif; ?>
    </div>
</main>