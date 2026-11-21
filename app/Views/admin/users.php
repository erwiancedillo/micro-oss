<?php
$isMaster = ($_SESSION['role'] ?? '') === 'master';
$currentUserId = (int)($_SESSION['user_id'] ?? 0);
?>

<div class="container-fluid py-4 user-mgmt-page">

    <!-- Top Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="header-icon-badge">
                    <i class="fas fa-users-gear text-primary"></i>
                </div>
                <h1 class="h3 fw-bold mb-0 text-slate-900">User Management</h1>
                <?php if ($isMaster): ?>
                    <span class="badge badge-master-pov ms-2">
                        <i class="fas fa-crown text-warning me-1"></i> Master POV
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-muted small mb-0">Oversee community accounts, role authorizations, and barangay assignments.</p>
        </div>
        <a href="index.php?route=admin-create-user" class="btn btn-create-user shadow-sm">
            <i class="fas fa-user-plus me-2"></i>Add New User
        </a>
    </div>

    <!-- Flash Notification -->
    <?php if (!empty($_SESSION['flash_message'])): ?>
        <div class="alert alert-modern-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fs-5 me-2 text-success"></i>
                <span><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <!-- Modern Stats Cards (4 Columns) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-total shadow-sm">
                <div class="stat-icon-wrap bg-primary-subtle text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="stat-value text-slate-900"><?= (int)($userStats['total'] ?? count($users)) ?></div>
                    <div class="stat-label text-muted">Total Accounts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-active shadow-sm">
                <div class="stat-icon-wrap bg-success-subtle text-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <div class="stat-value text-success"><?= (int)($userStats['active'] ?? count($users)) ?></div>
                    <div class="stat-label text-muted">Active Users</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-admin shadow-sm">
                <div class="stat-icon-wrap bg-purple-subtle text-purple">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <div class="stat-value text-purple"><?= (int)($userStats['admin'] ?? 0) ?></div>
                    <div class="stat-label text-muted">Administrators</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-community shadow-sm">
                <div class="stat-icon-wrap bg-info-subtle text-info">
                    <i class="fas fa-people-roof"></i>
                </div>
                <div>
                    <div class="stat-value text-info"><?= (int)($userStats['user'] ?? 0) ?></div>
                    <div class="stat-label text-muted">Community Users</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar Card -->
    <div class="card border-0 shadow-sm toolbar-card mb-4">
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 align-items-center">
                <!-- Search Input -->
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon text-muted"></i>
                        <input type="text" id="userSearchInput" class="form-control modern-search-input" placeholder="Search by name, email, username...">
                        <button type="button" id="clearSearchBtn" class="clear-search-btn" title="Clear search" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Filter Chips -->
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="d-flex flex-wrap align-items-center justify-content-start justify-content-md-end gap-2">
                        <span class="text-muted small fw-semibold me-1 d-none d-sm-inline">Filter:</span>
                        
                        <div class="btn-group btn-group-sm" role="group" aria-label="Role Filter">
                            <button type="button" class="btn filter-chip active" data-filter-type="role" data-filter-value="all">All Roles</button>
                            <button type="button" class="btn filter-chip" data-filter-type="role" data-filter-value="admin">Admins</button>
                            <button type="button" class="btn filter-chip" data-filter-type="role" data-filter-value="user">Community</button>
                        </div>

                        <?php if ($isMaster): ?>
                            <div class="btn-group btn-group-sm ms-md-2" role="group" aria-label="Barangay Filter">
                                <button type="button" class="btn filter-chip active" data-filter-type="barangay" data-filter-value="all">All Barangays</button>
                                <button type="button" class="btn filter-chip" data-filter-type="barangay" data-filter-value="lizada">Lizada</button>
                                <button type="button" class="btn filter-chip" data-filter-type="barangay" data-filter-value="dalio">Dalio</button>
                            </div>
                        <?php endif; ?>

                        <div class="results-count-badge ms-md-2 small text-muted">
                            <span id="visibleUserCount"><?= count($users) ?></span> of <?= count($users) ?> accounts
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Users Table Card (Desktop / Tablet) -->
    <div class="card border-0 shadow-sm main-table-card d-none d-md-block mb-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table align-middle mb-0" id="usersDesktopTable">
                    <thead>
                        <tr>
                            <th class="ps-4">User</th>
                            <th>Contact Email</th>
                            <th>Barangay</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined Date</th>
                            <th class="text-end pe-4" width="130">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersDesktopTbody">
                        <?php if (empty($users)): ?>
                            <tr class="empty-state-row">
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state-wrap">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-users-slash text-muted"></i>
                                        </div>
                                        <h5 class="fw-bold text-slate-800 mt-3 mb-1">No accounts found</h5>
                                        <p class="text-muted small mb-3">No user records currently exist in the system.</p>
                                        <a href="index.php?route=admin-create-user" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i> Add Account
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): 
                                $uid = (int)($user['id'] ?? 0);
                                $fName = htmlspecialchars($user['first_name'] ?? '');
                                $lName = htmlspecialchars($user['last_name'] ?? '');
                                $fullName = trim($fName . ' ' . $lName);
                                if ($fullName === '') $fullName = 'Unnamed User';
                                $uName = htmlspecialchars($user['username'] ?? '');
                                $email = htmlspecialchars($user['email'] ?? '');
                                $barangay = htmlspecialchars($user['barangay'] ?? '');
                                $role = strtolower($user['role'] ?? 'user');
                                $status = strtolower($user['status'] ?? 'active');
                                $createdAt = !empty($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : '—';
                                
                                // Initials for avatar
                                $initials = strtoupper(substr($fName, 0, 1) . substr($lName, 0, 1));
                                if ($initials === '') $initials = strtoupper(substr($uName, 0, 2));
                                if ($initials === '') $initials = 'U';

                                // Color gradient classes based on ID modulo
                                $avatarGradients = ['avatar-grad-1', 'avatar-grad-2', 'avatar-grad-3', 'avatar-grad-4', 'avatar-grad-5'];
                                $avatarClass = $avatarGradients[$uid % count($avatarGradients)];

                                // Normalized attributes for JS filtering & pagination
                                $roleGroup = (in_array($role, ['admin', 'master']) || strpos($role, 'admin_') === 0) ? 'admin' : 'user';
                                $barangaySlug = strtolower($barangay);
                            ?>
                                <tr class="user-row align-middle"
                                    data-fullname="<?= strtolower($fullName) ?>"
                                    data-username="<?= strtolower($uName) ?>"
                                    data-email="<?= strtolower($email) ?>"
                                    data-barangay="<?= $barangaySlug ?>"
                                    data-role="<?= $roleGroup ?>">
                                    
                                    <!-- User Column (Avatar + Names) -->
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar <?= $avatarClass ?>">
                                                <?= $initials ?>
                                            </div>
                                            <div>
                                                <div class="user-name-text"><?= $fullName ?></div>
                                                <div class="user-handle-text">@<?= $uName ?: 'user' . $uid ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td>
                                        <div class="d-flex align-items-center text-slate-700">
                                            <i class="far fa-envelope text-muted me-2 small"></i>
                                            <span><?= $email ?></span>
                                        </div>
                                    </td>

                                    <!-- Barangay -->
                                    <td>
                                        <?php if ($barangaySlug === 'lizada'): ?>
                                            <span class="badge-tag badge-tag-lizada">
                                                <i class="fas fa-location-dot me-1"></i> Lizada
                                            </span>
                                        <?php elseif ($barangaySlug === 'dalio'): ?>
                                            <span class="badge-tag badge-tag-dalio">
                                                <i class="fas fa-location-dot me-1"></i> Dalio
                                            </span>
                                        <?php elseif ($role === 'master' || $barangaySlug === 'master'): ?>
                                            <span class="badge-tag badge-tag-master">
                                                <i class="fas fa-crown me-1"></i> System Wide
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Role -->
                                    <td>
                                        <?php if ($role === 'master'): ?>
                                            <span class="badge-role badge-role-master">
                                                <i class="fas fa-crown me-1"></i> Master
                                            </span>
                                        <?php elseif ($roleGroup === 'admin'): ?>
                                            <span class="badge-role badge-role-admin">
                                                <i class="fas fa-shield-halved me-1"></i> Admin
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-role badge-role-user">
                                                <i class="fas fa-user me-1"></i> Community
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <?php if ($status === 'active'): ?>
                                            <span class="status-indicator status-active">
                                                <span class="status-pulse-dot"></span> Active
                                            </span>
                                        <?php else: ?>
                                            <span class="status-indicator status-inactive">
                                                <span class="status-inactive-dot"></span> Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Date -->
                                    <td>
                                        <span class="text-muted small"><?= $createdAt ?></span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <a href="index.php?route=admin-edit-user&id=<?= $uid ?>"
                                               class="btn-row-action btn-row-edit"
                                               title="Edit User">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>
                                            <?php if ($uid !== $currentUserId && $role !== 'master'): ?>
                                                <button type="button"
                                                        class="btn-row-action btn-row-delete"
                                                        title="Delete User"
                                                        onclick="confirmDelete(<?= $uid ?>, '<?= addslashes($fullName) ?>')">
                                                    <i class="fas fa-trash-can"></i>
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

            <!-- Client Filter Empty State Placeholder -->
            <div id="noResultsDesktop" class="text-center py-5" style="display: none;">
                <div class="empty-state-wrap">
                    <i class="fas fa-filter-circle-xmark fa-2x text-muted mb-2"></i>
                    <h6 class="fw-bold text-slate-800">No matching accounts</h6>
                    <p class="text-muted small mb-2">No users matched your current search or filter query.</p>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetAllFilters()">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Card-List View (Screens < 768px) -->
    <div class="d-md-none mb-3" id="usersMobileContainer">
        <?php if (empty($users)): ?>
            <div class="card border-0 shadow-sm p-4 text-center">
                <i class="fas fa-users-slash text-muted fa-2x mb-2"></i>
                <h6 class="fw-bold text-slate-800">No accounts found</h6>
                <p class="text-muted small mb-3">No user records currently exist.</p>
                <a href="index.php?route=admin-create-user" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Account
                </a>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3" id="mobileUserCardsList">
                <?php foreach ($users as $user): 
                    $uid = (int)($user['id'] ?? 0);
                    $fName = htmlspecialchars($user['first_name'] ?? '');
                    $lName = htmlspecialchars($user['last_name'] ?? '');
                    $fullName = trim($fName . ' ' . $lName);
                    if ($fullName === '') $fullName = 'Unnamed User';
                    $uName = htmlspecialchars($user['username'] ?? '');
                    $email = htmlspecialchars($user['email'] ?? '');
                    $barangay = htmlspecialchars($user['barangay'] ?? '');
                    $role = strtolower($user['role'] ?? 'user');
                    $status = strtolower($user['status'] ?? 'active');
                    $createdAt = !empty($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : '—';
                    
                    $initials = strtoupper(substr($fName, 0, 1) . substr($lName, 0, 1));
                    if ($initials === '') $initials = strtoupper(substr($uName, 0, 2));
                    if ($initials === '') $initials = 'U';

                    $avatarGradients = ['avatar-grad-1', 'avatar-grad-2', 'avatar-grad-3', 'avatar-grad-4', 'avatar-grad-5'];
                    $avatarClass = $avatarGradients[$uid % count($avatarGradients)];

                    $roleGroup = (in_array($role, ['admin', 'master']) || strpos($role, 'admin_') === 0) ? 'admin' : 'user';
                    $barangaySlug = strtolower($barangay);
                ?>
                    <div class="card border-0 shadow-sm user-mobile-card"
                         data-fullname="<?= strtolower($fullName) ?>"
                         data-username="<?= strtolower($uName) ?>"
                         data-email="<?= strtolower($email) ?>"
                         data-barangay="<?= $barangaySlug ?>"
                         data-role="<?= $roleGroup ?>">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar <?= $avatarClass ?> user-avatar-mobile">
                                        <?= $initials ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-900 user-card-name"><?= $fullName ?></div>
                                        <div class="text-muted small">@<?= $uName ?: 'user' . $uid ?></div>
                                    </div>
                                </div>
                                <div>
                                    <?php if ($status === 'active'): ?>
                                        <span class="status-indicator status-active">
                                            <span class="status-pulse-dot"></span> Active
                                        </span>
                                    <?php else: ?>
                                        <span class="status-indicator status-inactive">
                                            <span class="status-inactive-dot"></span> Inactive
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-3 text-muted small">
                                <i class="far fa-envelope me-1"></i> <?= $email ?>
                            </div>

                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 border-top">
                                <div class="d-flex align-items-center gap-1">
                                    <?php if ($barangaySlug === 'lizada'): ?>
                                        <span class="badge-tag badge-tag-lizada">Lizada</span>
                                    <?php elseif ($barangaySlug === 'dalio'): ?>
                                        <span class="badge-tag badge-tag-dalio">Dalio</span>
                                    <?php elseif ($role === 'master' || $barangaySlug === 'master'): ?>
                                        <span class="badge-tag badge-tag-master">Master</span>
                                    <?php endif; ?>

                                    <?php if ($role === 'master'): ?>
                                        <span class="badge-role badge-role-master">Master</span>
                                    <?php elseif ($roleGroup === 'admin'): ?>
                                        <span class="badge-role badge-role-admin">Admin</span>
                                    <?php else: ?>
                                        <span class="badge-role badge-role-user">Community</span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <a href="index.php?route=admin-edit-user&id=<?= $uid ?>"
                                       class="btn btn-sm btn-outline-primary px-3 rounded-pill"
                                       title="Edit User">
                                        <i class="fas fa-pen-to-square me-1"></i> Edit
                                    </a>
                                    <?php if ($uid !== $currentUserId && $role !== 'master'): ?>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger px-2 rounded-circle"
                                                title="Delete User"
                                                onclick="confirmDelete(<?= $uid ?>, '<?= addslashes($fullName) ?>')">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Mobile No Results Placeholder -->
            <div id="noResultsMobile" class="card border-0 shadow-sm p-4 text-center mt-3" style="display: none;">
                <i class="fas fa-filter-circle-xmark fa-2x text-muted mb-2"></i>
                <h6 class="fw-bold text-slate-800">No matching accounts</h6>
                <p class="text-muted small mb-2">Try adjusting your search terms or filters.</p>
                <button type="button" class="btn btn-sm btn-outline-secondary mx-auto" onclick="resetAllFilters()">
                    Reset Filters
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Unified Minimal Pagination Bar (Desktop & Mobile) -->
    <div class="card border-0 shadow-sm p-3 mb-4 pagination-card" id="userPaginationBar">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <div class="text-muted small text-center text-sm-start">
                Showing <span class="fw-bold text-slate-900" id="pageRangeStart">1</span> to <span class="fw-bold text-slate-900" id="pageRangeEnd">10</span> of <span class="fw-bold text-slate-900" id="totalRecordCount"><?= count($users) ?></span> accounts
            </div>
            
            <!-- Minimal Pagination Controls: Previous, Current Page Highlighted, Next -->
            <nav aria-label="User page navigation">
                <ul class="pagination modern-pagination mb-0">
                    <li class="page-item disabled" id="prevPageLi">
                        <button type="button" class="page-link pagination-nav-btn" id="prevPageBtn" aria-label="Previous">
                            <i class="fas fa-chevron-left me-1"></i> Previous
                        </button>
                    </li>
                    <li class="page-item active" id="currentPageLi">
                        <span class="page-link pagination-curr-pill" id="pageIndicatorText">Page 1 of 1</span>
                    </li>
                    <li class="page-item disabled" id="nextPageLi">
                        <button type="button" class="page-link pagination-nav-btn" id="nextPageBtn" aria-label="Next">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg modal-modern-delete">
            <div class="modal-body text-center p-4">
                <div class="modal-delete-icon-wrap text-danger bg-danger-subtle mx-auto mb-3">
                    <i class="fas fa-triangle-exclamation fa-2x"></i>
                </div>
                <h5 class="fw-bold text-slate-900 mb-1" id="deleteModalLabel">Delete Account</h5>
                <p class="text-muted small mb-3">Are you sure you want to permanently delete <strong id="deleteUserName" class="text-slate-900"></strong>?</p>
                <div class="alert alert-warning py-2 px-3 small text-start border-0 bg-warning-subtle text-warning-emphasis">
                    <i class="fas fa-circle-exclamation me-1"></i> This action cannot be undone and revokes all login privileges.
                </div>
            </div>
            <div class="modal-footer border-0 p-3 bg-light-subtle d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger px-4">
                    <i class="fas fa-trash-can me-1"></i> Yes, Delete
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern User Management Styles */
:root {
    --brand-indigo: #6366f1;
    --brand-purple: #8b5cf6;
    --slate-800: #1e293b;
    --slate-900: #0f172a;
    --slate-600: #475569;
    --border-soft: #e2e8f0;
}

.user-mgmt-page {
    max-width: 1440px;
}

.text-slate-900 { color: #0f172a !important; }
.text-slate-800 { color: #1e293b !important; }
.text-slate-700 { color: #334155 !important; }
.text-purple { color: #7c3aed !important; }
.bg-purple-subtle { background-color: #f3e8ff !important; }

.header-icon-badge {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #e0e7ff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
}

.badge-master-pov {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
    font-weight: 600;
    padding: 0.35rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
}

.btn-create-user {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    font-weight: 600;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    border: none;
    transition: all 0.2s ease;
}

.btn-create-user:hover {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35) !important;
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 14px;
    padding: 1.15rem 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid #f1f5f9;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.08) !important;
}

.stat-icon-wrap {
    width: 48px;
    height: 48px;
    min-width: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
}

.stat-label {
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 0.15rem;
}

/* Toolbar Card */
.toolbar-card {
    background: white;
    border-radius: 14px;
    border: 1px solid #f1f5f9;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 14px;
    font-size: 0.9rem;
    pointer-events: none;
}

.modern-search-input {
    border-radius: 10px;
    padding-left: 38px;
    padding-right: 36px;
    border: 1px solid var(--border-soft);
    background-color: #f8fafc;
    font-size: 0.88rem;
    height: 42px;
    transition: all 0.2s;
}

.modern-search-input:focus {
    background-color: #ffffff;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
}

.clear-search-btn {
    position: absolute;
    right: 10px;
    background: transparent;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 0.85rem;
}

.clear-search-btn:hover {
    color: #475569;
}

.filter-chip {
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.35rem 0.85rem;
    border: 1px solid #e2e8f0;
    background-color: #ffffff;
    color: #64748b;
    transition: all 0.15s ease;
}

.filter-chip:hover {
    background-color: #f1f5f9;
    color: #1e293b;
    border-color: #cbd5e1;
}

.filter-chip.active {
    background-color: #1e293b;
    color: #ffffff;
    border-color: #1e293b;
}

/* Main Table */
.main-table-card {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #f1f5f9;
}

.modern-table {
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table thead th {
    background-color: #f8fafc;
    color: #64748b;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.modern-table tbody tr {
    transition: background-color 0.15s;
}

.modern-table tbody tr:hover {
    background-color: #fcfcfd;
}

.modern-table tbody td {
    padding: 1rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.875rem;
}

/* User Avatar */
.user-avatar {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 0.88rem;
    letter-spacing: -0.02em;
}

.user-avatar-mobile {
    width: 38px;
    height: 38px;
    min-width: 38px;
    font-size: 0.82rem;
}

.avatar-grad-1 { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.avatar-grad-2 { background: linear-gradient(135deg, #3b82f6, #06b6d4); }
.avatar-grad-3 { background: linear-gradient(135deg, #10b981, #059669); }
.avatar-grad-4 { background: linear-gradient(135deg, #f59e0b, #d97706); }
.avatar-grad-5 { background: linear-gradient(135deg, #ec4899, #8b5cf6); }

.user-name-text {
    font-weight: 600;
    color: var(--slate-900);
    line-height: 1.25;
}

.user-handle-text {
    color: #94a3b8;
    font-size: 0.75rem;
}

/* Badges */
.badge-tag {
    font-size: 0.74rem;
    font-weight: 600;
    padding: 0.28rem 0.65rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
}

.badge-tag-lizada {
    background-color: #e0e7ff;
    color: #3730a3;
    border: 1px solid #c7d2fe;
}

.badge-tag-dalio {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.badge-tag-master {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.badge-role {
    font-size: 0.74rem;
    font-weight: 600;
    padding: 0.28rem 0.65rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
}

.badge-role-master {
    background-color: #fef3c7;
    color: #78350f;
    border: 1px solid #fde68a;
}

.badge-role-admin {
    background-color: #f3e8ff;
    color: #6b21a8;
    border: 1px solid #e9d5ff;
}

.badge-role-user {
    background-color: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
}

/* Status Indicators */
.status-indicator {
    font-size: 0.76rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.25rem 0.6rem;
    border-radius: 9999px;
}

.status-active {
    background-color: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.status-pulse-dot {
    width: 7px;
    height: 7px;
    background-color: #10b981;
    border-radius: 50%;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}

.status-inactive {
    background-color: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
}

.status-inactive-dot {
    width: 7px;
    height: 7px;
    background-color: #f59e0b;
    border-radius: 50%;
}

/* Row Action Buttons */
.btn-row-action {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    transition: all 0.15s ease;
    text-decoration: none;
}

.btn-row-edit {
    color: #4f46e5;
}

.btn-row-edit:hover {
    background-color: #e0e7ff;
    border-color: #c7d2fe;
    color: #3730a3;
}

.btn-row-delete {
    color: #dc2626;
}

.btn-row-delete:hover {
    background-color: #fee2e2;
    border-color: #fca5a5;
    color: #b91c1c;
}

/* Mobile Card Styling */
.user-mobile-card {
    border-radius: 12px;
    border: 1px solid #f1f5f9;
}

.user-card-name {
    font-size: 0.95rem;
}

/* Minimal Pagination Standard */
.pagination-card {
    border-radius: 14px;
    border: 1px solid #f1f5f9;
    background: #ffffff;
}

.modern-pagination {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.modern-pagination .page-item .page-link {
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.45rem 1rem;
    border: 1px solid #e2e8f0;
    color: #475569;
    background: #ffffff;
    transition: all 0.15s ease;
    cursor: pointer;
}

.modern-pagination .page-item .page-link:hover:not(.pagination-curr-pill) {
    background-color: #f1f5f9;
    color: #0f172a;
    border-color: #cbd5e1;
}

.modern-pagination .page-item.active .pagination-curr-pill {
    background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
    border-color: #6366f1 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
    cursor: default;
}

.modern-pagination .page-item.disabled .page-link {
    opacity: 0.45;
    pointer-events: none;
    background-color: #f8fafc;
    border-color: #e2e8f0;
    color: #94a3b8;
    cursor: not-allowed;
}

/* Mobile Pagination: larger touch-friendly buttons */
@media (max-width: 576px) {
    .modern-pagination {
        width: 100%;
        justify-content: space-between;
    }

    .modern-pagination .page-item .page-link {
        min-height: 44px;
        min-width: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.55rem 1.1rem;
        font-size: 0.88rem;
    }
}

/* Modern Delete Modal */
.modal-modern-delete {
    border-radius: 16px;
    overflow: hidden;
}

.modal-delete-icon-wrap {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
// Delete confirmation handler
function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteConfirmBtn').href = 'index.php?route=admin-delete-user&id=' + encodeURIComponent(userId);
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Modern Real-time Search, Filter, and Minimal Pagination
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const filterChips = document.querySelectorAll('.filter-chip');
    const visibleCountSpan = document.getElementById('visibleUserCount');

    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');
    const prevPageLi = document.getElementById('prevPageLi');
    const nextPageLi = document.getElementById('nextPageLi');
    const pageIndicatorText = document.getElementById('pageIndicatorText');
    const pageRangeStart = document.getElementById('pageRangeStart');
    const pageRangeEnd = document.getElementById('pageRangeEnd');
    const totalRecordCount = document.getElementById('totalRecordCount');
    const paginationBar = document.getElementById('userPaginationBar');

    const itemsPerPage = 10;
    let currentPage = 1;
    let currentRoleFilter = 'all';
    let currentBarangayFilter = 'all';
    let searchQuery = '';

    let matchingDesktopRows = [];
    let matchingMobileCards = [];

    function renderPagination() {
        const totalMatches = matchingDesktopRows.length;
        const totalPages = Math.max(1, Math.ceil(totalMatches / itemsPerPage));

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }
        if (currentPage < 1) {
            currentPage = 1;
        }

        const startIdx = (currentPage - 1) * itemsPerPage;
        const endIdx = startIdx + itemsPerPage;

        // Desktop rows paginated slicing
        matchingDesktopRows.forEach((row, idx) => {
            row.style.display = (idx >= startIdx && idx < endIdx) ? '' : 'none';
        });

        // Mobile cards paginated slicing
        matchingMobileCards.forEach((card, idx) => {
            card.style.display = (idx >= startIdx && idx < endIdx) ? '' : 'none';
        });

        // Update range labels
        const startLabel = totalMatches > 0 ? (startIdx + 1) : 0;
        const endLabel = Math.min(endIdx, totalMatches);

        if (pageRangeStart) pageRangeStart.textContent = startLabel;
        if (pageRangeEnd) pageRangeEnd.textContent = endLabel;
        if (totalRecordCount) totalRecordCount.textContent = totalMatches;
        if (pageIndicatorText) pageIndicatorText.textContent = `Page ${currentPage} of ${totalPages}`;

        // Update Prev / Next buttons state
        if (prevPageLi) {
            if (currentPage <= 1) {
                prevPageLi.classList.add('disabled');
            } else {
                prevPageLi.classList.remove('disabled');
            }
        }

        if (nextPageLi) {
            if (currentPage >= totalPages || totalMatches === 0) {
                nextPageLi.classList.add('disabled');
            } else {
                nextPageLi.classList.remove('disabled');
            }
        }

        // Toggle pagination bar display if no results
        if (paginationBar) {
            paginationBar.style.display = totalMatches === 0 ? 'none' : 'block';
        }
    }

    function applyFilters() {
        const desktopRows = document.querySelectorAll('#usersDesktopTbody .user-row');
        const mobileCards = document.querySelectorAll('#mobileUserCardsList .user-mobile-card');

        matchingDesktopRows = [];
        matchingMobileCards = [];

        // Hide all rows initially and collect matches
        desktopRows.forEach(row => {
            row.style.display = 'none';
            if (testUserMatch(row)) {
                matchingDesktopRows.push(row);
            }
        });

        // Hide all mobile cards initially and collect matches
        mobileCards.forEach(card => {
            card.style.display = 'none';
            if (testUserMatch(card)) {
                matchingMobileCards.push(card);
            }
        });

        // Update count badge in toolbar
        if (visibleCountSpan) {
            visibleCountSpan.textContent = matchingDesktopRows.length;
        }

        // Reset to page 1 on search or filter change
        currentPage = 1;
        renderPagination();

        // Toggle empty states
        const desktopNoResults = document.getElementById('noResultsDesktop');
        const mobileNoResults = document.getElementById('noResultsMobile');

        if (desktopNoResults) {
            desktopNoResults.style.display = (matchingDesktopRows.length === 0 && desktopRows.length > 0) ? 'block' : 'none';
        }
        if (mobileNoResults) {
            mobileNoResults.style.display = (matchingMobileCards.length === 0 && mobileCards.length > 0) ? 'block' : 'none';
        }
    }

    function testUserMatch(el) {
        const name = el.getAttribute('data-fullname') || '';
        const username = el.getAttribute('data-username') || '';
        const email = el.getAttribute('data-email') || '';
        const barangay = el.getAttribute('data-barangay') || '';
        const role = el.getAttribute('data-role') || '';

        // Role check
        if (currentRoleFilter !== 'all') {
            if (currentRoleFilter === 'admin' && role !== 'admin') return false;
            if (currentRoleFilter === 'user' && role !== 'user') return false;
        }

        // Barangay check
        if (currentBarangayFilter !== 'all') {
            if (barangay !== currentBarangayFilter) return false;
        }

        // Search text check
        if (searchQuery !== '') {
            const haystack = (name + ' ' + username + ' ' + email + ' ' + barangay).toLowerCase();
            if (!haystack.includes(searchQuery)) return false;
        }

        return true;
    }

    // Pagination Click Events (Previous / Next)
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const totalMatches = matchingDesktopRows.length;
            const totalPages = Math.ceil(totalMatches / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }

    // Search Input Event
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchQuery = this.value.trim().toLowerCase();
            if (clearBtn) {
                clearBtn.style.display = searchQuery.length > 0 ? 'inline-block' : 'none';
            }
            applyFilters();
        });
    }

    // Clear Search Button
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchQuery = '';
            clearBtn.style.display = 'none';
            searchInput.focus();
            applyFilters();
        });
    }

    // Filter Chips Event
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            const type = this.getAttribute('data-filter-type');
            const val = this.getAttribute('data-filter-value');

            // Deactivate siblings of same group
            const group = this.closest('.btn-group');
            if (group) {
                group.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            }
            this.classList.add('active');

            if (type === 'role') {
                currentRoleFilter = val;
            } else if (type === 'barangay') {
                currentBarangayFilter = val;
            }

            applyFilters();
        });
    });

    // Reset filters global function
    window.resetAllFilters = function() {
        if (searchInput) {
            searchInput.value = '';
            searchQuery = '';
        }
        if (clearBtn) clearBtn.style.display = 'none';

        currentRoleFilter = 'all';
        currentBarangayFilter = 'all';

        filterChips.forEach(chip => {
            const val = chip.getAttribute('data-filter-value');
            if (val === 'all') {
                chip.classList.add('active');
            } else {
                chip.classList.remove('active');
            }
        });

        applyFilters();
    };

    // Initial render
    applyFilters();
});
</script>
