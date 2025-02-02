<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Exception Paper<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if($is_need_my_approval === true): ?>
<div class="alert alert-warning" role="alert">
    This Exception Paper need your approval.
</div>
<?php endif ?>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th style="width: 250px;">Date of Request</th>
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
                    <td colspan="2">
                        <ul>
                        <?php foreach($ep_attachments_reason as $epar): ?>
                            <li>
                                <a href="<?= base_url($epar->attachment_fullpath) ?>" target="_blank">
                                    <?= $epar->attachment_fullpath ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </td>
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
                    <td colspan="2">
                        <ul>
                        <?php foreach($ep_attachments_impact as $epai): ?>
                            <li>
                                <a href="<?= base_url($epai->attachment_fullpath) ?>" target="_blank">
                                    <?= $epai->attachment_fullpath ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Due Date for the ordering confirmation</th>
                    <td><?= $ep_data->request_due_date ?></td>
                </tr>
                <tr>
                    <th>Cost to proceed the order</th>
                    <td><?= $ep_data->request_cost_currency ?> <?= number_format($ep_data->request_cost_amount, 2, '.', ',') ?></td>
                </tr>
                <tr>
                    <th>Requestor Name</th>
                    <td><?= $ep_data->display_name ?> &lt;<?php echo $ep_data->user_email; ?>&gt;</td>
                </tr>
                <tr>
                    <th>Line Manager</th>
                    <td><?= $line_manager->display_name ?> &lt;<?php echo $line_manager->user_email; ?>&gt;</td>
                </tr>
                <tr>
                    <th>Exception Paper Status</th>
                    <td><?= get_ep_status_by_id($ep_data->exception_status) ?></td>
                </tr>
                <tr>
                    <th>Generated PDF (If Submitted to Procurement)</th>
                    <td>
                        <?php if($ep_data->generated_pdf_fullpath): ?>
                            <a href="<?= base_url(($ep_data->generated_pdf_fullpath)) ?>" target="_blank">Download PDF</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div>
<?php if($is_need_my_approval === true): ?>
<form id="ep-submit-approval" action="<?= $submit_approval_url ?>" method="POST">
    <input type="hidden" name="ep_id" value="<?= $ep_data->id ?>">
    <button type="submit" class="btn btn-primary">Approve</button>
</form>
<?php endif ?>
</div>

<div class="pt-3">
    <a href="<?= base_url('dashboard/exception-papers') ?>">
       <i class="fas fa-long-arrow-alt-left"></i> Back to All Exception Papers
    </a>
</div>

<div class="modal fade" id="modal-default" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="modal-default-body"></div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?= $this->endSection() ?>

<?= $this->section('script_tags') ?>
<script src="<?= base_url("assets/js/ep_show.js?v=".ASSET_VERSION) ?>"></script>
<?= $this->endSection() ?>