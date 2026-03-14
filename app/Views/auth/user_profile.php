<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            My Profile
                        </h4>
                        <a href="index.php?route=dashboard" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= htmlspecialchars($_SESSION['flash_message']) ?>
                            <?php unset($_SESSION['flash_message']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" id="profileForm">
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="profile-avatar mb-3">
                                    <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                        <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                                    </div>
                                    <h5 class="mt-3 mb-1"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h5>
                                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'info' ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-3">Account Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="first_name" 
                                               name="first_name" 
                                               value="<?= htmlspecialchars($user['first_name']) ?>" 
                                               required
                                               placeholder="Enter first name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="last_name" 
                                               name="last_name" 
                                               value="<?= htmlspecialchars($user['last_name']) ?>" 
                                               required
                                               placeholder="Enter last name">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value="<?= htmlspecialchars($user['email']) ?>" 
                                           required
                                           placeholder="user@example.com">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Account Status</label>
                                        <div>
                                            <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'warning' ?>">
                                                <?= ucfirst($user['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Member Since</label>
                                        <div class="text-muted">
                                            <?= date('F j, Y', strtotime($user['created_at'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Change Password</h5>
                        <p class="text-muted small">Leave blank if you don't want to change your password</p>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="current_password" 
                                           name="current_password" 
                                           placeholder="Enter current password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password" 
                                           name="new_password" 
                                           placeholder="Enter new password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           placeholder="Confirm new password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?route=dashboard" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggles
    const toggleButtons = [
        { button: 'toggleCurrentPassword', input: 'current_password' },
        { button: 'toggleNewPassword', input: 'new_password' },
        { button: 'toggleConfirmPassword', input: 'confirm_password' }
    ];

    toggleButtons.forEach(({ button, input }) => {
        const toggleBtn = document.getElementById(button);
        const inputField = document.getElementById(input);
        
        if (toggleBtn && inputField) {
            toggleBtn.addEventListener('click', function() {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        }
    });
    
    // Form validation
    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const currentPassword = document.getElementById('current_password').value;
            
            // If new password is provided, validate all password fields
            if (newPassword) {
                if (!currentPassword) {
                    e.preventDefault();
                    alert('Current password is required to change password.');
                    return false;
                }
                
                if (newPassword.length < 6) {
                    e.preventDefault();
                    alert('New password must be at least 6 characters long.');
                    return false;
                }
                
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('New passwords do not match.');
                    return false;
                }
            }
            
            // If confirm password is provided but new password is not
            if (confirmPassword && !newPassword) {
                e.preventDefault();
                alert('Please enter a new password.');
                return false;
            }
        });
    }
    
    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            if (email && !isValidEmail(email)) {
                this.classList.add('is-invalid');
                if (!document.getElementById('emailFeedback')) {
                    const feedback = document.createElement('div');
                    feedback.id = 'emailFeedback';
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Please enter a valid email address.';
                    this.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = document.getElementById('emailFeedback');
                if (feedback) {
                    feedback.remove();
                }
            }
        });
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
</script>

<style>
.avatar-lg {
    width: 120px;
    height: 120px;
    font-size: 36px;
    font-weight: bold;
}

.profile-avatar {
    position: relative;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(118, 75, 162, 0.3);
}

.card {
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.input-group .btn {
    border-left: none;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

.badge {
    font-weight: 500;
}
</style>
