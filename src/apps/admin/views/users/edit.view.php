<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('main');
?>
<?php startblock('title') ?>
<?= $user->username ?> Edit page
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="card">
    <div class="card-header">
        Here you can update your profile details
    </div>
    <div class="row">
        <form class="col-md-8 col-lg-6 p-4 mx-auto" method="POST" action="/profile/update" enctype="multipart/form-data">
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
                <label for="first_name">First name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user->first_name ?>">
            </div>
            <div class="form-group">
                <label for="email">Last name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user->last_name ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= $user->email ?>">
            </div>
            <div class="form-group custom-file">
                <label class="custom-file-label" for="profile_picture">Profile picture</label><br>
                <input type="file" class="custom-file-input" name="profile_picture">
            </div>

            <button type="submit" class="btn btn-success btn-block">Update profile</button>
        </form>
    </div>

</div>

<?php endblock() ?>