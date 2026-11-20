<?php
// Modern Split Login View - Micro OSS Disaster System
$error = $error ?? '';
$csrfToken = $csrfToken ?? '';
$googleURL = $googleURL ?? '/auth/google';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | Micro OSS Disaster System</title>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Modern Login CSS -->
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
                                <!-- Shield Icon matching Micro OSS -->
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                </svg>
                            </div>
                        </div>
                        <div class="brand-title">
                            <span class="brand-name">Micro OSS</span>
                            <span class="brand-sub">Micro Online Synthesis System</span>
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
                        <!-- Handshake Icon -->
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

            <!-- RIGHT: MODERN FLOATING LOGIN CARD -->
            <section class="login-card-container">

                <div class="login-card anim-enter-left">

                    <!-- Shield & Lock Badge Icon -->
                    <div class="card-header-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" fill="#eef2ff"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            <circle cx="12" cy="16" r="1" fill="#667eea"></circle>
                        </svg>
                    </div>

                    <!-- Title & Subtitle -->
                    <h2 class="card-title">Log In</h2>
                    <p class="card-subtitle">Access your account to continue</p>

                    <!-- Error Alert (if any) -->
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

                    <!-- Login Form -->
                    <form action="<?= APP_BASE_PATH ?>/index.php?route=login" method="POST" id="loginForm">

                        <?php if (!empty($csrfToken)): ?>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <?php endif; ?>

                        <!-- Email Address or Username -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <!-- User Icon -->
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input
                                    type="text"
                                    name="email"
                                    id="email"
                                    placeholder="Email Address or Username"
                                    autocomplete="username"
                                    required>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-field-group">
                            <div class="input-container">
                                <!-- Lock Icon -->
                                <svg class="input-icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                    autocomplete="current-password"
                                    required>
                                <!-- Eye Toggle Button -->
                                <button type="button" class="password-toggle-btn" id="togglePassword" aria-label="Toggle password visibility">
                                    <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="form-options-row">
                            <label class="remember-label">
                                <input type="checkbox" name="remember" id="rememberMe">
                                <span>Remember Me</span>
                            </label>

                            <a href="<?= APP_BASE_PATH ?>/index.php?route=forgot-password" class="forgot-password-link">Forgot Password?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-login" id="submitBtn">
                            <!-- Arrow Sign-in Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            <span class="btn-text" data-loading-text="Signing In...">Log In</span>
                        </button>

                    </form>

                    <!-- Divider -->
                    <div class="divider-or">
                        <span>or continue with</span>
                    </div>

                    <!-- Social Login Icons -->
                    <div class="social-buttons-row">
                        <!-- Google -->
                        <a href="<?= htmlspecialchars($googleURL) ?>" class="social-btn" title="Continue with Google">
                            <svg viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </a>

                        <!-- Microsoft -->
                        <a href="#" class="social-btn" title="Continue with Microsoft">
                            <svg viewBox="0 0 21 21">
                                <rect x="1" y="1" width="9" height="9" fill="#f25022" />
                                <rect x="11" y="1" width="9" height="9" fill="#7fba00" />
                                <rect x="1" y="11" width="9" height="9" fill="#00a4ef" />
                                <rect x="11" y="11" width="9" height="9" fill="#ffb900" />
                            </svg>
                        </a>

                        <!-- Apple -->
                        <a href="#" class="social-btn" title="Continue with Apple">
                            <svg viewBox="0 0 170 170" fill="#000000">
                                <path d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.58-7.7-11.64-13.98-5.99-9.13-10.74-19.46-14.24-30.98-3.5-11.52-5.25-22.38-5.25-32.6 0-14.56 3.69-26.63 11.08-36.21 7.38-9.57 16.65-14.47 27.8-14.68 5.43 0 11.27 1.41 17.51 4.23 6.24 2.82 10.14 4.3 11.71 4.45 1.57-.15 5.76-1.68 12.57-4.6 6.81-2.92 12.43-4.22 16.86-3.89 12.4.99 22.42 5.56 30.06 13.72-10.88 6.53-16.21 15.56-16 27.1.22 9.03 3.65 16.67 10.3 22.92 6.65 6.25 14.54 9.87 23.66 10.87-2.17 6.3-4.78 12.3-7.85 18zM119.22 31.95c0-7.28 2.65-14.1 7.95-20.47 5.3-6.36 11.77-10.34 19.4-11.93.43 3.48.43 6.96 0 10.43-1.09 7.07-4.02 13.6-8.8 19.6-4.78 6-10.98 9.5-18.6 10.5-.32-2.72-.48-5.43-.48-8.13z" />
                            </svg>
                        </a>
                    </div>

                    <!-- Register Link -->
                    <div class="card-footer-register">
                        <span>Don't have an account?</span>
                        <a href="<?= APP_BASE_PATH ?>/index.php?route=register" class="auth-switch-link" data-direction="left">Register Here</a>
                    </div>

                </div>

            </section>

        </div>

    </div>

    <!-- Login JS -->
    <script src="<?= APP_BASE_PATH ?>/assets/js/login.js"></script>

</body>

</html>