<?php
/* echo "<pre>";
print_r($results);
die; */
?>
<div class="layout-px-spacing">

  <div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

      <div class="widget-content widget-content-area br-6">

        <?php if ($this->session->flashdata('msg')) { ?>

          <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>

          </div>

        <?php } ?>

        <div class="table-responsive mb-4 mt-4">
          <?php
          $total_bid_amount = 0;
          $total_win_amount = 0;
          if (@count($results)) {
            foreach ($results as $key => $result) {
              $total_bid_amount += $result->bidding_amount;
              $total_win_amount += intval($result->win_amount);
            }
          }  ?>
          <h5>Counter Report || Bid Amount = > <?= $total_bid_amount ?> || Win Amount => <?= $total_win_amount ?> || P/L => <?= number_format(round($total_bid_amount - $total_win_amount), 2) ?> </h5>
          <table id="dataTables" class="table table-hover non-hover" style="width:100%">
            <thead>
              <tr>
                <th>SL#</th>
                <th>Counter Name</th>
                <th>Mobile No.</th>
                <th>Date</th>
                <th>Bid Amount</th>
                <th>Win Amount</th>
                <th>Total Amount</th>
              </tr>
            </thead>

            <tbody>
              <?php
              if (@count($results)) {
                foreach ($results as $key => $result) { ?>
                  <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $result->counter_name ?></td>
                    <td><?= $result->counter_mobile_no ?></td>
                    <td><?= $result->bid_on ?></td>
                    <td><?= number_format(round($result->bidding_amount), 2) ?></td>
                    <td><?= number_format(round($result->win_amount), 2) ?></td>
                    <td><?= number_format(round($result->bidding_amount - intval($result->win_amount)), 2) ?></td>
                  </tr>
              <?php }
              } ?>
            </tbody>
          </table>
        </div>

      </div>

    </div>

  </div>



</div>