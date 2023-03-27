<div class="layout-px-spacing">
  <div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
      <div class="widget-content widget-content-area br-6">
        <div class="table-responsive mb-4 mt-4">
          <table id="counter_tbl" class="table table-hover non-hover" style="width:100%">
            <thead>
              <tr>
                <th>CustomerId</th>
                <th>Full Name</th>
                <th>Mobile</th>
                <th>Wallet</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($counter as $key => $counterrow) {
                die; ?>
                <tr>
                  <td><?= $counterrow['cust_code'] ?></td>
                  <td><?= $counterrow['full_name'] ?></td>
                  <td><?= $counterrow['mobile'] ?></td>
                  <td><?= $counterrow['wallet_balance'] ?></td>
                  <td>
                    <?php
                    if ($counterrow['is_deleted'] == 0) {
                      echo $this->commonHelper->actionBtn(false, 'btn btn-success btn-md', '', 'Active', false);
                    } else {
                      echo $this->commonHelper->actionBtn(false, 'btn btn-danger btn-md', '', 'In Active ', false);
                    }

                    ?>
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