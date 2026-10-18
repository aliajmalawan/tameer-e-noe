    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section footer-brand">
                    <a href="index.php" class="footer-logo">
                        <img src="<?php echo getLogoSmallPath(); ?>" alt="<?php echo htmlspecialchars(getSiteName()); ?> Logo" width="64" height="64" onerror="this.style.display='none'">
                        <span>
                            <strong><?php echo htmlspecialchars(getSiteName()); ?></strong>
                            <small><?php echo htmlspecialchars(content('site_tagline')); ?></small>
                        </span>
                    </a>
                    <p><?php echo htmlspecialchars(getFooterContent()['about_text']); ?></p>
                    <?php
                    $social = array_filter(getSocialMedia());
                    if (!empty($social)): ?>
                    <div class="social-links">
                        <?php if (!empty($social['facebook'])): ?>
                            <a href="<?php echo htmlspecialchars($social['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif;
                        if (!empty($social['instagram'])): ?>
                            <a href="<?php echo htmlspecialchars($social['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif;
                        if (!empty($social['youtube'])): ?>
                            <a href="<?php echo htmlspecialchars($social['youtube']); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <?php endif;
                        if (!empty($social['twitter'])): ?>
                            <a href="<?php echo htmlspecialchars($social['twitter']); ?>" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="courses.php">Academics</a></li>
                        <li><a href="admission.php">Admissions</a></li>
                        <li><a href="gallery.php">Campus Life</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Explore</h3>
                    <ul>
                        <li><a href="faculty.php">Our Faculty</a></li>
                        <li><a href="events.php">News &amp; Events</a></li>
                        <li><a href="examination.php">Examination</a></li>
                        <li><a href="downloads.php">Downloads</a></li>
                        <li><a href="alumni.php">Alumni</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt"></i> <span><?php echo nl2br(htmlspecialchars(getSiteAddress())); ?></span></p>
                    <?php foreach (array_filter(array_map('trim', explode(',', getSitePhone()))) as $number): ?>
                        <p><i class="fas fa-phone"></i> <a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9+]/', '', $number)); ?>"><?php echo htmlspecialchars($number); ?></a></p>
                    <?php endforeach; ?>
                    <?php if (hasSiteEmail()): ?>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:<?php echo htmlspecialchars(getSiteEmail()); ?>"><?php echo htmlspecialchars(getSiteEmail()); ?></a></p>
                    <?php endif; ?>
                    <p><i class="fas fa-clock"></i> <span><?php echo htmlspecialchars(getOfficeHours()); ?></span></p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(getSiteName()); ?>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Website Analytics Tracker -->
    <?php
    // Track page views for analytics (only on public pages, not admin)
    if (file_exists(__DIR__ . '/analytics_tracker.php')) {
        include __DIR__ . '/analytics_tracker.php';
    }
    ?>

    <div class="scroll-progress" id="scroll-progress" aria-hidden="true"></div>
    <button type="button" class="back-to-top" id="back-to-top" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>

    <!-- JavaScript -->
    <script src="js/main.js?v=<?php echo assetVersion('js/main.js'); ?>"></script>
</body>
</html>
