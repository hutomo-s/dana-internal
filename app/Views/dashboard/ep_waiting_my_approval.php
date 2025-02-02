<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Exception Papers - Waiting My Approval<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if(empty($ep_list)): ?>
    <h5>No pending exception paper</h5>
<?php else: ?>
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
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
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>