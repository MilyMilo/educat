<?php

use EduCat\Core\Templating\Renderer;
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $title ?> | Educat</title>
  <meta name="description" content="<?= $description ?>">
  <meta name="keywords" content="<?= $keywords ?>">
  <link rel="stylesheet" href="/static/css/user.css">
  <?php Renderer::partial('styles') ?>
  <?php startblock('styles') ?><?php endblock() ?>
</head>


<body>
  <?php Renderer::partial('nav') ?>

  <div class="container mt-4">
    <?php startblock('content') ?><?php endblock() ?>
  </div>

  <?php Renderer::partial('scripts') ?>
  <?php startblock('scripts') ?><?php endblock() ?>
</body>

</html>