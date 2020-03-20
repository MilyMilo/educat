<?php

use EduCat\Core\Templating\Renderer;
use EduCat\Models\User;

Renderer::inherit('admin')
?>

<?php startblock('title') ?>
Create User Form
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="row">
    <form class="col-md-8 col-lg-6 mx-auto" method="POST" action="/admin/users/create">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="first_name">First name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name">
        </div>
        <div class="form-group">
            <label for="last_name">Last name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="username@example.com">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <p class="text-muted">Password must contain at least:</p>
            <ul class="text-muted">
                <li>8 characters</li>
                <li>1 uppercase letter</li>
                <li>1 lowercase letter</li>
                <li>1 number</li>
                <li>1 special character (#$%&'()*+,-./:;<=>?@[\]^_`{|}~")</li>
            </ul>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select id="type" name="type" class="custom-select">
                <?php foreach (User::$allowed_types as $i => $type) : ?>
                    <option value="<?= $type ?>"><?= ucfirst(strtolower($type)) ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success btn-block">Create User</button>
    </form>
</div>
<?php endblock() ?>