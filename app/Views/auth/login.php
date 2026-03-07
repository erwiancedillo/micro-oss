<?php
// We wrap this in the layout usually, but the original has its own head/styles
// To keep it simple and match the design, we'll use the original structure here
// or we can adapt it to the layout. The layout.php is very basic right now.
?>
<div class="row justify-content-center align-items-center min-vh-100 g-0">
    <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
        <div class="card border-0 shadow-2xl rounded-5 overflow-hidden my-5 glass-card">
            <div class="card-header border-0 text-center p-4 p-md-5 dashboard-gradient text-white">
                <div class="icon-container bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                    <i class="fas fa-shield-alt fa-2x"></i>
                </div>
                <h2 class="fw-bold mb-0 h3">Welcome Back</h2>
                <p class="opacity-75 mb-0 mt-2 small">Securely sign in to your account</p>
            </div>

            <div class="card-body p-4 p-md-5 bg-white">
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

                <div class="text-center mt-4 pt-4 border-top">
                    <p class="text-muted small mb-0">
                        Don't have an account?
                        <a href="/micro-oss/index.php?route=register" class="text-primary fw-bold text-decoration-none ms-1 hover-underline">Create Account</a>
                    </p>
                </div>
            </div>
        </div>
        <p class="text-center text-muted small mt-4 opacity-50">&copy; <?= date('Y') ?> Micro OSS. All rights reserved.</p>
    </div>
</div>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
    }

    .dashboard-gradient {
        background: var(--primary-gradient);
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .icon-container {
        width: 70px;
        height: 70px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card:hover .icon-container {
        transform: scale(1.1) rotate(10deg);
    }

    .form-floating>.form-control {
        border-radius: 12px;
        border: 1.5px solid #f1f5f9;
        background-color: #f8fafc;
        padding-left: 1rem;
        height: calc(3.5rem + 2px);
    }

    .form-floating>label {
        padding-left: 1rem;
    }

    .form-floating>.form-control:focus {
        border-color: #6366f1;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.5) !important;
        filter: brightness(1.1);
    }

    .btn-outline-danger {
        border-width: 1.5px;
    }

    .btn-outline-danger:hover {
        background-color: #fef2f2;
        color: #dc2626;
        border-color: #ef4444;
        transform: translateY(-1px);
    }

    .hover-underline:hover {
        text-decoration: underline !important;
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 2.5rem 1.5rem !important;
        }

        .card-body {
            padding: 2rem 1.5rem !important;
        }

        .h3 {
            font-size: 1.5rem;
        }
    }
</style>