<?php
$isMaster = ($_SESSION['role'] ?? '') === 'master';

// Separate pending (inactive) users from active ones
$pendingUsers = array_filter($users, fn($u) => ($u['status'] ?? '') === 'inactive');
$activeUsers  = array_filter($users, fn($u) => ($u['status'] ?? '') !== 'inactive');
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <h2 class="h3 mb-0">User Management</h2>
                    <?php if ($isMaster): ?>
                        <span class="badge text-bg-warning fs-6 px-3 py-1" style="border-radius:999px;">
                            <i class="fas fa-crown me-1"></i> Master Account
                        </span>
                    <?php endif; ?>
                </div>
                <a href="index.php?route=admin-create-user" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </a>
            </div>

            <!-- Flash Message -->
            <?php if (!empty($_SESSION['flash_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($_SESSION['flash_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <!-- User Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-primary fw-bold fs-2"><?= $userStats['total'] ?></div>
                            <div class="text-muted small">Total Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-success fw-bold fs-2"><?= $userStats['active'] ?></div>
                            <div class="text-muted small">Active</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-warning fw-bold fs-2"><?= $userStats['inactive'] ?></div>
                            <div class="text-muted small">Pending</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-danger fw-bold fs-2"><?= $userStats['admin'] ?></div>
                            <div class="text-muted small">Admins</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-info fw-bold fs-2"><?= $userStats['user'] ?></div>
                            <div class="text-muted small">Regular Users</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== PENDING APPROVALS SECTION (Master only) ===== -->
            <?php if ($isMaster && !empty($pendingUsers)): ?>
            <div class="card border-0 shadow mb-4" style="border-left: 4px solid #f59e0b !important;">
                <div class="card-header bg-warning-subtle d-flex align-items-center gap-2 py-3">
                    <i class="fas fa-user-clock text-warning fs-5"></i>
                    <h5 class="mb-0 fw-bold text-warning-emphasis">
                        Pending Approvals
                        <span class="badge bg-warning text-dark ms-2"><?= count($pendingUsers) ?></span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-warning">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Barangay</th>
                                    <th>Role</th>
                                    <th>Registered</th>
                                    <th width="160">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingUsers as $user): ?>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-sm bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center">
                                                    <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-medium"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                                    <small class="text-muted">ID: #<?= $user['id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?= htmlspecialchars($user['barangay'] ?? 'N/A') ?></span>
                                        </td>
                                        <td><span class="badge bg-danger"><?= ucfirst($user['role'] ?? 'admin') ?></span></td>
                                        <td><small><?= date('M d, Y', strtotime($user['created_at'])) ?></small></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="index.php?route=admin-approve-user&id=<?= $user['id'] ?>"
                                                   class="btn btn-sm btn-success"
                                                   onclick="return confirm('Approve <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> and activate their account?')"
                                                   title="Approve &amp; Activate">
                                                    <i class="fas fa-check me-1"></i>Approve
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete"
                                                        onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ===== ALL ACTIVE USERS TABLE ===== -->
            <div class="card border-0 shadow">
                <div class="card-header bg-white d-flex align-items-center gap-2 py-3 border-bottom">
                    <i class="fas fa-users text-primary fs-5"></i>
                    <h5 class="mb-0 fw-bold">Active Users</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Barangay</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($activeUsers)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <div class="text-muted">No active users found</div>
                                            <a href="index.php?route=admin-create-user" class="btn btn-primary mt-2">
                                                Add First User
                                            </a>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($activeUsers as $user): ?>
                                        <tr class="align-middle">
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                                        <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                                        <small class="text-muted">ID: #<?= $user['id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <?php if (!empty($user['barangay'])): ?>
                                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                        <?= htmlspecialchars($user['barangay']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (($user['role'] ?? '') === 'master'): ?>
                                                    <span class="badge bg-warning text-dark"><i class="fas fa-crown me-1"></i>Master</span>
                                                <?php elseif ($user['role'] === 'admin'): ?>
                                                    <span class="badge bg-danger">Admin</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">User</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($user['status'] === 'active'): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small><?= date('M d, Y', strtotime($user['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="index.php?route=admin-edit-user&id=<?= $user['id'] ?>"
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($user['id'] != ($_SESSION['user_id'] ?? 0) && ($user['role'] ?? '') !== 'master'): ?>
                                                        <button type="button"
                                                                class="btn btn-outline-danger"
                                                                title="Delete"
                                                                onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Delete User</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteConfirmBtn').href = 'index.php?route=admin-delete-user&id=' + userId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#usersTable').DataTable({
            pageLength: 25,
            order: [[0, 'asc']],
            responsive: true,
            language: {
                search: 'Search users:',
                lengthMenu: 'Show _MENU_ users per page'
            }
        });
    }
});
</script>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    min-width: 40px;
    font-size: 14px;
    font-weight: bold;
}
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}
.badge { font-weight: 500; }
</style>
