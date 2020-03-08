<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('base');
?>

<?php startblock('title') ?>
Delete User Form
<?php endblock() ?>

<?php startblock('content') ?>
<form class="col-md-8 col-lg-6 mx-auto" method="POST" action="/admin/users/<?= $user->id ?>/delete">
  <div class="row">
    <div class="form-group mx-auto">
      <label>Are you sure you want to delete this user?</label>
      <button type="submit" class="btn btn-danger btn-block">Delete user</button>
    </div>
</form>
</div>
<?php endblock() ?>