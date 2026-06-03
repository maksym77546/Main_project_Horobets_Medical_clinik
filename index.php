<?php
include_once ('header.php');
?>
<!-- Page header with logo and tagline-->
<header class="py-5 bg-light border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder"><?=$lang['site_name']?></h1>
            <p class="lead mb-0"><?=$lang['site_tagline']?></p>
        </div>
    </div>
</header>
<section class="doctors">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php 
                $search = trim($_GET['search'] ?? '');
                $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $limit = 6;
                $offset = ($page - 1) * $limit;
                
                $total_doctors = get_total_doctors($search);
                $total_pages = ceil($total_doctors / $limit);
                
                $doctors = get_doctors($search, $limit, $offset);
                ?>
                <h2 class="mb-4">
                    <?php if (!empty($search)): ?>
                        <?=$lang['search_results']?>: <span class="text-primary">"<?=htmlspecialchars($search)?>"</span>
                    <?php else: ?>
                        <?=$lang['our_doctors']?>
                    <?php endif; ?>
                </h2>
                <div class="row">
                    <?php if (empty($doctors)): ?>
                    <div class="col-12">
                        <div class="alert alert-info"><?=$lang['no_doctors_found']?></div>
                    </div>
                    <?php endif; ?>
                    <?php foreach ($doctors as $doctor):?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img class="card-img-top" src="<?=$doctor['image']?>" alt="<?=$doctor['doctor_name']?>" style="height: 250px; object-fit: cover; object-position: center top;" />
                            <div class="card-body d-flex flex-column">
                                <div class="small text-primary fw-bold mb-2"><?=$doctor['datetime']=date('d.m.Y', strtotime($doctor['datetime']));?></div>
                                <h3 class="card-title h5 fw-bolder"><?=$doctor['doctor_name']?></h3>
                                <p class="card-text text-muted flex-grow-1"><?=mb_substr($doctor['specialization'],0,150,'utf-8').(mb_strlen($doctor['specialization'])>150?'...':'')?></p>
                                <a class="btn btn-outline-primary mt-auto" href="post.php?post_id=<?=$doctor['id']?>"><?=$lang['details']?></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php
                        $search_query = !empty($search) ? '&search=' . urlencode($search) : '';
                        ?>
                        <li class="page-item <?=($page <= 1) ? 'disabled' : ''?>">
                            <a class="page-link" href="?page=<?=($page - 1)?><?=$search_query?>">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?=($page == $i) ? 'active' : ''?>">
                                <a class="page-link" href="?page=<?=$i?><?=$search_query?>"><?=$i?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?=($page >= $total_pages) ? 'disabled' : ''?>">
                            <a class="page-link" href="?page=<?=($page + 1)?><?=$search_query?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <!-- Search widget -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-primary text-white"><?=$lang['search']?></div>
                    <div class="card-body">
                        <form action="index.php" method="GET">
                            <div class="input-group">
                                <input class="form-control" type="text" name="search" placeholder="<?=$lang['search_placeholder']?>" aria-label="Search" aria-describedby="button-search" value="<?=htmlspecialchars($_GET['search'] ?? '')?>" />
                                <button class="btn btn-primary" id="button-search" type="submit"><?=$lang['search_btn']?></button>
                            </div>
                            <?php if (!empty($search)): ?>
                            <div class="text-end mt-2">
                                <a href="index.php" class="text-decoration-none small text-danger"><?=$lang['reset_search']?></a>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-primary text-white"><?=$lang['categories']?></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="list-unstyled mb-0">
                                    <?php $menus = get_menu();?>
                                    <?php foreach ($menus as $menu):?>
                                    <li class="mb-2"><a href="category.php?category_id=<?=$menu['id']?>" class="text-decoration-none text-dark hover-primary"><?=$menu['title']?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-primary text-white"><?=$lang['schedule_sidebar']?></div>
                    <div class="card-body">
                        <p class="mb-1"><?=$lang['individual_schedule']?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    require_once('footer.php');
?>