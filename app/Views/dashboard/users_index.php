<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Users<?= $this->endSection() ?>

<?= $this->section('header_content') ?>
<a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-primary">Add New User</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Display Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Department</th>
                    <th scope="col">Account Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <th scope="row"><?= $user->user_email ?></th>
                    <td>
                        <?= $user->display_name ?>
                        <br />
                        <?php if($user->signature_image_fullpath): ?>
                            <img src="<?= $user->signature_image_fullpath ?>">
                        <?php endif ?>
                    </td>
                    <td><?= $user->role_name ?></td>
                    <td><?= $user->department_name ?></td>
                    <td>
                        <?php if($user->is_active): ?>
                            <span class="badge bg-primary">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>