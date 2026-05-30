<?php
include_once ('header.php');
?>
<section class="py-5 bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus"></i> <?=$lang['register_title']?></h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger mb-4">
                                <?php
                                if ($_GET['error'] == 'fill') echo $lang['register_error_fill'];
                                elseif ($_GET['error'] == 'pass') echo $lang['register_error_pass'];
                                elseif ($_GET['error'] == 'email') echo $lang['register_error_email'];
                                elseif ($_GET['error'] == 'passlen') echo $lang['register_error_passlen'];
                                else echo "Помилка реєстрації.";
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="user-check.php" method="POST">
                            <input type="hidden" name="action" value="register">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="full_name"><?=$lang['full_name']?> *</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="email"><?=$lang['email']?> *</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="phone"><?=$lang['phone']?></label>
                                <input type="tel" name="phone" id="phone" class="form-control">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="password"><?=$lang['password']?> *</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <div class="form-text small">Мінімум 6 символів</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="password_confirm"><?=$lang['password_confirm']?> *</label>
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                            </div>
                            
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold"><?=$lang['register_btn']?></button>
                            </div>
                            
                            <div class="text-center">
                                <span class="text-muted"><?=$lang['already_have_acc']?></span>
                                <a href="user-login.php" class="text-decoration-none fw-bold"><?=$lang['login_link']?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php'); ?>
