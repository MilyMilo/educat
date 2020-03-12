<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('main');
?>

<?php startblock('title') ?>
Login
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="row">
  <form class="col-md-8 col-lg-6 mx-auto" method="POST" action="/login">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-success btn-block">Log in</button>
  </form>
</div>
<?php endblock() ?>