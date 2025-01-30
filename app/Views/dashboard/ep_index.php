<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('stylesheet_tags') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Exception Papers<?= $this->endSection() ?>

<?= $this->section('header_content') ?>
<a href="<?= base_url('dashboard/exception-papers/create') ?>" class="btn btn-primary">Add New Exception Paper</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body table-responsive p-0">
        <table id="ep_list" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Purchase Title</th>
                    <th scope="col">Requestor</th>
                    <th scope="col">Cost to Proceed</th>
                    <th scope="col">Date of Request</th>
                    <th scope="col">Due Date of Confirmation</th>
                    <th scope="col">Approval Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ep_list as $ep): ?>
                <tr>
                    <td>
                        <?= $ep->purchase_title ?>
                        <p>PR Number: <?= $ep->pr_number ?></p>
                    </td>
                    <td><?= $ep->display_name ?></td>
                    <td><?= $ep->request_cost_currency ?> <?= number_format($ep->request_cost_amount, 2, '.', ',') ?></td>
                    <td><?= $ep->created_at ?></td>
                    <td><?= $ep->request_due_date ?></td>
                    <td><?= get_ep_status_by_id($ep->exception_status) ?></td>
                    <td>
                        <a href="<?= base_url('dashboard/exception-papers/'.$ep->id) ?>">View</a>
                        <br />
                        <?php if($ep->generated_pdf_fullpath): ?>
                            <a href="<?= base_url(($ep->generated_pdf_fullpath)) ?>" target="_blank">Download PDF</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script_tags') ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url("assets/adminlte/plugins/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js") ?>"></script>
<script src="<?= base_url("assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js") ?>"></script>

<script src="<?= base_url("assets/js/ep_index.js?v=".ASSET_VERSION) ?>"></script>
<?= $this->endSection() ?>