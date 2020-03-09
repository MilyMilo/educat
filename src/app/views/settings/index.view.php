<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('admin_base');
?>

<?php startblock('title') ?>
Edit settings
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="text-center">
    <h1>Settings</h1>
</div>
<div class="row">
    <form class="col-md-8 col-lg-6 mx-auto mb-5" method="POST" action="/admin/settings">
        <h4>Metadata</h4>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea type="text" class="form-control" id="description" name="description" required><?= $description ?></textarea>
        </div>
        <div class="form-group">
            <label for="keywords">Keywords (separated by comma)</label>
            <input type="text" class="form-control" id="keywords" name="keywords" value="<?= $keywords ?>" required>
        </div>

        <h4>Contact</h4>
        <div class="form-group">
            <label for="school_name">School name</label>
            <input type="text" class="form-control" id="school_name" name="school_name" value="<?= $school_name ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?= $city ?>" required>
        </div>
        <div class="form-group">
            <label for="postal_code">Postal code</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?= $postal_code ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $phone_number ?>" required>
        </div>

        <button type="submit" class="btn btn-success btn-block">Save</button>
    </form>
</div>
<?php endblock() ?>