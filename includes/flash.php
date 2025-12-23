<?php if (isset($_SESSION['success_msg'])): ?>
    <div class="flash-message" id="flashMessage">
        <?php
        echo $_SESSION['success_msg'];
        unset($_SESSION['success_msg']); // Clear after showing
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_msg'])): ?>
    <div class="flash-message error" id="flashMessage">
        <?php
        echo $_SESSION['error_msg'];
        unset($_SESSION['error_msg']); // Clear after showing
        ?>
    </div>
<?php endif; ?>
