<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-bottom py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-user-<?= isset($user) ? 'edit' : 'plus' ?> text-primary me-2"></i>
                        <?= isset($user) ? 'Edit User' : 'Add New User' ?>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" id="userForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" 
                                       required
                                       placeholder="Enter first name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" 
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
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                                   required
                                   placeholder="user@example.com">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="user" <?= (isset($user) && $user['role'] === 'user') ? 'selected' : '' ?>>Regular User</option>
                                    <option value="admin" <?= (isset($user) && $user['role'] === 'admin') ? 'selected' : '' ?>>Administrator</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?= (isset($user) && $user['status'] === 'active') ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= (isset($user) && $user['status'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Password <?= isset($user) ? '<small class="text-muted">(Leave blank to keep current)</small>' : '' ?>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       <?= !isset($user) ? 'required' : '' ?>
                                       placeholder="<?= isset($user) ? 'Enter new password' : 'Enter password' ?>">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (!isset($user)): ?>
                                <small class="text-muted">Minimum 6 characters</small>
                            <?php endif; ?>
                        </div>

                        <?php if (!isset($user)): ?>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           required
                                           placeholder="Confirm password">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?route=admin-users" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Users
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                <?= isset($user) ? 'Update User' : 'Create User' ?>
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
    // Password visibility toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    }
    
    // Confirm password visibility toggle
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    if (toggleConfirmPassword && confirmPasswordInput) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    }
    
    // Form validation
    const form = document.getElementById('userForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password');
            
            // For new users, check password match
            if (confirmPassword && password !== confirmPassword.value) {
                e.preventDefault();
                alert('Passwords do not match. Please check and try again.');
                return false;
            }
            
            // For new users, check password length
            if (!<?= isset($user) ? 'true' : 'false' ?> && password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                return false;
            }
            
            // For editing, check password length if provided
            <?php if (isset($user)): ?>
            if (password && password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                return false;
            }
            <?php endif; ?>
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
</style>
