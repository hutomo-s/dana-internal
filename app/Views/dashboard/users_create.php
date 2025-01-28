<?= $this->extend('layouts/adminlte_3') ?>

<?= $this->section('page_title') ?>Add New User<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form id="user-create-form" method="POST" action="<?= $api_user_store ?>" style="max-width: 450px;">
        <div class="form-group">
            <label>Email *</label>
            <input type="email" class="form-control" name="user_email" autocomplete="off">
        </div>
        <div class="form-group">
            <label>Full Name *</label>
            <input type="text" class="form-control" name="display_name" autocomplete="off">
        </div>
        <div class="form-group">
            <label>Role *</label>
            <select class="form-control" name="role_id">
                <option value="" selected disabled>Select Role</option>
                <?php foreach($roles as $role): ?>
                <option value="<?= $role->id ?>"><?= $role->role_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Department *</label>
            <select class="form-control" name="department_id">
            <option value="" selected disabled>Select Department</option>
                <?php foreach($departments as $department): ?>
                <option value="<?= $department->id ?>"><?= $department->department_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Line Manager</label>
            <select class="form-control" name="line_manager_id">
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Signature Image</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" accept="image/*" class="custom-file-input" name="signature_image">
                    <label class="custom-file-label">Choose file</label>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Is Active *</label>
            <select class="form-control" name="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
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
<span id="api_get_line_managers" data-value="<?= $api_get_line_managers; ?>"></span>
<?= $this->endSection() ?>

<?= $this->section('script_tags') ?>
<script src="<?= base_url("assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js") ?>"></script>
<script src="<?= base_url("assets/js/users_create.js?v=".ASSET_VERSION) ?>"></script>
<?= $this->endSection() ?>