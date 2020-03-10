<?php

use EduCat\Core\Templating\Renderer;

Renderer::inherit('admin_base');
?>

<?php startblock('title') ?>
User List
<?php endblock() ?>

<?php startblock('content') ?>
<?php Renderer::partial('flash') ?>
<div class="col">
    <table class="table table-striped table-responsive">
        <thead class="bg-primary text-white">
            <tr>
                <th class="text-left">Username</th>
                <th class="text-left">Password</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="table-hover">
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td class="text-left align-middle"><?= $user->username ?></td>
                    <td class="text-left align-middle"><?= $user->password ?></td>
                    <td class="text-center mx-auto">
                        <div class="btn-group">
                            <a href="/admin/users/<?= $user->id ?>" class="btn btn-sm btn-info">View</a>
                            <a href="/admin/users/<?= $user->id ?>/update" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/admin/users/<?= $user->id ?>/delete" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php endblock() ?>