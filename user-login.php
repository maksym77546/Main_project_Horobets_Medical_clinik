<?php
include_once ('header.php');

// Redirect if already logged in
if (is_user_logged_in()) {
    header('Location: user-profile.php');
    exit();
}
?>
<section class="py-5 bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-box-arrow-in-right"></i> <?=$lang['login_title']?></h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
                            <div class="alert alert-success mb-4"><?=$lang['register_success']?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                            <div class="alert alert-danger mb-4"><?=$lang['login_error']?></div>
                        <?php endif; ?>
                        
                        <form action="user-check.php" method="POST">
                            <input type="hidden" name="action" value="login">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="email"><?=$lang['email']?></label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="password"><?=$lang['password']?></label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                            </div>
                            
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold"><?=$lang['login_btn']?></button>
                            </div>
                            
                            <div class="text-center">
                                <span class="text-muted"><?=$lang['no_account']?></span>
                                <a href="register.php" class="text-decoration-none fw-bold"><?=$lang['register_link']?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
