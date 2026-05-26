<style>
    .glass-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .hero-resource { background: linear-gradient(135deg, #d97706 0%, #92400e 100%); border-radius: 15px; color: white; padding: 2.5rem; margin-bottom: 2rem; }
    .resource-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
</style>

<div class="container mb-5">
    <div class="hero-resource shadow">
        <h2 class="fw-bold"><i class="fas fa-boxes-stacked me-3"></i>Resource Assessment</h2>
        <p class="mb-0 text-white-50">Community inventory of disaster response units, vehicles, and vital resources.</p>
    </div>

    <div class="row g-4">
        <?php if (in_array($_SESSION['role'] ?? '', ['admin', 'master'])): ?>
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <h5 class="text-warning text-darken-3 fw-bold border-bottom pb-2 mb-3"><i class="fas fa-plus-circle me-2"></i>Add Resource Update</h5>
                <form id="resourceForm">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Barangay</label>
                        <select class="form-select bg-light border-0" name="barangay" required>
                            <option value="Lizada">Lizada</option>
                            <option value="Daliao">Daliao</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Resource Type</label>
                        <select class="form-select bg-light border-0" name="type" required>
                            <option value="Rescue Boat">Rescue Boat</option>
                            <option value="Ambulance">Ambulance</option>
                            <option value="Food Packs">Food Packs</option>
                            <option value="Evacuation Tents">Evacuation Tents</option>
                            <option value="Medical Team">Medical Team</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Quantity Available</label>
                        <input type="number" name="quantity" class="form-control bg-light border-0" required min="1">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-muted fw-bold">Current Status</label>
                        <select class="form-select bg-light border-0" name="status" required>
                            <option value="available">Available (On-Standby)</option>
                            <option value="deployed">Deployed / In-Use</option>
                        </select>
                    </div>
                    <button class="btn btn-warning w-100 rounded-pill shadow-sm fw-bold">Register Resource</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
        <?php else: ?>
        <div class="col-lg-12">
        <?php endif; ?>
            <div class="glass-card p-4 h-100">
                <h5 class="text-warning text-darken-3 fw-bold border-bottom pb-2 mb-3"><i class="fas fa-warehouse me-2"></i>Barangay Inventory</h5>
                
                <div class="row g-3">
                    <?php if (empty($resources)): ?>
                        <div class="col-12 py-5 text-center text-muted">No resources tracked yet.</div>
                    <?php endif; ?>
                    
                    <?php foreach($resources as $res): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border border-warning-subtle h-100 bg-light shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($res['type']) ?></h6>
                                    <span class="badge <?= $res['status'] == 'available' ? 'bg-success' : 'bg-danger' ?> rounded-pill small">
                                        <?= strtoupper($res['status']) ?>
                                    </span>
                                </div>
                                <h3 class="fw-bold text-warning mb-1 h2"><?= number_format($res['quantity']) ?></h3>
                                <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i> Barangay <?= htmlspecialchars($res['barangay']) ?></p>
                                <hr class="my-2">
                                <small class="text-muted" style="font-size: 0.7rem;">Updated: <?= date('M d, Y H:i', strtotime($res['last_updated'])) ?></small>
                                
                                <?php if (in_array($_SESSION['role'] ?? '', ['admin', 'master'])): ?>
                                <select class="form-select form-select-sm mt-3 status-updater" data-id="<?= $res['id'] ?>">
                                    <option value="available" <?= $res['status'] == 'available' ? 'selected' : '' ?>>Available (Standby)</option>
                                    <option value="deployed" <?= $res['status'] == 'deployed' ? 'selected' : '' ?>>Deployed (In Use)</option>
                                </select>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('resourceForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('/micro-oss/index.php?route=api-resource-add', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert(res.message); window.location.reload();
            } else {
                alert('Error: ' + res.message);
            }
        });
});

document.querySelectorAll('.status-updater').forEach(select => {
    select.addEventListener('change', function() {
        const formData = new FormData();
        formData.append('id', this.dataset.id);
        formData.append('status', this.value);
        fetch('/micro-oss/index.php?route=api-resource-update', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if (res.success) window.location.reload();
                else alert('Failed to update status.');
            });
    });
});
</script>
