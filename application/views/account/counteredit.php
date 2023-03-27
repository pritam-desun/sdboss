<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <?php if ($this->session->flashdata('msg_menu')) { ?>
                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p class="alert-heading"> <?= $this->session->flashdata('msg_menu') ?> </p>
                </div>
            <?php } ?>
            <div class="widget-content widget-content-area br-6">
                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group mb-4">
                        <label for="inputFullName">Distributor</label>
                        <select id="inputState" class="form-control mb-2 mr-sm-2" required name="distributor_id">
                            <?php foreach ($distributors as $distributor) { ?>
                                <option value="<?= $distributor->user_id ?>" <?= ($distributor->user_id == $selected_dealer->assigned_by_id ? 'selected' : '') ?>><?= $distributor->full_name ?></option>
                            <?php } ?>
                            </option>
                        </select>
                        <?php echo form_error('full_name', '<div class="error">', '</div>'); ?>
                    </div>
                    <div class="form-group mb-4">
                        <label for="inputFullName">Dealer</label>
                        <select id="inputState" class="form-control mb-2 mr-sm-2" required name="dealer_id">
                            <?php foreach ($dealers as $dealer) { ?>
                                <option value="<?= $dealer->user_id ?>" <?= ($dealer->user_id == $customer->assigned_by_id ? 'selected' : '') ?>><?= $dealer->full_name ?></option>
                            <?php } ?>
                            </option>
                        </select>
                        <?php echo form_error('full_name', '<div class="error">', '</div>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>