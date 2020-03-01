<?php include 'base.php' ?>

<?php startblock('title') ?>
404 - Not Found
<?php endblock() ?>

<?php startblock('content') ?>
<h1 class="font-weight-bolder">Error 404</h1>
<h2 class="text-danger">No route found for <?= $uri ?></h2>
<?php endblock() ?>
