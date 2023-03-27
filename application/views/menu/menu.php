<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <?php if($this->session->flashdata('msg_menu')){ ?>

            <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                <button type="button" class="close" data-dismiss="alert">×</button>

                <p class="alert-heading"> <?= $this->session->flashdata('msg_menu') ?> </p>

            </div>

            <?php } ?>

            <div class="widget-content widget-content-area br-6">

                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">

                    <div class="form-group mb-4">

                        <label for="inputMenuName">Menu Name</label>

                        <input type="text" class="form-control" id="inputMenuName" placeholder="" name="menu_name">

                        <?php echo form_error('menu_name','<div class="error">','</div>'); ?>

                    </div>

                    <div class="form-group mb-4">

                        <label for="inputUrl">url</label>

                        <input type="text" class="form-control" id="inputUrl" placeholder="" name="url">

                        <?php echo form_error('url','<div class="error">','</div>'); ?>

                    </div>

                    <div class="form-group mb-4">

                        <label for="inputMenuIcon">Menu Icon</label>

                        <input type="text" class="form-control" id="inputMenuIcon" placeholder="" name="menu_icon">

                        <?php echo form_error('menu_icon','<div class="error">','</div>'); ?>

                    </div>

                    <div class="form-group">

                        <label for="inputMenu">Parent Menu</label>

                        <select id="inputMenu" class="form-control" name="parent_menu">

                            <option value="">Choose...</option>

                            <?php foreach ($parent_menus as $parent_menu) { ?>

                                <option value="<?= $parent_menu['id']; ?>"><?= $parent_menu['menu_name']; ?></option>

                            <?php  } ?>

                        </select>

                        <?php echo form_error('parent_menu', '<div class="error">', '</div>'); ?>

                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Add</button>

                </form>

            </div>

        </div>

    </div>

</div>