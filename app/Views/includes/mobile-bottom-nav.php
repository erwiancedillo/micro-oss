<!-- Modern Mobile Icon Bottom Nav -->
<div class="mobile-bottom-nav" id="mobileBottomNav">
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <a href="index.php?route=dashboard" class="nav-item-mobile <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
        <i class="fas fa-house"></i>
    </a>
    <a href="index.php?route=community-map" class="nav-item-mobile <?php echo ($current_page == 'community-map') ? 'active' : ''; ?>">
        <i class="fas fa-map"></i>
    </a>
    <a href="index.php?route=evacuation" class="nav-item-mobile <?php echo ($current_page == 'evacuation') ? 'active' : ''; ?>">
        <i class="fas fa-route"></i>
    </a>
    <a href="index.php?route=alerts" class="nav-item-mobile <?php echo ($current_page == 'alerts') ? 'active' : ''; ?>">
        <i class="fas fa-bell"></i>
    </a>
    <?php if (isset($_SESSION['id'])): ?>
        <a href="#" class="nav-item-mobile" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <?php
            $profile_src = (isset($_SESSION['profile_picture']) && !empty($_SESSION['profile_picture']))
                ? 'assets/uploads/' . $_SESSION['profile_picture']
                : 'assets/uploads/hazard_maps/default-profile.jpg';
            ?>
            <img src="<?php echo htmlspecialchars($profile_src); ?>" alt="Profile" class="nav-profile-img">
        </a>
    <?php else: ?>
        <a href="#" class="nav-item-mobile" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="fas fa-user-circle"></i>
        </a>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bottomNav = document.getElementById('mobileBottomNav');
            const sidebar = document.getElementById('mobileSidebar');
            let lastScrollTop = 0;
            let isSidebarOpen = false;

            if (bottomNav && sidebar) {
                // Hiding/Showing when Sidebar is toggled
                sidebar.addEventListener('show.bs.offcanvas', function() {
                    isSidebarOpen = true;
                    bottomNav.classList.add('hide-nav');
                });

                sidebar.addEventListener('hidden.bs.offcanvas', function() {
                    isSidebarOpen = false;
                    bottomNav.classList.remove('hide-nav');
                });

                // Hiding/Showing based on Scroll
                window.addEventListener('scroll', function() {
                    if (isSidebarOpen) return;

                    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                    if (scrollTop > lastScrollTop && scrollTop > 50) {
                        // Scrolling down - hide
                        bottomNav.classList.add('hide-nav');
                    } else if (scrollTop < lastScrollTop) {
                        // Scrolling up - show
                        bottomNav.classList.remove('hide-nav');
                    }

                    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
                }, {
                    passive: true
                });
            }
        });
    </script>
</div>