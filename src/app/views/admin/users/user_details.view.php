<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('base');
?>

<?php startblock('title') ?>
User Details
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="card">
    <div class="card-header">
        User Object
    </div>
    <div class="card-body">
        <h5 class="card-title">Username: <?= $user->username ?></h5>
        <h6 class="card-subtitle mb-2 text-muted">Type: <?= ucfirst(strtolower($user->type)) ?></h6>
        <div class="pt-2">
            <a href="/admin/users/<?= $user->id ?>/update" class="btn btn-warning">Edit</a>
            <a href="/admin/users/<?= $user->id ?>/delete" class="btn btn-danger">Delete</a>
        </div>
    </div>
</div>
<?php endblock() ?>