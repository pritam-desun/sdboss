<div class="layout-px-spacing">
  <div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
      <div class="widget-content widget-content-area br-6">
        <h4>Distributor List</h4>
        <?php if ($this->session->flashdata('msg')) { ?>
          <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
          </div>
        <?php } ?>
        <div class="table-responsive mb-4 mt-4">
          <table id="account_trans" class="table table-hover non-hover" style="width:100%">
            <thead>
              <tr>
                <?php
                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
                  echo '<th>Status</th>';
                }
                ?>
                <th>Distributor</th>
                <th>User Type</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Wallet</th>
                <?php
                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
                  echo '<th>Action</th>';
                }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($distributor as $emp) {
                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
                  if ($emp['is_active'] == 'yes') {
                    $url = base_url('employee/empStatus/' . 0 . '/') . $emp['user_id'];
                    $className = 'success';
                    $btnTtext = "Active";
                  } else {
                    $url = base_url('employee/empStatus/' . 1 . '/') . $emp['user_id'];
                    $className = 'danger';
                    $btnTtext = "Inactive";
                  }
                }
              ?>
                <tr>
                  <?php if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) { ?>
                    <td>
                      <a href="<?= $url ?>" class="btn btn-<?= $className ?>"> <?= $btnTtext ?> </a>
                    </td>
                  <?php } ?>
                  <td><?= $emp['full_name']; ?></td>
                  <td><?= $emp['user_name']; ?></td>
                  <td><?= $emp['email_id']; ?></td>
                  <td><?= $emp['phone_no']; ?></td>
                  <td><?= $emp['wallet']; ?></td>

                  <?php if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) { ?>
                    <td>
                      <a href="<?= base_url('dealer/view/') . $emp['user_id']; ?>" id="empEdit" target="_blank" class="btn btn-primary btn-sm">DL (<?= $emp['total'] ?>)</a>
                      <a href="<?= base_url('distributor/edit/') . $emp['user_id']; ?>" id="empEdit" class="btn btn-info btn-sm">Edit</a>


                      <a href="<?= base_url('distributor/delete/') . $emp['user_id']; ?>" id="empDel" class="btn btn-danger btn-sm">Delete</a>



                    <?php } ?>
                    </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#empDel').on('click', function() {
            alert('Are you want to delete employee');
        });
    });
</script> -->