<?php
// Register view — compact, fully visible on small screens and phones
?>
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-card-col w-100">
        <div class="card border-0 shadow-2xl rounded-4 overflow-hidden glass-card">
            <!-- Header -->
            <div class="card-header border-0 text-center px-4 py-3 dashboard-gradient text-white">
                <div class="icon-container bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                    <img src="assets/uploads/Lizadalogo.jpg" alt="Logo" class="rounded-circle" style="width:100%;height:100%;object-fit:cover;border:2px solid #fff;">
                </div>
                <h2 class="fw-bold mb-0 fs-5">Create Account</h2>
                <p class="opacity-75 mb-0 mt-1" style="font-size:0.78rem;">Register &mdash; subject to Master approval</p>
            </div>

            <!-- Body -->
            <div class="card-body px-4 py-3 bg-white">

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger border-0 rounded-3 mb-2 py-2 d-flex align-items-center" style="font-size:0.85rem;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success border-0 rounded-3 mb-2 py-2 d-flex align-items-center" style="font-size:0.85rem;">
                        <i class="fas fa-check-circle me-2"></i>
                        <div><?= htmlspecialchars($success) ?></div>
                    </div>
                <?php endif; ?>

                <form action="/micro-oss/index.php?route=register" method="POST">
                    <div class="form-floating mb-2">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required>
                        <label for="name" style="font-size:0.85rem;">Full Name</label>
                    </div>
                    <div class="form-floating mb-2">
                        <select name="barangay" class="form-select" id="barangay" required>
                            <option value="" disabled selected hidden>Select your Barangay</option>
                            <?php if (isset($barangayList)): ?>
                                <?php foreach ($barangayList as $b): ?>
                                    <option value="<?= htmlspecialchars($b) ?>"><?= htmlspecialchars($b) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <label for="barangay" style="font-size:0.85rem;">Barangay</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                        <label for="email" style="font-size:0.85rem;">Email Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                        <label for="password" style="font-size:0.85rem;">Password</label>
                    </div>
                    <button class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm transition-all mb-2" style="font-size:0.9rem;">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </button>
                </form>

                <div class="text-center pt-2 border-top mt-2">
                    <p class="text-muted mb-0" style="font-size:0.8rem;">
                        Already have an account?
                        <a href="/micro-oss/index.php?route=login" class="text-primary fw-bold text-decoration-none ms-1 hover-underline">Login here</a>
                    </p>
                </div>
            </div>
        </div>
        <p class="text-center text-muted mt-2 opacity-50" style="font-size:0.75rem;">&copy; <?= date('Y') ?> Micro OSS. All rights reserved.</p>
    </div>
</div>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --glass-bg: rgba(255, 255, 255, 0.97);
    }

    /* Wrapper — let the parent layout handle centering and height */
    .login-wrapper {
        padding: 0.5rem 0.25rem;
        box-sizing: border-box;
    }

    .login-card-col {
        max-width: 400px;
        margin: 0 auto;
    }

    .dashboard-gradient { background: var(--primary-gradient); }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .icon-container {
        width: 54px;
        height: 54px;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .card:hover .icon-container { transform: scale(1.08) rotate(8deg); }

    .form-floating > .form-control,
    .form-floating > .form-select {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        padding-left: 0.85rem;
        height: calc(3rem + 2px);
    }
    .form-floating > label { padding-left: 0.85rem; }
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #6366f1;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }
    .form-floating > .form-control:hover,
    .form-floating > .form-select:hover {
        border-color: #cbd5e1;
        background-color: #f1f5f9;
        cursor: pointer;
    }

    .transition-all { transition: all 0.3s ease; }

    .btn-primary { background: var(--primary-gradient); border: none; }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -4px rgba(99,102,241,0.45) !important;
        filter: brightness(1.08);
    }

    .hover-underline:hover { text-decoration: underline !important; }
    .shadow-2xl { box-shadow: 0 20px 40px -10px rgba(0,0,0,0.13); }

    @media (max-width: 360px) {
        .login-wrapper { padding: 0.5rem; }
        .icon-container { width: 44px; height: 44px; }
    }

    @media (max-height: 600px) {
        .login-wrapper { align-items: flex-start; padding-top: 0.5rem; }
        .icon-container { width: 40px; height: 40px; }
        .card-header { padding: 0.6rem 1rem !important; }
        .card-body { padding: 0.75rem 1rem !important; }
        .mb-2 { margin-bottom: 0.35rem !important; }
        .mb-3 { margin-bottom: 0.5rem !important; }
    }
</style>