<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('main');
?>

<?php startblock('title') ?>
Set new password
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="row">
    <form class="col-md-8 col-lg-6 mx-auto" action="" method="POST">
        <h2 class="form-title">Set new password</h2>

        <div class="form-group">
            <label for="new_password">New password:</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="form-group">
            <label for="new_password_c">Confirm new password:</label>
            <input type="password" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Set new password</button>
        </div>
    </form>
</div>
<?php endblock() ?>