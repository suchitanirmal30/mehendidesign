<?php if (isset($_GET['status'])): ?>
    <div class="status-message">
        <?php if ($_GET['status'] == 'success'): ?>
            <p style="color:green;">Your message has been sent successfully.</p>
        <?php elseif ($_GET['status'] == 'error'): ?>
            <p style="color:red;">There was an error sending your message. Please try again later.</p>
        <?php elseif ($_GET['status'] == 'validation_error' && isset($_GET['message'])): ?>
            <p style="color:red;"><?php echo htmlspecialchars(urldecode($_GET['message'])); ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
