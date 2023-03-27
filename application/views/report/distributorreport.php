<?php
/* echo "<pre>";
print_r($results);
die; */
?>
<div class="layout-px-spacing">

  <div class="row layout-top-spacing">


    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
      <div class="widget-content widget-content-area br-6">
        <form class="form-inline justify-content-center" method="post">
          <?php if ($this->session->user['user_type'] == 1) { ?>
            <label class="sr-only" for="inlineFormInputName2">Distributor</label>
            <select id="inputState" class="form-control mb-2 mr-sm-2" required name="distributor_id">
              <option value="">Choose...</option>
              <?php foreach ($distributors as $distributor) { ?>
                <option value="<?= $distributor->user_id ?>"><?= $distributor->full_name ?></option>
              <?php } ?>
              </option>
            </select>
          <?php } else { ?>
            <label class="sr-only" for="inlineFormInputName2">Distributor</label>
            <select id="inputState" class="form-control mb-2 mr-sm-2" required name="distributor_id">
              <option value="">Choose...</option>
              <?php foreach ($distributors as $distributor) { ?>
                <option value="<?= $distributor->user_id ?>" <?= ($distributor->user_id == $this->session->user['user_id'] ? 'selected' : 'disabled ') ?>><?= $distributor->full_name ?></option>
              <?php } ?>
              </option>
            </select>
          <?php } ?>
          <label class="sr-only" for="inlineFormInputGroupUsername2">Date</label>
          <input type="text" name="date" class="form-control mb-2 mr-sm-2" required placeholder="Select Date" id="rangeCalendarFlatpickr">
          </select>

          <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
      </div>
    </div>

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
              $total_bid_amount += $result->amount;
              $total_win_amount += $result->win_amount;
            }
          } ?>

          <tbody>
            <h3>Distributor Report || Bid Amount = > <?= $total_bid_amount ?> || Win Amount => <?= $total_win_amount ?> </h3>
            <table id="dataTables" class="table table-hover non-hover" style="width:100%">
              <thead>
                <tr>
                  <th>SL#</th>
                  <th>Distributor Name</th>
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
                      <td><?= $result->distributor_name ?></td>
                      <td><?= $result->distributor_mobile_no ?></td>
                      <td><?= $result->bid_on ?></td>
                      <td><?= number_format(round($result->amount), 2) ?></td>
                      <td><?= number_format(round($result->win_amount), 2) ?></td>
                      <td><?= number_format(round($result->amount - $result->win_amount), 2) ?></td>
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