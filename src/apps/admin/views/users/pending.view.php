<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('main');
?>

<?php startblock('title') ?>
Pending password reset
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="container text-center">
    <h3>We sent an email to <b><?= $u_email ?></b> to help you recover your account.</h3>

    <h4>Please login into your email account and click on the link we sent to reset your password</h4>
</div>
<?php endblock() ?>