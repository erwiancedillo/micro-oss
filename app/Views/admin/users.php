<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">User Management</h2>
                <a href="index.php?route=admin-create-user" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </a>
            </div>

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
                            <div class="text-muted small">Inactive</div>
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

            <!-- Users Table -->
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <div class="text-muted">No users found</div>
                                            <a href="index.php?route=admin-create-user" class="btn btn-primary mt-2">
                                                Add First User
                                            </a>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
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
                                                <?php if ($user['role'] === 'admin'): ?>
                                                    <span class="badge bg-danger">Admin</span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">User</span>
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
                                                    <?php if ($user['id'] != ($_SESSION['user_id'] ?? 0)): ?>
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

// Initialize DataTable for better user experience
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

.badge {
    font-weight: 500;
}
</style>
