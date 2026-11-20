/**
 * Micro OSS Auth Pages (Login & Register)
 * - Password Visibility Toggle
 * - Form Submission Indicator
 * - Smooth Animated Page Transitions
 */

document.addEventListener("DOMContentLoaded", function () {
    // 1. Password Toggle
    const passwordInput = document.getElementById("password");
    const togglePasswordBtn = document.getElementById("togglePassword");
    const eyeIcon = document.getElementById("eyeIcon");

    if (passwordInput && togglePasswordBtn && eyeIcon) {
        togglePasswordBtn.addEventListener("click", function () {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";

            togglePasswordBtn.setAttribute(
                "aria-label",
                isPassword ? "Hide password" : "Show password"
            );

            if (isPassword) {
                eyeIcon.innerHTML = `
                    <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                    <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                    <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                    <line x1="2" y1="2" x2="22" y2="22"></line>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            }
        });
    }

    // 2. Submit Loading State
    const authForm = document.getElementById("authForm") || document.getElementById("loginForm");
    const submitBtn = document.getElementById("submitBtn");

    if (authForm && submitBtn) {
        authForm.addEventListener("submit", function () {
            submitBtn.style.opacity = "0.85";
            submitBtn.style.pointerEvents = "none";
            const btnText = submitBtn.querySelector(".btn-text");
            if (btnText) {
                btnText.textContent = btnText.getAttribute("data-loading-text") || "Please wait...";
            }
        });
    }

    // 3. Smooth Page Transition between Login & Register
    const authCard = document.querySelector(".login-card");
    const switchLinks = document.querySelectorAll(".auth-switch-link");

    if (authCard && switchLinks.length > 0) {
        switchLinks.forEach(function (link) {
            link.addEventListener("click", function (e) {
                // Ignore modifier keys for new tab
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;

                const targetUrl = link.getAttribute("href");
                if (!targetUrl || targetUrl.startsWith("#")) return;

                e.preventDefault();

                // Determine transition direction
                const direction = link.getAttribute("data-direction") || "left";
                
                authCard.classList.remove("anim-enter-left", "anim-enter-right");
                if (direction === "left") {
                    authCard.classList.add("anim-exit-left");
                } else {
                    authCard.classList.add("anim-exit-right");
                }

                setTimeout(function () {
                    window.location.href = targetUrl;
                }, 220);
            });
        });
    }
});
