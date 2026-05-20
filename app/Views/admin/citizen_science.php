<!-- Admin Citizen Science List View -->
<div class="admin-layout d-flex">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="admin-main flex-grow-1 p-4" style="background-color: var(--admin-bg);">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1"><i class="fas fa-camera-retro me-2 text-primary"></i>Manage Citizen Science</h2>
                <p class="text-muted mb-0">Review and oversee crowdsourced photo reports</p>
            </div>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['flash_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">All Uploaded Photos</h5>
                <span class="badge bg-primary text-white rounded-pill px-3"><?= count($reports) ?> Total</span>
            </div>
            <div class="table-responsive px-4 pb-4">
                <table class="table table-hover align-middle mb-0" id="citizenTable">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($reports)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">No citizen science reports found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($reports as $cr): ?>
                            <tr>
                                <td>
                                    <a href="/micro-oss/assets/uploads/citizen_science/<?= htmlspecialchars($cr['image']) ?>" target="_blank">
                                        <img src="/micro-oss/assets/uploads/citizen_science/<?= htmlspecialchars($cr['image']) ?>" alt="thumbnail" class="rounded object-fit-cover shadow-sm" style="width: 60px; height: 60px;">
                                    </a>
                                </td>
                                <td>
                                    <?php if ($cr['status'] === 'verified'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2 py-1"><i class="fas fa-check-circle me-1"></i>Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark border border-warning rounded-pill px-2 py-1"><i class="fas fa-clock me-1"></i>Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-secondary rounded-pill px-2 py-1"><?= htmlspecialchars($cr['category']) ?></span></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($cr['description']) ?>">
                                        <?= htmlspecialchars($cr['description'] ?: 'No description') ?>
                                    </div>
                                    <div class="small text-muted mt-1">Sub: <?= htmlspecialchars($cr['first_name'] . ' ' . $cr['last_name'] ?? 'User') ?></div>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($cr['barangay']) ?></strong>
                                    <?php if (!empty($cr['sitio'])): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($cr['sitio']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?= date('M j, Y g:i A', strtotime($cr['created_at'])) ?></td>
                                <td class="text-end">
                                    <?php if ($cr['status'] !== 'verified'): ?>
                                    <a href="index.php?route=admin-citizen-verify&id=<?= $cr['id'] ?>" class="btn btn-sm btn-success me-1 shadow-sm" title="Verify">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="index.php?route=admin-citizen-delete&id=<?= $cr['id'] ?>" class="btn btn-sm btn-outline-danger shadow-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this report?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
