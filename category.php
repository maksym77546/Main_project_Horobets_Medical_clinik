<?php
 include_once ('header.php');
 ?>
<section class="category">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <?php
                    $category_id = $_GET['category_id'];
                    $new = get_new_by_category($category_id);
                    $category = get_category_title($category_id);
                    ?>
                <h2 class="mt-4"><?=$category['title']?></h2>
                <hr>
                <?php foreach ($new as $item):?>
                <div class="card-body mt-4">
                    <img class="card-img-top" src="<?=$item['image']?>" alt="..." />
                    <div class="small text-muted"><?=$item['datetime']=date('d.m.Y', strtotime($item['datetime']));?></div>
                    <h2 class="card-title h4"><?=$item['title']?></h2>
                    <p class="card-text"><?=mb_substr($item['content'],0,150,'utf-8').'...'?></p>
                    <a class="btn btn-success" href="index.php">Більше -></a>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</section>
