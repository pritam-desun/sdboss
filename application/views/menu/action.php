<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <?php if ($this->session->flashdata('msg_action')) { ?>

                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <p class="alert-heading"> <?= $this->session->flashdata('msg_action') ?> </p>

                </div>

            <?php } ?>

            <div class="widget-content widget-content-area br-6">

                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">

                    <div class="form-group">

                        <label for="inputMenu">Sub Menu</label>

                        <select id="inputMenu" class="form-control" name="menu_id">

                            <option value="">Choose...</option>

                            <?php foreach ($menus as $menu) {
                            ?>

                                <option value="<?= $menu['id']; ?>"><?= $menu['menu_name']; ?></option>

                            <?php  } ?>

                        </select>

                        <?php echo form_error('menu_id', '<div class="error">', '</div>'); ?>

                    </div>

                    <div class="form-group mb-4">

                        <label for="inputActionName">Action Name</label>

                        <input type="text" class="form-control" id="inputActionName" placeholder="" name="action_name">

                        <?php echo form_error('action_name', '<div class="error">', '</div>'); ?>

                    </div>

                    <div class="form-group mb-4">

                        <label for="inputUrl">url</label>

                        <input type="text" class="form-control" id="inputUrl" placeholder="" name="action_url">

                        <?php echo form_error('action_url', '<div class="error">', '</div>'); ?>

                    </div>

                    <?php  /*

                    <div class="form-group mb-4">

                        <label for="alertRequired">Alert Required</label>

                        <input type="text" class="form-control" id="alertRequired" placeholder="Enter Y for Yes or N for No" name="alert_required">

                        <?php echo form_error('alert_required', '<div class="error">', '</div>'); ?>

                    </div>

                    <div class="form-group mb-4">

                        <label for="inputActionIcon">Icon</label>

                        <input type="text" class="form-control" id="inputActionIcon" placeholder="" name="icon">

                        <?php echo form_error('icon', '<div class="error">', '</div>'); ?>

                    </div>

                    */ ?>

                    <button type="submit" class="btn btn-primary mt-3">Add</button>

                </form>

            </div>

        </div>

    </div>

</div>