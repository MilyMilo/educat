<?php inherit('base.php') ?>

<?php startblock('title') ?>
Home Page
<?php endblock() ?>

<?php startblock('content') ?>
<?php partial('flash') ?>
<h1>Welcome to EduCat</h1>
<h3>Please <a href="/login">Log In</a></h3>
<?php endblock() ?>