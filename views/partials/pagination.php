<?php
    $prevDisabled = $paginationConfig['current'] == 1 ? "disabled" : "";
    $nextDisabled = $paginationConfig['current'] == ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) ? "disabled" : "";
    $paginationConfig['linksCount'] = floor(5/2);
?>

<a href='/?page=1' class="btn btn-default <?= $prevDisabled ?>">
    <<
</a>

<a href='/?page=<?= $paginationConfig['current'] - 1 ?>' class="btn btn-default <?= $prevDisabled ?>">
    <
</a>
<?php if ($paginationConfig['current'] > $paginationConfig['linksCount'] && $paginationConfig['current'] < ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) - $paginationConfig['linksCount'] + 1) : ?>
    <?php for ($i = $paginationConfig['current'] - $paginationConfig['linksCount']; $i < $paginationConfig['current'] + $paginationConfig['linksCount'] + 1; $i++) : ?>
        <?php $btnDisabled = ($i == $paginationConfig['current']) ? "disabled" : ""; ?>
        <a href='/?page=<?= $i ?>' class="btn btn-default <?= $btnDisabled ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
<?php elseif($paginationConfig['current'] <= ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) - $paginationConfig['linksCount']) : ?>
    <?php for ($i = 1; $i <= ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) && $i <=  $paginationConfig['linksCount'] * 2 + 1; $i++) : ?>
        <?php $btnDisabled = ($i == $paginationConfig['current']) ? "disabled" : ""; ?>
        <a href='/?page=<?= $i ?>' class="btn btn-default <?= $btnDisabled ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
<?php else : ?>
    <?php for ($i = (ceil($paginationConfig['count'] / $paginationConfig['countPerPage'])  > $paginationConfig['linksCount'] * 2 + 1) ?  ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) - $paginationConfig['linksCount'] * 2 : 1; $i <= ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) ; $i++) : ?>
        <?php $btnDisabled = ($i == $paginationConfig['current']) ? "disabled" : ""; ?>
        <a href='/?page=<?= $i ?>' class="btn btn-default <?= $btnDisabled ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
<?php endif; ?>

<a href='/?page=<?= $paginationConfig['current'] + 1 ?>' class="btn btn-default <?= $nextDisabled ?>">
    >
</a>

<a href='/?page=<?= ceil($paginationConfig['count'] / $paginationConfig['countPerPage']) ?>' class="btn btn-default <?= $nextDisabled ?>">
    >>
</a>