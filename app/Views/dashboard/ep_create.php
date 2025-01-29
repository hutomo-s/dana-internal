<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('stylesheet_tags') ?>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Add New Exception Paper<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if(!empty($warning_message)): ?>
<div class="alert alert-warning" role="alert">
    <?= $warning_message ?>
</div>
<?php endif ?>

<form id="ep-create-form" method="POST" action="<?= $api_ep_store ?>" style="max-width: 550px;">
    <div class="form-group">
        <label>Date of Request *</label>
        <input type="text" class="form-control" name="created_at" autocomplete="off" value="<?= $date ?>" readonly>
        <small class="form-text text-muted">Date Format: YYYY-MM-DD</small>
    </div>

    <div class="form-group">
        <label>Purchase Title *</label>
        <input type="text" class="form-control" name="purchase_title" autocomplete="off">
    </div>

    <div class="form-group">
        <label>PR Number</label>
        <input type="text" class="form-control" name="pr_number" autocomplete="off">
    </div>

    <div class="form-group">
        <label>The reason for not following tender/pitching process *</label>
        <textarea class="form-control" rows="3" name="exception_reason"></textarea>
    </div>

    <div class="form-group">
        <label>Attachment(s)</label>

        <div id="reason_attachments">
            <div class="input-group mb-2">
                <div class="custom-file">
                    <input type="file" accept="*" class="custom-file-input" name="reason_file[]">
                    <label class="custom-file-label">Choose file</label>
                </div>
            </div>
        </div>
        
        <div>
            <a href="#" id="add_reason_attachment" class="btn btn-block btn-default"><i class="fas fa-plus mr-2"></i> Add Attachment</a>
        </div>
    </div>

    <div class="form-group">
        <label>Impact to DANA as Organization if we are failed to perform the agreement as soon as possible *</label>
        <textarea class="form-control" rows="3" name="exception_impact"></textarea>
    </div>

    <div class="form-group">
        <label>Attachment(s)</label>

        <div id="impact_attachments">
            <div class="input-group">
                <div class="custom-file mb-2">
                    <input type="file" accept="*" class="custom-file-input" name="impact_file[]">
                    <label class="custom-file-label">Choose file</label>
                </div>
            </div>
        </div>

        <div>
            <a href="#" id="add_impact_attachment" class="btn btn-block btn-default"><i class="fas fa-plus mr-2"></i> Add Attachment</a>
        </div>
    </div>

    <div class="form-group">
        <label>Due Date for the ordering confirmation *</label>
        <input type="text" class="form-control" name="request_due_date" autocomplete="off">
        <small class="form-text text-muted">Date Format: YYYY-MM-DD</small>
    </div>

    <div class="form-group">
        <label>Cost to proceed the order *</label>
        <div class="input-group">
        <div class="input-group-prepend">
            <select class="form-control" name="request_cost_currency">
                <option value="IDR">IDR</option>
            </select>
        </div>
            <input type="text" class="form-control number-separator" id="request_cost_amount_input">
            <input type="hidden" name="request_cost_amount">
        </div>
    </div>

    <b>Requestor Statement</b>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="requestor_statement_check">
        <label class="form-check-label">Hereby I declare that this request to justified the urgency, without any conflict of interest to the selected vendor.</label>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary" <?= ($is_eligible_submit) ? '' : 'disabled' ?>>Submit</button>
    </div>
</form>

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
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?= base_url("assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js") ?>"></script>
<script src="<?= base_url("assets/js/ep_create.js?v=".ASSET_VERSION) ?>"></script>
<?= $this->endSection() ?>