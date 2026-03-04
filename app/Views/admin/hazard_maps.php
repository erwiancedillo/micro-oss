<!-- Admin Hazard Maps View -->
<style>
    .admin-layout { display: flex; min-height: calc(100vh - 70px); background: #f8fafc; }
    .admin-main { flex: 1; padding: 2rem; overflow-x: hidden; }

    .map-card {
        background: white;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        height: 100%;
    }
    .map-card:hover { transform: translateY(-5px); }
    
    .map-thumb {
        height: 180px;
        width: 100%;
        object-fit: cover;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.7rem;
        text-transform: uppercase;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(4px);
        color: #667eea;
    }
</style>

<div class="admin-layout d-flex">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="admin-main p-4">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1">Hazard Library</h2>
                <p class="text-muted">Manage flood susceptibility maps and risk assessments</p>
            </div>
            <a href="index.php?route=admin-hazard-map-create" class="btn btn-primary rounded-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                <i class="fas fa-plus me-2"></i>Add New Map
            </a>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div><?= $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?></div>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($maps)): ?>
                <div class="col-12 text-center py-5">
                    <div class="opacity-20 mb-3"><i class="fas fa-map-marked-alt fa-5x"></i></div>
                    <h5 class="text-muted">No hazard maps found in the library.</h5>
                </div>
            <?php else: ?>
                <?php foreach ($maps as $map): ?>
                    <div class="col-xl-4 col-md-6">
                        <div class="map-card position-relative">
                            <span class="status-badge shadow-sm"><i class="fas fa-layer-group me-1"></i> Static Map</span>
                            <img src="<?= htmlspecialchars($map['image_url']) ?>" alt="<?= htmlspecialchars($map['name']) ?>" class="map-thumb">
                            <div class="p-4">
                                <h5 class="fw-bold text-dark mb-2"><?= htmlspecialchars($map['name']) ?></h5>
                                <p class="small text-muted mb-4 text-truncate-2" style="height: 3rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    <?= htmlspecialchars($map['description']) ?>
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="index.php?route=admin-hazard-map-edit&id=<?= $map['id'] ?>" class="btn btn-soft-primary flex-grow-1 fw-bold rounded-2 py-2">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <a href="index.php?route=admin-hazard-map-delete&id=<?= $map['id'] ?>" class="btn btn-soft-danger fw-bold rounded-2 px-3 py-2" onclick="return confirm('Delete this hazard map permanently?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>
