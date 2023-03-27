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

            <label for="inputFullName">User Type</label>

            <input type="text" class="form-control" id="inputFullName" readonly name="full_name" value="Distributor">

            <?php echo form_error('full_name', '<div class="error">', '</div>'); ?>

          </div>
          <div class="form-group mb-4">

            <label for="email">Distributor Name</label>

            <input type="text" class="form-control" id="email" placeholder="" name="full_name">

            <?php echo form_error('full_name', '<div class="error">', '</div>'); ?>

          </div>

          <div class="form-group mb-4">

            <label for="email">Email</label>

            <input type="email" class="form-control" id="email" placeholder="" name="email">

            <?php echo form_error('email', '<div class="error">', '</div>'); ?>

          </div>

          <div class="form-group mb-4">

            <label for="mobile">Mobile Number</label>

            <input type="number" class="form-control" id="mobile" placeholder="" name="mobile">

            <?php echo form_error('mobile', '<div class="error">', '</div>'); ?>

          </div>

          <div class="form-group mb-4">

            <label for="password">Password</label>

            <input type="password" class="form-control" id="password" placeholder="" name="password">

            <?php echo form_error('password', '<div class="error">', '</div>'); ?>

          </div>

          <button type="submit" class="btn btn-primary mt-3">Add</button>

        </form>

      </div>

    </div>

  </div>

</div>