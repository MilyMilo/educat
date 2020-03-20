<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('main');
?>

<?php startblock('title') ?>
Password reset
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="row">
    <form class="col-md-8 col-lg-6 mx-auto" action="/pending" method="POST">
        <h2 class="form-title">Forgot your password?</h2>

        <div class="form-group">
            <label for="email">Your email:</label>
            <input type="text" class="form-control" name="email">
        </div>

        <div class="form-group">
            <button type="submit" name="reset_password" class="btn btn-success">Send new password</button>
        </div>
    </form>
</div>
<?php endblock() ?>