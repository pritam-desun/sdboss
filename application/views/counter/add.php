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
          <?php if ($this->session->user['user_type'] == 1) { ?>
            <div class="form-group mb-4">
              <label for="distributor_id">Select Distributor</label>
              <select class="form-control" id="distributor_id" onchange="get_dealer(this.value)" name="distributor_id">
                <option value="">-- Select --</option>
                <?php foreach ($distributors as $key => $distributor) { ?>
                  <option value="<?= $distributor->user_id ?>"><?= $distributor->full_name ?> (<?= $distributor->phone_no ?>)</option>
                <?php } ?>
              </select>
              <?php echo form_error('distributor_id', '<div class="error">', '</div>'); ?>
            </div>
            <div class="form-group mb-4">
              <label for="dealer_id">Select Dealer</label>
              <select class="form-control" id="dealer_id" name="dealer_id">
                <option value="">-- Select Distributor First --</option>

              </select>
              <?php echo form_error('dealer_id', '<div class="error">', '</div>'); ?>
            </div>
          <?php } ?>
          <div class="form-group mb-4">

            <label for="email">Full Name</label>

            <input type="text" class="form-control" placeholder="" name="full_name">

            <?php echo form_error('full_name', '<div class="error">', '</div>'); ?>

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