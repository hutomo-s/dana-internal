<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Users<?= $this->endSection() ?>

<?= $this->section('header_content') ?>
<a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-primary">Add New User</a>
<?= $this->endSection() ?>