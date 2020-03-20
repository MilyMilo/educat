<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('main');
?>
<?php startblock('title') ?>
<?= $user->username ?> Details
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="card">
    <div class="card-header">
        Profile details
    </div>
    <div class="card-body">
        <h5 class="card-title">Username: <?= $user->username ?></h5>
        <h6 class="card-subtitle pt-3">First Name: <?= $user->first_name ?></h6>
        <h6 class="card-subtitle pt-3">Last Name: <?= $user->last_name ?></h6>
        <h6 class="card-subtitle pt-3 pb-5">E-mail: <?= $user->email ?></h6>
        <h6 class="card-subtitle pt-3">Profile picture:</h6>
        <img class="profile-picture" src="/public/uploads/avatars/<?= $user->id ?>">
        <div class="pt-3">
            <a href="/profile/update" class="btn btn-warning">Edit</a>
        </div>
    </div>

</div>

<?php endblock() ?>