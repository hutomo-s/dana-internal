<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Exception Papers<?= $this->endSection() ?>

<?= $this->section('header_content') ?>
<a href="<?= base_url('dashboard/exception-papers/create') ?>" class="btn btn-primary">Add New Exception Paper</a>
<?= $this->endSection() ?>