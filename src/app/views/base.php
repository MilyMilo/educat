<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php startblock('title') ?><?php endblock() ?> | Educat</title>

  <?php require('partials/styles.php') ?>
  <?php startblock('styles') ?><?php endblock() ?>
</head>


<body>
  <?php require('partials/nav.php') ?>

  <div class="container mt-4">
    <?php startblock('content') ?><?php endblock() ?>
  </div>

  <?php require('partials/scripts.php') ?>
  <?php startblock('scripts') ?><?php endblock() ?>
</body>

</html>