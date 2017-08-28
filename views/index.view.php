<div class='row'>
    <div class="col-md-offset-1">
        <h1>News</h1>
    </div>
    <div class='row'>
        <div class="col-md-8">
            <?php if (isset($news)) : ?>
                <?php foreach($news as $new) : ?>
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Posted <?= $new['updated_at'] ?? "" ?> by <?= $new['user']['name'] ?? "" ?> <?= $new['user']['lastName'] ?? "" ?>
                        </div>
                        <div class="panel-body">
                            <h3><a href='/postDetails?id=<?= $new['id'] ?? "" ?>'><?= $new['title'] ?? "" ?></a></h3>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (count($news) == 0) : ?>
                    <div class="col-md-offset-1">
                        <h3>No news to show you rigth now.</h3>
                    </div>
                <?php endif; ?>               
            <?php else : ?>
                <div class="col-md-offset-1">
                    <h3>No news to show you rigth now.</h3>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3 col-md-offset-1">
        <h1>My News</h1>
            <?php if (isset($myNews)) : ?>
                <?php foreach($myNews as $new) : ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Posted <?= $new['updated_at'] ?? "" ?> by <?= $new['user']['name'] ?? "" ?> <?= $new['user']['lastName'] ?? "" ?>
                        </div>
                        <div class="panel-body">
                            <h3><a href='/postDetails?id=<?= $new['id'] ?? "" ?>'><?= $new['title'] ?? "" ?></a></h3>
                            <a class='btn btn-xs btn-warning' href="/editPost?id=<?= $new['id'] ?? "" ?>">Edit Post</a>
                            <a class='btn btn-xs btn-danger' href="/deletePost?id=<?= $new['id'] ?? "" ?>">Delete Post</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (count($myNews) == 0) : ?>
                    <h3>No news to show you rigth now.</h3>
                <?php endif; ?>               
            <?php else : ?>
                <h3>No news to show you rigth now.</h3>
            <?php endif; ?>
        </div>
    </div>
</div>

