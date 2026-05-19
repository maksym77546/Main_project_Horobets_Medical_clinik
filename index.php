<?php
include_once ('header.php');
?>
<!-- Page header with logo and tagline-->
<header class="py-5 bg-light border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder">Вітаємо на нашому сайті блозі!</h1>
            <p class="lead mb-0">Цей блог про IT сферу</p>
        </div>
    </div>
</header>
<section class="news">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2>Всі новини</h2>
                <!-- Blog post-->
                <?php $news = get_news()?>
                <?php foreach ($news as $new):?>
                <div class="card mb-4">
                    <a href="#!"><img class="card-img-top" src="<?=$new['image']?>" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted"><?=$new['datetime']=date('d.m.Y', strtotime($new['datetime']));?></div>
                        <h2 class="card-title h4"><?=$new['title']?></h2>
                        <p class="card-text"><?=mb_substr($new['content'],0,150,'utf-8').'...'?></p>
                        <a class="btn btn-primary" href="post.php?post_id=<?=$new['id']?>">Більше →</a>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <div class="col-lg-4">
                <h2>Віджети</h2>
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">Web Design</a></li>
                                    <li><a href="#!">HTML</a></li>
                                    <li><a href="#!">Freebies</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">JavaScript</a></li>
                                    <li><a href="#!">CSS</a></li>
                                    <li><a href="#!">Tutorials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php
    require_once('footer.php');
?>