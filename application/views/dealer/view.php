<div class="layout-px-spacing">
  <div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
      <div class="widget-content widget-content-area br-6">
        <h4>Dealer List</h4>
        <?php if ($this->session->flashdata('msg')) { ?>
          <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
          </div>
        <?php } ?>
        <div class="table-responsive mb-4 mt-4">
          <table id="dealer_tbl" class="table table-hover non-hover" style="width:100%">
            <thead>
              <tr>
                <th>Status</th>
                <th>Dealer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Wallet</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              /*  echo "<pre>";
              print_r($dealer);
              die; */
              foreach ($dealer as $emp) {
                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2 || $this->session->user['user_type'] == 3) {
                  if ($emp['is_active'] == 'yes') {
                    $url = base_url('dealer/dealerStatus/' . 0 . '/') . $emp['user_id'];
                    $className = 'success';
                    $btnTtext = "Active";
                  } else {
                    $url = base_url('dealer/dealerStatus/' . 1 . '/') . $emp['user_id'];
                    $className = 'danger';
                    $btnTtext = "Inactive";
                  }
                }
              ?>
                <tr>
                  <?php if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2 || $this->session->user['user_type'] == 3) { ?>
                    <td>
                      <a href="<?= $url ?>" class="btn btn-<?= $className ?>"> <?= $btnTtext ?> </a>
                    </td>
                  <?php } ?>
                  <td><?= $emp['full_name']; ?></td>
                  <td><?= $emp['email_id']; ?></td>
                  <td><?= $emp['phone_no']; ?></td>
                  <td><?= $emp['wallet']; ?></td>

                  <?php if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2 || $this->session->user['user_type'] == 3) {
                    $actionMenuIds = $this->session->user['ac'];
                    /* echo "<pre>";
                    print_r($this->session->user['ac']);
                    echo in_array(35, $actionMenuIds);
                    die('sess'); */
                    $action_menu = $this->db->query("SELECT id FROM `menu_action`")->result_array();
                    $action_menu = array_column($action_menu, 'id');

                    /*   echo "<pre>";
                    print_r(array_column($action_menu, 'id'));
                    die('sess'); */

                  ?>
                    <td>
                      <?php
                      echo $this->commonHelper->actionBtn('counter/view/' . $emp['user_id'], true, 'btn btn-primary btn-sm', '', 'Counters (' . $emp["total"] . ')', false) . ' ';
                      if (in_array(35, $actionMenuIds)) {
                        echo $this->commonHelper->actionBtn('dealer/edit/' . $emp['user_id'], '', 'btn btn-info btn-sm', '', 'Edit', false) . ' ';
                      }

                      if (in_array(36, $actionMenuIds)) {
                        echo $this->commonHelper->actionBtn('dealer/delete/' . $emp['user_id'], '', 'btn btn-danger btn-sm', '', 'Delete', true) . ' ';
                      }

                      /* if (in_array(37, $actionMenuIds)) {
                        echo $this->commonHelper->actionBtn('dealer/counter/' . $emp['user_id'], 'btn btn-info btn-sm', '', 'Counter', false);
                      } */
                      ?>
                    </td>
                  <?php } ?>
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