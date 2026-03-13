<!-- Admin IKS View -->
<style>
    .admin-layout {
        display: flex;
        min-height: calc(100vh - 70px);
        background: #f8fafc;
    }

    .admin-main {
        flex: 1;
        padding: 2rem;
        overflow-x: hidden;
        transition: var(--admin-transition);
    }

    .iks-card {
        background: white;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .category-badge {
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    .cat-prediction {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .cat-weather {
        background: rgba(234, 179, 8, 0.1);
        color: #eab308;
    }

    .cat-prevention {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .table th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        border: none;
    }

    .panel-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 1060;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .panel-content {
        background: white;
        width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>

<div class="admin-layout d-flex">
    <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

    <main class="admin-main p-">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="fw-bold mb-1">Indigenous Knowledge Management</h6>
                <p class="text-muted">Manage traditional wisdom entries for the IKS System</p>
            </div>
            <button class="btn btn-primary rounded-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;" onclick="openAdd()">
                <i class="fas fa-plus me-2"></i>New Knowledge Item
            </button>
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div><?= $_SESSION['flash_message'];
                        unset($_SESSION['flash_message']); ?></div>
            </div>
        <?php endif; ?>

        <div class="iks-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Title & Category</th>
                            <th>Icon</th>
                            <th>Description Snippet</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No entries found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($item['title']) ?></div>
                                        <span class="category-badge cat-<?= htmlspecialchars($item['category']) ?> small"><?= htmlspecialchars($item['category']) ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['icon_url'])): ?>
                                            <img src="<?= htmlspecialchars($item['icon_url']) ?>" alt="icon"
                                                 style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;"
                                                 onerror="this.src=''; this.alt='Missing';">
                                        <?php else: ?>
                                            <span class="text-muted small">No icon</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-truncate small text-muted" style="max-width: 400px;"><?= htmlspecialchars($item['description']) ?></div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-light btn-sm rounded-circle me-1" onclick='openEdit(<?= json_encode($item) ?>)'><i class="fas fa-edit text-primary"></i></button>
                                        <a href="index.php?route=admin-iks-delete&id=<?= $item['id'] ?>" class="btn btn-light btn-sm rounded-circle text-danger" onclick="return confirm('Delete this knowledge item?')"><i class="fas fa-trash"></i></a>
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

<!-- Edit Overlay -->
<div id="itemOverlay" class="panel-overlay">
    <div class="panel-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0" id="panelTitle">Knowledge Item</h3>
            <button class="btn btn-light rounded-circle" onclick="closePanel()"><i class="fas fa-times"></i></button>
        </div>

        <form id="itemForm" action="index.php?route=admin-iks-create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="itemId">
            <input type="hidden" name="existing_icon" id="itemExistingIcon">

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Category</label>
                <select name="category" id="itemCategory" class="form-select bg-light border-0 py-2 rounded-3" required>
                    <option value="prediction">Prediction (Animal Behavior)</option>
                    <option value="weather">Weather Patterns</option>
                    <option value="prevention">Prevention Practices</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Title</label>
                <input type="text" name="title" id="itemTitle" class="form-control bg-light border-0 py-2 rounded-3" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Description</label>
                <textarea name="description" id="itemDescription" class="form-control bg-light border-0 py-2 rounded-3" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Context & Significance (Optional)</label>
                <textarea name="significance" id="itemSignificance" class="form-control bg-light border-0 py-2 rounded-3" rows="2"></textarea>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Icon Image</label>
                    <input type="file" name="icon_image" id="itemIconFile" class="form-control bg-light border-0 py-2 rounded-3" accept="image/*">
                    <div id="currentIconPreview" class="mt-1 small text-muted"></div>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Order Index</label>
                    <input type="number" name="order_index" id="itemOrder" class="form-control bg-light border-0 py-2 rounded-3" value="0">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted">"Read More" Source Link (Optional)</label>
                <input type="url" name="source_url" id="itemSourceUrl" class="form-control bg-light border-0 py-2 rounded-3" placeholder="https://...">
                <div class="form-text">A link that users can follow to learn more about this topic.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold py-3 rounded-3 mt-2 shadow-sm border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                Save Knowledge Item
            </button>
        </form>
    </div>
</div>

<script>
    function openAdd() {
        document.getElementById('panelTitle').innerText = 'New Knowledge Item';
        document.getElementById('itemForm').action = 'index.php?route=admin-iks-create';
        document.getElementById('itemId').value = '';
        document.getElementById('itemExistingIcon').value = '';
        document.getElementById('currentIconPreview').innerText = '';
        document.getElementById('itemForm').reset();
        document.getElementById('itemOverlay').style.display = 'flex';
    }

    function openEdit(item) {
        document.getElementById('panelTitle').innerText = 'Modify Knowledge Item';
        document.getElementById('itemForm').action = 'index.php?route=admin-iks-edit';
        document.getElementById('itemId').value = item.id;
        document.getElementById('itemCategory').value = item.category;
        document.getElementById('itemTitle').value = item.title;
        document.getElementById('itemDescription').value = item.description;
        document.getElementById('itemSignificance').value = item.significance || '';
        document.getElementById('itemExistingIcon').value = item.icon_url || '';
        document.getElementById('currentIconPreview').innerText = item.icon_url ? 'Current: ' + item.icon_url.split('/').pop() : 'No icon set';
        document.getElementById('itemOrder').value = item.order_index || 0;
        document.getElementById('itemSourceUrl').value = item.source_url || '';

        document.getElementById('itemOverlay').style.display = 'flex';
    }

    function closePanel() {
        document.getElementById('itemOverlay').style.display = 'none';
    }
</script>