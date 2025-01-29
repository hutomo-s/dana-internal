<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Exception Papers - Waiting My Approval<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if(empty($ep_list)): ?>
    <h5>No pending exception paper</h5>
<?php endif; ?>

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
                    <td><?= $ep->requestor_id ?></td>
                    <td><?= $ep->request_cost_currency ?> <?= $ep->request_cost_amount ?></td>
                    <td><?= $ep->created_at ?></td>
                    <td><?= $ep->request_due_date ?></td>
                    <td><?= $ep->exception_status ?></td>
                    <td>
                        View <?= $ep->id ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?= $this->endSection() ?>