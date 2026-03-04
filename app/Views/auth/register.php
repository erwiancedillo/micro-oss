<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header border-0 text-center p-5 dashboard-gradient text-white">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h2 class="fw-bold mb-0">Join Our Community</h2>
                    <p class="opacity-75 mb-0 mt-2">Create your account for resilience updates</p>
                </div>
                
                <div class="card-body p-4 p-lg-5 bg-white">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-3"></i>
                            <div><?= htmlspecialchars($error) ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center">
                            <i class="fas fa-check-circle me-3"></i>
                            <div><?= htmlspecialchars($success) ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="/micro-oss/index.php?route=register">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Juan Dela Cruz" required>
                            <label for="name">Full Name</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">Email Address</label>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm transition-all">
                            <i class="fas fa-paper-plane me-2"></i> Create Account
                        </button>
                    </form>
                    
                    <div class="text-center mt-5 pt-4 border-top">
                        <span class="text-muted">Already a member?</span> 
                        <a href="/micro-oss/index.php?route=login" class="text-primary fw-bold text-decoration-none ms-1">Login here</a>
                    </div>
                </div>
            </div>
    </div>
</div>

<style>
    .dashboard-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .form-floating > .form-control {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .form-floating > .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -6px rgba(102, 126, 234, 0.6) !important;
    }
</style>

<style>
    .register-wrapper {
        max-width: 450px;
        width: 100%;
        padding: 20px;
    }
    .register-container {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        border-radius: 16px;
    }
    .form-control {
        padding: 12px;
        border-radius: 8px;
        background: #f8f9fa;
    }
</style>