<!-- User Dashboard View - Micro OSS Modern Purple/Indigo Theme -->
<style>
    :root {
        --brand-primary: #667eea;
        --brand-secondary: #764ba2;
        --brand-purple-vibrant: #8b5cf6;
        --brand-purple-light: #c084fc;
        --brand-lavender: #eef2ff;
        --brand-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --brand-gradient-hover: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        --dashboard-bg: #f8fafc;
        --card-radius: 20px;
        --card-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.8);
        --card-hover-shadow: 0 20px 40px -8px rgba(102, 126, 234, 0.18), 0 0 0 1px rgba(139, 92, 246, 0.35);
    }

    body {
        background-color: var(--dashboard-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .dashboard-container {
        padding: 1.5rem 0 3.5rem;
    }

    /* Hero Welcome Banner (Matching Login Midnight Theme) */
    .dashboard-hero-banner {
        background: 
            radial-gradient(circle at 12% 18%, rgba(102, 126, 234, 0.32), transparent 45%),
            radial-gradient(circle at 88% 82%, rgba(118, 75, 162, 0.28), transparent 45%),
            linear-gradient(135deg, #090c16 0%, #111531 50%, #191c42 100%);
        border-radius: 24px;
        padding: 2.25rem 2.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        box-shadow: 0 16px 40px -10px rgba(15, 20, 43, 0.45);
        border: 1px solid rgba(139, 92, 246, 0.25);
    }

    /* Ambient Wave Watermark */
    .dashboard-hero-banner::after {
        content: "";
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(192, 132, 252, 0.25), transparent 70%);
        pointer-events: none;
    }

    .hero-badge-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(102, 126, 234, 0.2);
        border: 1px solid rgba(139, 92, 246, 0.35);
        color: #c084fc;
        padding: 5px 14px;
        border-radius: 9999px;
        font-size: 0.775rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }

    .pulse-dot-green {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseGreen 1.8s infinite;
    }

    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .hero-title-text {
        font-size: clamp(1.75rem, 3vw, 2.35rem);
        font-weight: 800;
        letter-spacing: -0.8px;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .hero-title-text .highlight-purple {
        background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-subtext {
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.95rem;
        max-width: 620px;
        margin-bottom: 0;
        line-height: 1.5;
    }

    .user-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Modern Feature Cards Grid */
    .feature-card {
        background: #ffffff;
        border-radius: var(--card-radius);
        padding: 1.6rem 1.25rem 1.4rem;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--card-shadow);
        text-decoration: none !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Soft corner radial glow */
    .feature-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle at 100% 0%, rgba(102, 126, 234, 0.1), transparent 70%);
        pointer-events: none;
        border-top-right-radius: var(--card-radius);
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-hover-shadow);
        border-color: rgba(139, 92, 246, 0.35);
    }

    .card-icon-container {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .feature-card:hover .card-icon-container {
        transform: scale(1.08);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.18);
    }

    .card-icon-container img {
        width: 44px;
        height: 44px;
        object-fit: contain;
    }

    .card-icon-container i {
        font-size: 1.85rem;
    }

    /* Palette-coordinated icon backgrounds */
    .bg-icon-purple { background: #eef2ff; color: #667eea; border: 1px solid rgba(102, 126, 234, 0.15); }
    .bg-icon-amber  { background: #fffbeb; color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.15); }
    .bg-icon-rose   { background: #fef2f2; color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.15); }
    .bg-icon-emerald{ background: #ecfdf5; color: #10b981; border: 1px solid rgba(16, 185, 129, 0.15); }
    .bg-icon-cyan   { background: #f0fdfa; color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.15); }
    .bg-icon-violet { background: #faf5ff; color: #8b5cf6; border: 1px solid rgba(139, 92, 246, 0.15); }
    .bg-icon-pink   { background: #fdf2f8; color: #ec4899; border: 1px solid rgba(236, 72, 153, 0.15); }
    .bg-icon-slate  { background: #f8fafc; color: #475569; border: 1px solid rgba(71, 85, 105, 0.15); }
    .bg-icon-master { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; box-shadow: 0 6px 18px rgba(118, 75, 162, 0.35); }

    .card-title-text {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
        line-height: 1.25;
        letter-spacing: -0.2px;
    }

    .card-subtitle-tag {
        font-size: 0.725rem;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Admin Console Card Special Highlighting */
    .feature-card.admin-special-card {
        background: linear-gradient(180deg, #ffffff 0%, #fbfbfe 100%);
        border: 1.5px solid rgba(102, 126, 234, 0.35);
        box-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.15);
    }

    .feature-card.admin-special-card:hover {
        border-color: #667eea;
        box-shadow: 0 20px 45px -8px rgba(118, 75, 162, 0.3);
    }

    /* Section Header */
    .section-headline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--brand-primary);
    }

    /* Community Partner Footer Strip */
    .community-partner-strip {
        background: #ffffff;
        border-radius: var(--card-radius);
        padding: 1.4rem 2rem;
        border: 1px solid rgba(226, 232, 240, 0.85);
        box-shadow: var(--card-shadow);
        margin-top: 3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .partner-logo-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        padding: 6px 16px 6px 6px;
        transition: all 0.2s ease;
    }

    .partner-logo-pill:hover {
        background: #eef2ff;
        border-color: rgba(102, 126, 234, 0.3);
        transform: translateY(-2px);
    }

    .partner-logo-pill img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
    }

    .partner-logo-name {
        font-size: 0.825rem;
        font-weight: 700;
        color: #1e293b;
    }
</style>

<main class="container dashboard-container">

    <!-- Welcome Toast Alert (If Redirected after login) -->
    <?php if (isset($_SESSION['show_welcome_card']) && $_SESSION['show_welcome_card']): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center p-4 bg-white mb-4" style="border-left: 5px solid #10b981 !important;">
            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div>
                <h5 class="alert-heading fw-bold mb-1 text-dark">Signed in successfully</h5>
                <p class="mb-0 text-muted small">Welcome back! You are now securely authenticated into the Micro OSS Disaster Information System.</p>
            </div>
            <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['show_welcome_card']); ?>
    <?php endif; ?>

    <!-- Hero Welcome Banner -->
    <div class="dashboard-hero-banner d-flex justify-content-between align-items-center flex-wrap gap-4">
        <div>
            <div class="hero-badge-tag">
                <span class="pulse-dot-green"></span>
                <span>Disaster Response & Resource Portal</span>
            </div>
            <h1 class="hero-title-text">
                Welcome Back, <span class="highlight-purple"><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>!
            </h1>
            <p class="hero-subtext">
                Live disaster monitoring, GIS hazard maps, early warning signals, and community resource allocation.
            </p>
        </div>

        <div class="d-flex flex-column align-items-sm-end gap-2">
            <div class="user-role-badge">
                <i class="fas fa-shield-halved text-warning"></i>
                <span>
                    <?php 
                        $role = $_SESSION['role'] ?? 'user';
                        $brgy = $_SESSION['admin_barangay'] ?? '';
                        if ($role === 'master') echo 'Master Administrator';
                        elseif ($role === 'admin') echo 'Barangay Admin (' . ucfirst($brgy) . ')';
                        else echo 'Community Member (' . ($brgy ? ucfirst($brgy) : 'Verified') . ')';
                    ?>
                </span>
            </div>
            <small class="text-white-50">
                <i class="far fa-calendar-check me-1"></i> <?= date('F j, Y') ?>
            </small>
        </div>
    </div>

    <!-- Section Title -->
    <div class="section-headline">
        <div class="section-title">
            <i class="fas fa-grid-2"></i>
            <span>System Modules & Capabilities</span>
        </div>
        <small class="text-muted">Select a module to view live data</small>
    </div>

    <!-- Main Modules Grid -->
    <div class="row g-4 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 row-cols-xl-6 justify-content-center mb-4">

        <!-- 1. Community Map -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=community-map" class="feature-card">
                <div class="card-icon-container bg-icon-purple">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/map.png" alt="Community Map">
                </div>
                <h3 class="card-title-text">Community Map</h3>
                <span class="card-subtitle-tag">Interactive GIS</span>
            </a>
        </div>

        <!-- 2. Alert Signals -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=alerts" class="feature-card">
                <div class="card-icon-container bg-icon-amber">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/alert.png" alt="Alert Signals">
                </div>
                <h3 class="card-title-text">Alert Signals</h3>
                <span class="card-subtitle-tag">Early Warnings</span>
            </a>
        </div>

        <!-- 3. Hazard Map -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=hazard" class="feature-card">
                <div class="card-icon-container bg-icon-rose">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/hazardmap.png" alt="Hazard Map">
                </div>
                <h3 class="card-title-text">Hazard Map</h3>
                <span class="card-subtitle-tag">Vulnerability</span>
            </a>
        </div>

        <!-- 4. Flood Monitoring -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=flood-monitoring" class="feature-card">
                <div class="card-icon-container bg-icon-purple">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/ews.png" alt="Flood Monitoring">
                </div>
                <h3 class="card-title-text">Flood Monitoring</h3>
                <span class="card-subtitle-tag">Water Sensors</span>
            </a>
        </div>

        <!-- 5. Evacuation Map -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=evacuation" class="feature-card">
                <div class="card-icon-container bg-icon-emerald">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/evacuation-map.png" alt="Evacuation Map">
                </div>
                <h3 class="card-title-text">Evacuation Map</h3>
                <span class="card-subtitle-tag">Shelters & Routes</span>
            </a>
        </div>

        <!-- 6. Plastic Waste -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=plastic-waste" class="feature-card">
                <div class="card-icon-container bg-icon-cyan">
                    <i class="fas fa-recycle"></i>
                </div>
                <h3 class="card-title-text">Plastic Waste</h3>
                <span class="card-subtitle-tag">Eco Recycling</span>
            </a>
        </div>

        <!-- 7. Indigenous Knowledge System -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=iks" class="feature-card">
                <div class="card-icon-container bg-icon-amber">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/iks.png" alt="IKS System">
                </div>
                <h3 class="card-title-text">IKS System</h3>
                <span class="card-subtitle-tag">Local Wisdom</span>
            </a>
        </div>

        <!-- 8. Publications -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=publications" class="feature-card">
                <div class="card-icon-container bg-icon-slate">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/policy.png" alt="Publications">
                </div>
                <h3 class="card-title-text">Publications</h3>
                <span class="card-subtitle-tag">Policies & Plans</span>
            </a>
        </div>

        <!-- 9. Socio-Demographic Data -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=socio" class="feature-card">
                <div class="card-icon-container bg-icon-violet">
                    <img src="<?= APP_BASE_PATH ?>/assets/icons/socio-data.png" alt="Socio-Demographic Data">
                </div>
                <h3 class="card-title-text">Demographics</h3>
                <span class="card-subtitle-tag">Purok Census</span>
            </a>
        </div>

        <!-- 10. Citizen Science -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=gallery" class="feature-card">
                <div class="card-icon-container bg-icon-pink">
                    <i class="fas fa-camera-retro"></i>
                </div>
                <h3 class="card-title-text">Citizen Science</h3>
                <span class="card-subtitle-tag">Field Reports</span>
            </a>
        </div>

        <!-- 11. User Profile -->
        <div class="col">
            <a href="<?= APP_BASE_PATH ?>/index.php?route=user-profile" class="feature-card">
                <div class="card-icon-container bg-icon-purple">
                    <i class="fas fa-circle-user"></i>
                </div>
                <h3 class="card-title-text">My Profile</h3>
                <span class="card-subtitle-tag">Security & Info</span>
            </a>
        </div>

        <!-- 12. Admin Console (If Admin/Master) -->
        <?php if (in_array($_SESSION['role'] ?? '', ['admin', 'master'])): ?>
            <div class="col">
                <a href="<?= APP_BASE_PATH ?>/index.php?route=admin-dashboard" class="feature-card admin-special-card">
                    <div class="card-icon-container bg-icon-master">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="card-title-text" style="color: #667eea;">Admin Console</h3>
                    <span class="card-subtitle-tag" style="color: #8b5cf6;">System Controls</span>
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- Community Partner Barangays Strip (Matches Login Page) -->
    <div class="community-partner-strip">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-handshake text-primary fs-5"></i>
            <div>
                <strong class="text-dark small d-block">Partner Communities</strong>
                <span class="text-muted" style="font-size: 0.775rem;">Connected for disaster-resilient governance</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="partner-logo-pill">
                <img src="<?= APP_BASE_PATH ?>/assets/uploads/Lizadalogo.jpg" alt="Barangay Lizada">
                <span class="partner-logo-name">Barangay Lizada</span>
            </div>
            <div class="partner-logo-pill">
                <img src="<?= APP_BASE_PATH ?>/assets/uploads/barangaydalio.jpg" alt="Barangay Dalio">
                <span class="partner-logo-name">Barangay Dalio</span>
            </div>
        </div>
    </div>

</main>
