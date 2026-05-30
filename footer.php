<!-- Footer-->
<footer class="py-5 bg-dark mt-5 text-white">
    <div class="container">
        <div class="row g-4 text-center text-md-start">
            <!-- Column 1: Brand & Socials -->
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold text-primary mb-3"><?=$lang['footer_brand']?></h5>
                <p class="small text-white-50 mb-3" style="line-height: 1.6;"><?=$lang['footer_desc']?></p>
            </div>
            
            <!-- Column 2: Contacts -->
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold text-white text-uppercase mb-3" style="letter-spacing: 1px;"><?=$lang['footer_contacts']?></h6>
                <p class="small mb-2"><strong class="text-primary"><?=$lang['footer_reception']?></strong> <span class="text-white-50">+38 (044) 123-45-67</span></p>
                <p class="small mb-2"><strong class="text-primary"><?=$lang['footer_head_doc']?></strong> <span class="text-white-50">+38 (067) 123-45-01 (Олександр Васильович)</span></p>
                <p class="small mb-2"><strong class="text-primary"><?=$lang['footer_email']?></strong> <span class="text-white-50">info@clinic.ua</span></p>
                <p class="small mb-0"><strong class="text-primary"><?=$lang['footer_address']?></strong> <span class="text-white-50">м. Київ, вул. Михайла Грушевського, 10</span></p>
            </div>
            
            <!-- Column 3: Schedule & Info -->
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold text-white text-uppercase mb-3" style="letter-spacing: 1px;"><?=$lang['footer_schedule']?></h6>
                <p class="small text-white-50 mb-2">📅 <strong><?=$lang['mon_fri']?>:</strong> 08:00 – 20:00</p>
                <p class="small text-white-50 mb-3">📅 <strong><?=$lang['sat']?>:</strong> 09:00 – 15:00</p>
                <div class="alert alert-danger py-2 px-3 mb-0 small text-center" role="alert" style="background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #f87171;">
                    <strong><?=$lang['footer_emergency']?></strong> +38 (044) 123-45-03
                </div>
            </div>
        </div>
        <hr class="border-secondary my-4" />
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="m-0 text-white-50 small"><?=$lang['footer_copyright']?> <?php echo date('Y')?> <?=$lang['footer_rights']?></p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <a href="#" class="text-decoration-none text-white-50 small me-3 hover-primary"><?=$lang['footer_terms']?></a>
                <a href="#" class="text-decoration-none text-white-50 small hover-primary"><?=$lang['footer_privacy']?></a>
            </div>
        </div>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>