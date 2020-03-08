<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('base');
?>

<?php startblock('title') ?>
Home Page
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<?php
if ($user) {
    echo "<h1>Welcome to EduCat, " . $user->username . "!</h1>";
} else {
    echo "<h1>Welcome to EduCat!</h1>";
    echo '<h3>Please <a href="/login">Log In</a></h3>';
}
?>
<?php endblock() ?>