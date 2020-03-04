<?php inherit('base.php') ?>

<?php startblock('title') ?>
Admin Dashboard
<?php endblock() ?>

<?php startblock('content') ?>
<?php partial('flash') ?>
<h1>Welcome to EduCat</h1>
<h3>Applications:</h3>
<ul class="list-group">
    <a href="/admin/users" class="list-group-item">Users</a>
</ul>
<?php endblock() ?>