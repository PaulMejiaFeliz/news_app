<div class='row'>
        <div class='col-md-offset-2 col-md-8'>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class='row'>
                        <?php if ($owner) : ?>
                        <div class='col-md-12'>
                            <a class='btn btn-sm btn-warning' href="/editPost?id=<?= $post['id'] ?? "" ?>">Edit Post</a>
                            <a class='btn btn-sm btn-danger' href="/deletePost?id=<?= $post['id'] ?? "" ?>">Delete Post</a>
                        </div>
                        <?php endif; ?>
                        <div class='col-md-7'>
                            <h5>
                                Posted at <?= $post['updated_at'] ?? "" ?> by
                                <?= $post['user']['name'] ?? "" ?> <?= $post['user']['lastName'] ?? "" ?>
                            </h5>
                        </div>
                        <div class='col-md-5'>
                            <h5 class='text-right'> Views Count: <?= $post['views'] ?? "" ?></h5>
                        </div>
                        <div class='col-md-12'>
                            <h1><?= $post['title'] ?? "" ?></h1>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <p><?= $post['content'] ?? "" ?></p>
                </div>
                <div class="panel-footer">
                    <h3>Comments</h3>
                    <form action="/addComment" method="post" class='form-inline'>
                        <input type="hidden" name="newId" value="<?= $post['id'] ?? "" ?>">
                        <div class="input-group">
                            <span class="input-group-addon">New Comment</span>
                            <textarea cols="60" rows="3" class="form-control" type="text" name="content" required></textarea>
                        </div>
                            <input type="submit" class='btn btn-primary' value="Publish">
                    </form>
                    <br/>
                    <div class='row'>
                        <?php foreach ($comments as $comment) : ?>
                        <div class='col-md-offset-1 col-md-10'>
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                    <div class='row'>
                                        <div class='col-md-7'>
                                            <h5>
                                                <?= $comment['user']['name'] ?? "" ?> <?= $comment['user']['lastName'] ?? "" ?>
                                                -
                                                <?= $comment['updated_at'] ?? "" ?>
                                            </h5>
                                        </div>
                                        <?php if ($comment['owner']) : ?>
                                        <div class='col-md-5 text-right'>
                                            <div class='col-md-8'>
                                                <button onClick="fillForm(<?= $comment['id'] ?? "" ?>);" type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editCommentModal">Edit</button>
                                            </div>
                                            <form action="/deleteComment" method="post">
                                                <input name="_method" type="hidden" value="delete">
                                                <input name="commentId" type="hidden" value="<?= $comment['id'] ?? "" ?>"/>
                                                <input class='btn btn-sm btn-danger' type='submit' value='Delete'/>
                                            </form>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class='panel-body'>
                                    <div class='col-md-12'>
                                        <p id='commentContent<?= $comment['id'] ?? "" ?>'><?= $comment['content'] ?? "" ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editCommentModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Comment</h4>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col col-md-10 col-md-offset-1">
                        <form action="/editComment" method="post">
                            <input type="hidden" name="_method" value="patch">
                            <input id='formCommentId' type="hidden" name="commentId"/>
                            <div class="form-group input-group">
                                <textarea id='formCommentContent' cols="60" rows="3" class="form-control" type="text" name="content" required><?php $comment['content'] ?? "" ?></textarea>
                            </div>
                            <div class="text-center">
                                <input type="submit" class='btn btn-primary' value="Edit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="public/js/comment.js"></script>
