<?php
include_once ('header.php');

$post_id = $_GET['post_id'];
if (!is_numeric($post_id)) exit();
$post = get_news_by_id($post_id);
?>
<section class="new">
    <div class="container">
        <div class="row">
            <div class="col-10">
                <div class="card-body mt-4">
                    <img class="card-img-top" src="<?=$post['image']?>" alt="..." />
                    <div class="small text-muted"><?=$post['datetime']=date('d.m.Y', strtotime($post['datetime']));?></div>
                    <h2 class="card-title h4"><?=$post['title']?></h2>
                    <p class="card-text"><?=$post['content']?></p>
                    <a class="btn btn-success" href="index.php">Повернутися назад</a>
                </div>
            </div>
        </div>
    </div>
</section>
