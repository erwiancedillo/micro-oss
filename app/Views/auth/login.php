<?php
// We wrap this in the layout usually, but the original has its own head/styles
// To keep it simple and match the design, we'll use the original structure here
// or we can adapt it to the layout. The layout.php is very basic right now.
?>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-5">
            <div class="card-header border-0 text-center p-5 dashboard-gradient text-white">
                <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-lock fa-2x"></i>
                </div>
                <h2 class="fw-bold mb-0">Welcome Back</h2>
                <p class="opacity-75 mb-0 mt-2">Sign in to your account</p>
            </div>

            <div class="card-body p-4 p-lg-5 bg-white">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form action="/micro-oss/index.php?route=login" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                        <label for="email">Email Address</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <button class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm transition-all mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </form>

                <div class="separator text-center my-4 position-relative">
                    <hr class="text-muted">
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-bold text-uppercase">or</span>
                </div>

                <?php if (isset($googleURL)): ?>
                    <a href="<?= $googleURL ?>" class="btn btn-outline-danger w-100 py-2 rounded-pill fw-bold transition-all mb-3 d-flex align-items-center justify-content-center">
                        <i class="fab fa-google me-2"></i> Sign in with Google
                    </a>
                <?php else: ?>
                    <button class="btn btn-outline-danger w-100 py-2 rounded-pill fw-bold opacity-50 mb-3" disabled>
                        <i class="fab fa-google me-2"></i> Google Sign-in Missing
                    </button>
                <?php endif; ?>

                <div class="text-center mt-4 pt-3 border-top">
                    <span class="text-muted">Don't have an account?</span>
                    <a href="/micro-oss/index.php?route=register" class="text-primary fw-bold text-decoration-none ms-1">Create Account</a>
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