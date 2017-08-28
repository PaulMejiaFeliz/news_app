<?php if ($owner) : ?>
    <a class='btn btn-sm btn-warning' href="/editPost?id=<?= $post['id'] ?? "" ?>">Edit Post</a>
    <a class='btn btn-sm btn-danger' href="/deletePost?id=<?= $post['id'] ?? "" ?>">Delete Post</a>
<?php endif; ?>
<h5> Views: <?= $post['views'] ?? "" ?></h5>
<h5><?= $post['updated_at'] ?? "" ?>
<h1><?= $post['title'] ?? "" ?></h1>
<h5><?= $post['user']['name'] ?? "" ?> <?= $post['user']['lastName'] ?? "" ?><h5>
<p><?= $post['content'] ?? "" ?></p>