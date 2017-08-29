<div class='row'>
    <div class="col-md-offset-1">
        <h1>My News</h1>
        <form action="/myPosts" method="get" class="form-inline">
            <div class="form-group input-group">
                <span class="input-group-addon">Search By</span>
                <select name="searchBy" class="form-control" required >
                    <?php foreach ($searchFields as $key => $field) : ?>
                        <option value="<?= $key ?>" <?= ($_GET["searchBy"] ?? 0) == $key ? "selected='selected'" : "" ?> ><?= $field ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group input-group">
                <span class="input-group-addon">Value</span>
                <input class="form-control" type="text" name="value" required value='<?= $_GET["value"] ?? "" ?>'>
            </div>
            <input class='btn btn-primary' type="submit" value='Search'/>
            <a class='btn btn-default' href="/myPosts">Clear</a>
        </form>
    </div>
    </br>
    <div class='row'>
        <div class="col-md-10 col-md-offset-1">
            <?php if (isset($news)) : ?>
                <?php foreach($news as $new) : ?>
                <div class="col-md-10 col-md-offset-1">
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
                <?php if (count($news) == 0) : ?>
                    <h3>No news to show you rigth now.</h3>
                <?php endif; ?>               
            <?php else : ?>
                <h3>No news to show you rigth now.</h3>
            <?php endif; ?>
        </div>
    </div>
</div>