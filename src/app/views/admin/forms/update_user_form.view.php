<?php

use EduCat\Core\Templating\Renderer;
use EduCat\Models\User;

Renderer::inherit('admin_base')
?>

<?php startblock('title') ?>
Update User Form
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="row">
  <form class="col-md-8 col-lg-6 mx-auto" method="POST" action="/admin/users/<?= $user->id ?>/update">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" value="<?= $user->username ?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="New password">
      <small id="password-help" class="form-text text-muted">
        Only updated if you input something.
      </small>
    </div>
    <div class="form-group">
      <label for="type">Type</label>
      <select id="type" name="type" class="custom-select">
        <?php foreach (User::$allowed_types as $i => $type) : ?>
          <option value="<?= $type ?>"><?= ucfirst(strtolower($type)) ?></option>
        <?php endforeach ?>
      </select>
    </div>

    <button type="submit" class="btn btn-success btn-block">Save User</button>
  </form>
</div>
<?php endblock() ?>