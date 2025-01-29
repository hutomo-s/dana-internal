<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Exception Paper<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4></h4>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Date of Request</th>
                    <td><?= $ep_data->created_at ?></td>
                </tr>
                <tr>
                    <th>Purchase Title</th>
                    <td><?= $ep_data->purchase_title ?></td>
                </tr>
                <tr>
                    <th>PR Number</th>
                    <td><?= $ep_data->pr_number ?></td>
                </tr>
                <tr>
                    <th colspan="2">The reason for not following tender/pitching process</th>
                </tr>
                <tr>
                    <td colspan="2"><?= $ep_data->exception_reason ?></td>
                </tr>
                <tr>
                    <th colspan="2">Attachment(s)</th>
                </tr>
                <tr>
                    <th colspan="2">Impact to DANA as Organization if we are failed to perform the agreement as soon as possible</th>
                </tr>
                <tr>
                    <td colspan="2"><?= $ep_data->exception_impact ?></td>
                </tr>
                <tr>
                    <th colspan="2">Attachment(s)</th>
                </tr>
                <tr>
                    <th>Due Date for the ordering confirmation</th>
                    <td><?= $ep_data->request_due_date ?></td>
                </tr>
                <tr>
                    <th>Cost to proceed the order</th>
                    <td><?= $ep_data->request_cost_currency ?> <?= $ep_data->request_cost_amount ?></td>
                </tr>
                <tr>
                    <th>Exception Paper Status</th>
                    <td><?= $ep_data->exception_status ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>