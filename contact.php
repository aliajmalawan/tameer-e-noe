<?php
require_once 'includes/config.php';
$page_title = content('seo_contact_title');
$meta_description = content('seo_contact_description');

$success_message = '';
$error_message = '';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert_query = "INSERT INTO contacts (name, email, phone, subject, message, status, created_at)
                     VALUES ('$name', '$email', '$phone', '$subject', '$message', 'unread', NOW())";

    if (mysqli_query($conn, $insert_query)) {
        // Send email notification to admin
        $admin_email = ADMIN_EMAIL;
        $subject_admin = "New Contact Message - Tameer-e-Nau Public School";

        $message_admin = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #78864F; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; }
                .info-table td { padding: 12px; border-bottom: 1px solid #ddd; }
                .info-table td:first-child { font-weight: bold; width: 150px; background: #f0f0f0; }
                .footer { background: #333; color: white; padding: 15px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>New Contact Message Received</h2>
            </div>
            <div class='content'>
                <p>Someone has sent a message through your website contact form:</p>

                <table class='info-table'>
                    <tr>
                        <td>Name:</td>
                        <td>" . htmlspecialchars($name) . "</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>" . htmlspecialchars($email) . "</td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>" . htmlspecialchars($phone) . "</td>
                    </tr>
                    <tr>
                        <td>Subject:</td>
                        <td><strong>" . htmlspecialchars($subject) . "</strong></td>
                    </tr>
                    <tr>
                        <td>Message:</td>
                        <td>" . nl2br(htmlspecialchars($message)) . "</td>
                    </tr>
                    <tr>
                        <td>Date/Time:</td>
                        <td>" . date('d M Y, h:i A') . "</td>
                    </tr>
                </table>

                <p style='background: #d4edda; padding: 15px; border-left: 4px solid #28a745;'>
                    <strong>💡 Quick Action:</strong> Reply to <a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a> or call " . htmlspecialchars($phone) . "
                </p>
            </div>
            <div class='footer'>
                <p>Tameer-e-Nau Public School - Contact Form Notification</p>
                <p>Check your admin panel for more details.</p>
            </div>
        </body>
        </html>
        ";

        $headers_admin = "MIME-Version: 1.0" . "\r\n";
        $headers_admin .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers_admin .= "From: Tameer-e-Nau Public School <noreply@" . preg_replace('/^www\./', '', $_SERVER['HTTP_HOST'] ?? 'localhost') . ">" . "\r\n";
        $headers_admin .= "Reply-To: " . $email . "\r\n";

        mail($admin_email, $subject_admin, $message_admin, $headers_admin);

        // Send confirmation email to sender
        $subject_sender = "Thank You for Contacting Tameer-e-Nau Public School";

        $message_sender = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background: #78864F; color: white; padding: 30px; text-align: center; }
                .content { padding: 30px; background: #f9f9f9; }
                .highlight { background: #d4edda; padding: 20px; border-left: 4px solid #28a745; margin: 20px 0; }
                .footer { background: #333; color: white; padding: 20px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>Tameer-e-Nau Public School</h1>
                <p style='font-size: 18px; margin: 10px 0 0 0;'>Canal View, Hasilpur</p>
            </div>
            <div class='content'>
                <h2 style='color: #78864F;'>Dear " . htmlspecialchars($name) . ",</h2>

                <p style='font-size: 16px;'>Thank you for reaching out to us!</p>

                <div class='highlight'>
                    <p style='margin: 0; font-size: 16px;'><strong>✓ We have received your message successfully!</strong></p>
                </div>

                <p>Your message regarding \"<strong>" . htmlspecialchars($subject) . "</strong>\" has been received by our team.</p>

                <p>We appreciate you taking the time to contact Tameer-e-Nau Public School. Our team will review your message and get back to you within <strong>24-48 hours</strong>.</p>

                <div style='background: white; padding: 20px; margin: 20px 0; border-radius: 5px;'>
                    <h3 style='color: #78864F; margin-top: 0;'>Need Immediate Assistance?</h3>
                    <p style='margin: 5px 0;'><strong>📞 Call us:</strong> " . getSitePhone() . "</p>
                    <p style='margin: 5px 0;'><strong>📧 Email:</strong> " . getSiteEmail() . "</p>
                    <p style='margin: 5px 0;'><strong>📍 Address:</strong> Canal View, Hasilpur</p>
                    <p style='margin: 5px 0;'><strong>⏰ Office Hours:</strong> Monday - Saturday, 8:00 AM - 5:00 PM</p>
                </div>

                <p style='font-size: 16px; margin-top: 30px;'>
                    <strong>Best Regards,</strong><br>
                    Tameer-e-Nau Public School Team
                </p>
            </div>
            <div class='footer'>
                <p>Tameer-e-Nau Public School - Quality Education for a Bright Future</p>
                <p style='margin: 10px 0 0 0;'>This is an automated confirmation. Please do not reply to this email.</p>
            </div>
        </body>
        </html>
        ";

        $headers_sender = "MIME-Version: 1.0" . "\r\n";
        $headers_sender .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers_sender .= "From: Tameer-e-Nau Public School <noreply@" . preg_replace('/^www\./', '', $_SERVER['HTTP_HOST'] ?? 'localhost') . ">" . "\r\n";
        $headers_sender .= "Reply-To: " . getSiteEmail() . "" . "\r\n";

        mail($email, $subject_sender, $message_sender, $headers_sender);

        $success_message = "Thank you for contacting us! A confirmation email has been sent to your email address. We will get back to you soon.";
    } else {
        $error_message = "Error sending message. Please try again.";
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<?php renderPageBanner('contact'); ?>

<!-- Contact Info Cards -->
<section class="bg-light">
    <div class="container">
        <div class="card-grid">
            <div class="card" style="text-align: center;">
                <div class="card-icon" style="margin: 0 auto 20px;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <p>Tameer-e-Nau Public School<br>Canal View, Hasilpur<br>Pakistan</p>
            </div>

            <div class="card" style="text-align: center;">
                <div class="card-icon" style="margin: 0 auto 20px;">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Call Us</h3>
                <p><a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9+]/', '', getSitePhone())); ?>"><?php echo htmlspecialchars(getSitePhone()); ?></a><br>
                Mon - Sat: 8:00 AM - 5:00 PM</p>
            </div>

            <div class="card" style="text-align: center;">
                <div class="card-icon" style="margin: 0 auto 20px;">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <p><a href="mailto:<?php echo htmlspecialchars(getSiteEmail()); ?>"><?php echo htmlspecialchars(getSiteEmail()); ?></a><br>
                We reply within 24 hours</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Map -->
<section>
    <div class="container">
        <div class="grid-2 reveal" style="align-items: start;">
            <!-- Contact Form -->
            <div>
                <span class="eyebrow">Contact Form</span>
                <h2 style="color: var(--ink); margin-bottom: 20px;">Send us a Message</h2>

                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo $success_message; ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?php echo $error_message; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" id="contactForm" onsubmit="return validateForm('contactForm')">
                    <div class="grid-2" style="gap: 20px; align-items: start;">
                        <div class="form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Enter your name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                        </div>
                    </div>

                    <div class="grid-2" style="gap: 20px; align-items: start;">
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required placeholder="03001234567">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">-- Select Subject --</option>
                                <option value="Admission Inquiry">Admission Inquiry</option>
                                <option value="Course Information">Course Information</option>
                                <option value="Fee Inquiry">Fee Inquiry</option>
                                <option value="General Question">General Question</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Complaint">Complaint</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" required placeholder="Write your message here..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

            <!-- Google Map & Additional Info -->
            <div>
                <span class="eyebrow">Our Location</span>
                <h2 style="color: var(--ink); margin-bottom: 20px;">Find Us Here</h2>

                <!-- Google Map -->
                <div style="border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 30px; height: 400px; border: 2px solid var(--border-color); box-shadow: var(--shadow-sm);">
                    <iframe src="https://maps.google.com/maps?width=600&height=400&hl=en&q=<?php echo rawurlencode(content('contact_map_query')); ?>&t=&z=14&ie=UTF8&iwloc=B&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <!-- Working Hours -->
                <div class="card">
                    <h3 style="color: var(--primary-color); margin-bottom: 20px;"><i class="fas fa-clock"></i> Working Hours</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                            <span style="display: flex; align-items: center; gap: 10px; font-weight: 600;"><i class="fas fa-calendar-day" style="color: var(--primary-color); width: 18px; text-align: center;"></i> Monday - Friday</span>
                            <span>8:00 AM - 5:00 PM</span>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                            <span style="display: flex; align-items: center; gap: 10px; font-weight: 600;"><i class="fas fa-calendar-day" style="color: var(--primary-color); width: 18px; text-align: center;"></i> Saturday</span>
                            <span>9:00 AM - 3:00 PM</span>
                        </li>
                        <li style="padding: 10px 0; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                            <span style="display: flex; align-items: center; gap: 10px; font-weight: 600;"><i class="fas fa-calendar-times" style="color: #dc3545; width: 18px; text-align: center;"></i> Sunday</span>
                            <span style="color: #dc3545; font-weight: 600;">Closed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="bg-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">FAQs</span>
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions</p>
        </div>

        <div class="faq-list">
            <?php
            $faqs_result = mysqli_query($conn, "SELECT DISTINCT * FROM faqs WHERE status = 'active' ORDER BY display_order ASC, id ASC");
            if ($faqs_result) {
                while ($faq = mysqli_fetch_assoc($faqs_result)) {
                    echo '<div class="faq-item">';
                    echo '<button type="button" class="faq-question"><span>' . htmlspecialchars($faq['question']) . '</span><i class="fas fa-chevron-down"></i></button>';
                    echo '<div class="faq-answer"><p>' . nl2br(htmlspecialchars($faq['answer'])) . '</p></div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
