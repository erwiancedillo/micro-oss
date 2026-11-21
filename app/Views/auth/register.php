<?php
// Modern Split Register View - Micro OSS Disaster System
$error = $error ?? '';
$success = $success ?? '';
$csrfToken = $csrfToken ?? '';
$barangayList = (!empty($barangayList)) ? $barangayList : ['Lizada', 'Dalio'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Micro OSS Disaster System</title>
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Modern Auth CSS -->
    <link rel="stylesheet" href="<?= APP_BASE_PATH ?>/assets/css/login.css">
</head>
<body>

    <div class="login-wrapper">

        <!-- Background Decorative Curve Ribbons (Project Purple/Indigo Palette) -->
        <div class="curve-bg-accent" aria-hidden="true">
            <svg class="curve-svg" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="purpleRibbon" x1="0%" y1="100%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#5a3d8a" />
                        <stop offset="50%" stop-color="#764ba2" />
                        <stop offset="100%" stop-color="#a855f7" />
                    </linearGradient>
                    <linearGradient id="indigoRibbon" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="rgba(102, 126, 234, 0.45)" />
                        <stop offset="50%" stop-color="rgba(118, 75, 162, 0.15)" />
                        <stop offset="100%" stop-color="rgba(102, 126, 234, 0.02)" />
                    </linearGradient>
                    <linearGradient id="whiteWave" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="rgba(255, 255, 255, 0.35)" />
                        <stop offset="100%" stop-color="rgba(255, 255, 255, 0.02)" />
                    </linearGradient>
                </defs>

                <!-- Flowing White / Indigo Top-Right Curve -->
                <path d="M720 0C900 120 1140 180 1440 100V0H720Z" fill="url(#whiteWave)" />
                <path d="M500 0C700 240 1050 320 1440 260V0H500Z" fill="url(#indigoRibbon)" />

                <!-- Bottom Sweeping Purple & Indigo Ribbon Waves -->
                <path d="M0 900C300 870 650 820 900 700C1100 600 1320 620 1440 680V900H0Z" fill="url(#whiteWave)" />
                <path d="M0 900C350 885 620 830 880 735C1080 655 1280 670 1440 720V735C1280 685 1080 670 880 750C620 845 350 900 0 900Z" fill="url(#purpleRibbon)" />
            </svg>
        </div>

        <div class="login-container">

            <!-- LEFT: HERO & COMMUNITY INFO -->
            <section class="hero-section">

                <!-- Brand Header -->
                <div class="brand-header">
                    <div class="brand-logo-wrap">
                        <div class="brand-seal">
                            <div class="brand-seal-inner">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="brand-title">
                            <span class="brand-name">Micro OSS</span>
                            <span class="brand-sub">Disaster Information System</span>
                        </div>
                    </div>

                    <div class="brand-divider"></div>

                    <div class="brand-motto">
                        PREPARE &bull; RESPOND &bull; PROTECT
                    </div>
                </div>

                <!-- Main Hero Headline -->
                <div class="hero-content">
                    <h1 class="hero-heading">
                        Building a<br>
                        Smarter, Stronger<br>
                        <span class="highlight-brand">Resilient</span> Community
                    </h1>

                    <p class="hero-subheading">
                        Coordinated disaster response, evacuation center management, and community alerts for our partner barangays.
                    </p>
                </div>

                <!-- Our Partner Barangays Card -->
                <div class="partners-card">
                    <div class="partners-badge-header">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 17a1 1 0 0 0 1.41 0l5.88-5.88a5 5 0 0 0-7.07-7.07L9 6.34 6.78 4.05a5 5 0 0 0-7.07 7.07l5.88 5.88A1 1 0 0 0 7 17"></path>
                            <path d="m15.5 8.5 2 2"></path>
                            <path d="m11 13 2 2"></path>
                        </svg>
                        <span>Our Partner Barangays</span>
                    </div>

                    <div class="barangays-partner-grid">
                        <!-- Barangay Lizada -->
                        <div class="barangay-card-item">
                            <div class="barangay-logo-wrap">
                                <img src="<?= APP_BASE_PATH ?>/assets/uploads/Lizadalogo.jpg" alt="Barangay Lizada Logo">
                            </div>
                            <div class="barangay-info">
                                <span class="barangay-name">Barangay Lizada</span>
                                <span class="barangay-role">Community Partner</span>
                            </div>
                        </div>

                        <!-- Barangay Dalio -->
                        <div class="barangay-card-item">
                            <div class="barangay-logo-wrap">
                                <img src="<?= APP_BASE_PATH ?>/assets/uploads/barangaydalio.jpg" alt="Barangay Dalio Logo">
                            </div>
                            <div class="barangay-info">
                                <span class="barangay-name">Barangay Dalio</span>
                                <span class="barangay-role">Community Partner</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Tagline -->
                <div class="hero-footer-tagline">
                    <span class="line"></span>
                    <span>Together for a safer and disaster-resilient community</span>
                    <span class="line"></span>
                </div>

            </section>

            <!-- RIGHT: MODERN FLOATING REGISTER CARD -->
            <section class="login-card-container">

                <div class="login-card anim-enter-right">

                    <!-- User Plus Badge Icon -->
                    <div class="card-header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <line x1="20" y1="8" x2="20" y2="14"></line>
                            <line x1="23" y1="11" x2="17" y2="11"></line>
                        </svg>
                    </div>

                    <!-- Title & Subtitle -->
                    <h2 class="card-title">Create Account</h2>
                    <p class="card-subtitle">Register to join the disaster response network</p>

                    <!-- Error Alert -->
                    <?php if (!empty($error)): ?>
                        <div class="login-error-alert" role="alert">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Success Alert -->
                    <?php if (!empty($success)): ?>
                        <div class="login-success-alert" role="alert">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span><?= htmlspecialchars($success) ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Register Form -->
                    <form action="<?= APP_BASE_PATH ?>/index.php?route=register" method="POST" id="authForm">

                        <?php if (!empty($csrfToken)): ?>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <?php endif; ?>

                        <!-- Full Name -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    placeholder="Full Name (e.g. Juan Santos)" 
                                    autocomplete="name" 
                                    required
                                >
                            </div>
                        </div>

                        <!-- Barangay Dropdown -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <select name="barangay" id="barangay" required aria-required="true">
                                    <option value="" disabled selected hidden>Select your Barangay (Required) *</option>
                                    <?php foreach ($barangayList as $b): ?>
                                        <option value="<?= htmlspecialchars($b) ?>" <?= (isset($_POST['barangay']) && $_POST['barangay'] === $b) ? 'selected' : '' ?>><?= htmlspecialchars($b) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input
                                    type="text"
                                    name="username"
                                    id="username"
                                    placeholder="Username"
                                    autocomplete="username"
                                    autocapitalize="none"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    placeholder="Email Address" 
                                    autocomplete="email" 
                                    required
                                >
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    placeholder="Password (min. 6 characters)" 
                                    autocomplete="new-password" 
                                    required
                                >
                                <button type="button" class="password-toggle-btn" id="togglePassword" aria-label="Toggle password visibility">
                                    <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-login" id="submitBtn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            <span class="btn-text" data-loading-text="Creating Account...">Create Account</span>
                        </button>

                    </form>

                    <!-- Footer Link (Back to Login with Smooth Animation) -->
                    <div class="card-footer-register">
                        <span>Already have an account?</span>
                        <a href="<?= APP_BASE_PATH ?>/index.php?route=login" class="auth-switch-link" data-direction="right">Log In</a>
                    </div>

                </div>

            </section>

        </div>

    </div>

    <!-- Auth JS -->
    <script src="<?= APP_BASE_PATH ?>/assets/js/login.js"></script>

</body>
</html>
