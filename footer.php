    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><i class="fas fa-blog"></i> Blogify</h3>
                    <p>A platform for sharing stories, ideas, and inspiration with the world.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <?php if (is_logged_in()): ?>
                            <li><a href="dashboard.php">Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Sign Up</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Connect</h4>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Blogify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
    <script>
    // Mobile Menu Functionality - Robust implementation from TopNotch
    (function() {
        function initMobileMenu() {
            console.log('🚀 Mobile menu initializer running');

            const mobileToggle = document.getElementById('mobileToggle');
            const navMenu = document.getElementById('navMenu');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const body = document.body;
            const html = document.documentElement;

            console.log('Mobile toggle found:', !!mobileToggle);
            console.log('Nav menu found:', !!navMenu);
            console.log('Overlay found:', !!mobileOverlay);

            if (!mobileToggle || !navMenu) {
                console.error('❌ CRITICAL: Mobile menu elements not found!');
                return;
            }

            console.log('✅ All elements found successfully!');

            // Set up accessibility attributes
            mobileToggle.setAttribute('type', 'button');
            mobileToggle.setAttribute('aria-expanded', 'false');
            mobileToggle.setAttribute('aria-controls', 'navMenu');
            navMenu.setAttribute('aria-hidden', 'true');

            let _toggleGuard = false;
            
            function toggleMenuHandler(e) {
                if (_toggleGuard) return;
                _toggleGuard = true;
                setTimeout(() => { _toggleGuard = false; }, 350);

                e && e.preventDefault();
                e && e.stopPropagation();

                mobileToggle.classList.toggle('active');
                navMenu.classList.toggle('active');

                const isOpen = navMenu.classList.contains('active');
                
                // Lock scroll on both <html> and <body> for robust mobile support
                html.style.overflow = isOpen ? 'hidden' : '';
                body.style.overflow = isOpen ? 'hidden' : '';

                mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                navMenu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

                if (mobileOverlay) {
                    mobileOverlay.classList.toggle('active', isOpen);
                }

                console.log(isOpen ? '📂 Menu OPENED' : '📁 Menu CLOSED');
            }

            // Multiple event listeners for maximum compatibility
            mobileToggle.addEventListener('pointerup', toggleMenuHandler);
            mobileToggle.addEventListener('click', toggleMenuHandler);
            mobileToggle.addEventListener('touchend', toggleMenuHandler);

            // Close menu when clicking overlay
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function(e) {
                    console.log('Overlay clicked - closing menu');
                    e.preventDefault();
                    closeMobileMenu();
                });
            }

            // Close menu when clicking links
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeMobileMenu();
                    }
                });
            });

            // Close menu on window resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeMobileMenu();
                    console.log('Resized to desktop - menu auto-closed');
                }
            });

            // Close menu on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
            });

            function closeMobileMenu() {
                mobileToggle.classList.remove('active');
                navMenu.classList.remove('active');
                if (mobileOverlay) {
                    mobileOverlay.classList.remove('active');
                }
                
                // Unlock scroll on both elements
                html.style.overflow = '';
                body.style.overflow = '';
                
                navMenu.setAttribute('aria-hidden', 'true');
                mobileToggle.setAttribute('aria-expanded', 'false');
                console.log('✅ Menu CLOSED via function');
            }

            window.closeMobileMenu = closeMobileMenu;
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMobileMenu);
        } else {
            initMobileMenu();
        }
    })();
    </script>
</body>
</html>