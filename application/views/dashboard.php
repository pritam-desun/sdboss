<?php
defined('BASEPATH') or exit('No direct script access allowed');

if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
?>
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row widget-statistic">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="widget widget-one_hybrid widget-followers">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Distributor</h5>
                                <p class="w-value"><?= $total_distributor ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Dealer</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= $total_dealer; ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Counters</h5>
                                <p class="w-value"> <span class="rupee_sign"> </span> <?= $users->total_user ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <div class="widget widget-one_hybrid widget-social">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="wallet" stroke="currentColor" class="svg-inline--fa fa-wallet fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M461.2 128H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h384c8.84 0 16-7.16 16-16 0-26.51-21.49-48-48-48H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h397.2c28.02 0 50.8-21.53 50.8-48V176c0-26.47-22.78-48-50.8-48zM416 336c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Wallet Balance</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= number_format($wallet_balance->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">
                    <style>
                        .col-md-12.online-pd0 {
                            padding: 0;
                        }
                    </style>

                    <div class="widget-heading">
                        <h5 class="">Online Counters</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table id="online_tbl" class="table table-hover non-hover" style="width:100%; padding-left:0px; padding-right:0px;">
                                <thead>
                                    <tr>
                                        <th>SL. No</th>
                                        <th>Counter Name</th>
                                        <th>Dealer Name</th>
                                        <th>Distributor Name</th>
                                        <th>Wallet</th>
                                        <th>Bid</th>
                                        <th>Win</th>
                                        <th>P/L</th>
                                        <!-- <th>P/L(%)</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $total_bid = 0;
                                    $total_win = 0;
                                    $total_pl = 0;
                                    $pl = 0;
                                    foreach ($online_counter_results as $key => $online_counter_result) {

                                        $total_bid += $online_counter_result->bidding_amount;
                                        $total_win += $online_counter_result->win_amount;
                                        $total_pl += intval($online_counter_result->bidding_amount) - intval($online_counter_result->win_amount);
                                        $pl = number_format(round(intval($online_counter_result->bidding_amount) - intval($online_counter_result->win_amount)), 2);

                                        $plper = number_format(round(((intval($online_counter_result->bidding_amount) * intval($pl)) / 100)), 2)
                                    ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $online_counter_result->counter_name ?></td>
                                            <td><?= $online_counter_result->dealer_name ?></td>
                                            <td><?= $online_counter_result->distributor_name ?></td>
                                            <td><?= $online_counter_result->wallet ?></td>
                                            <td><?= number_format(round($online_counter_result->bidding_amount), 2) ?></td>
                                            <td><?= number_format(round($online_counter_result->win_amount), 2) ?></td>
                                            <td><?= $pl ?></td>
                                            <!-- <td>< ?= $plper ?></td> -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?= number_format(round($total_bid), 2) ?></th>
                                        <th><?= number_format(round($total_win), 2) ?></th>
                                        <th><?= number_format($total_pl, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Important Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Offer Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } elseif ($this->session->user['user_type'] == 3) { ?>
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row widget-statistic">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Dealer</h5>
                                <p class="w-value"> <span class="rupee_sign"> </span> <?= $total_dealer ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Counters</h5>
                                <p class="w-value"> <span class="rupee_sign"> </span> <?= $users->total_user ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="widget widget-one_hybrid widget-social">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="wallet" stroke="currentColor" class="svg-inline--fa fa-wallet fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M461.2 128H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h384c8.84 0 16-7.16 16-16 0-26.51-21.49-48-48-48H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h397.2c28.02 0 50.8-21.53 50.8-48V176c0-26.47-22.78-48-50.8-48zM416 336c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Wallet Balance</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= number_format($wallet_balance->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">
                    <style>
                        .col-md-12.online-pd0 {
                            padding: 0;
                        }
                    </style>

                    <div class="widget-heading">
                        <h5 class="">Online Counters</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table id="online_tbl" class="table table-hover non-hover" style="width:100%; padding-left:0px; padding-right:0px;">
                                <thead>
                                    <tr>
                                        <th>SL. No</th>
                                        <th>Counter Name</th>
                                        <th>Dealer Name</th>
                                        <th>Distributor Name</th>
                                        <th>Wallet</th>
                                        <th>Bid</th>
                                        <th>Win</th>
                                        <th>P/L</th>
                                        <!-- <th>P/L(%)</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $total_bid = 0;
                                    $total_win = 0;
                                    $total_pl = 0;

                                    foreach (@$online_counter_results as $key => $online_counter_result) {
                                        if ($online_counter_result->counter_name != '') {
                                            $total_bid += $online_counter_result->bidding_amount;
                                            $total_win += $online_counter_result->win_amount;

                                            $pl = number_format(round(intval($online_counter_result->bidding_amount) - intval($online_counter_result->win_amount)), 2);

                                            $total_pl += $pl;

                                            $plper = number_format(round(((intval($online_counter_result->bidding_amount) * intval($pl)) / 100)), 2)
                                    ?>
                                            <tr>
                                                <td><?= ++$key ?></td>
                                                <td><?= $online_counter_result->counter_name ?></td>
                                                <td><?= $online_counter_result->dealer_name ?></td>
                                                <td><?= $online_counter_result->distributor_name ?></td>
                                                <td><?= $online_counter_result->wallet ?></td>
                                                <td><?= number_format(round($online_counter_result->bidding_amount), 2) ?></td>
                                                <td><?= number_format(round($online_counter_result->win_amount), 2) ?></td>
                                                <td><?= $pl ?></td>
                                                <!-- <td>< ?= $plper ?></td> -->
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?= number_format(round($total_bid), 2) ?></th>
                                        <th><?= number_format(round($total_win), 2) ?></th>
                                        <th><?= number_format(round($total_pl), 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Important Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Offer Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif ($this->session->user['user_type'] == 4) { ?>
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row widget-statistic">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Counters</h5>
                                <p class="w-value"> <span class="rupee_sign"> </span> <?= $users->total_user ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="widget widget-one_hybrid widget-social">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="wallet" stroke="currentColor" class="svg-inline--fa fa-wallet fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M461.2 128H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h384c8.84 0 16-7.16 16-16 0-26.51-21.49-48-48-48H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h397.2c28.02 0 50.8-21.53 50.8-48V176c0-26.47-22.78-48-50.8-48zM416 336c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Wallet Balance</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= number_format($wallet_balance->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">
                    <style>
                        .col-md-12.online-pd0 {
                            padding: 0;
                        }
                    </style>

                    <div class="widget-heading">
                        <h5 class="">Online Counters</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table id="online_tbl" class="table table-hover non-hover" style="width:100%; padding-left:0px; padding-right:0px;">
                                <thead>
                                    <tr>
                                        <th>SL. No</th>
                                        <th>Counter Name</th>
                                        <th>Dealer Name</th>
                                        <th>Distributor Name</th>
                                        <th>Wallet</th>
                                        <th>Bid</th>
                                        <th>Win</th>
                                        <th>P/L</th>
                                        <!-- <th>P/L(%)</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $total_bid = 0;
                                    $total_win = 0;
                                    $total_pl = 0;

                                    foreach ($online_counter_results as $key => $online_counter_result) {
                                        if ($online_counter_result->counter_name != '') {
                                            $total_bid += $online_counter_result->bidding_amount;
                                            $total_win += $online_counter_result->win_amount;

                                            $pl = number_format(round(intval($online_counter_result->bidding_amount) - intval($online_counter_result->win_amount)), 2);

                                            $total_pl += $pl;

                                            $plper = number_format(round(((intval($online_counter_result->bidding_amount) * intval($pl)) / 100)), 2)
                                    ?>
                                            <tr>
                                                <td><?= ++$key ?></td>
                                                <td><?= $online_counter_result->counter_name ?></td>
                                                <td><?= $online_counter_result->dealer_name ?></td>
                                                <td><?= $online_counter_result->distributor_name ?></td>
                                                <td><?= $online_counter_result->wallet ?></td>
                                                <td><?= number_format(round($online_counter_result->bidding_amount), 2) ?></td>
                                                <td><?= number_format(round($online_counter_result->win_amount), 2) ?></td>
                                                <td><?= $pl ?></td>
                                                <!-- <td>< ?= $plper ?></td> -->
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?= number_format(round($total_bid), 2) ?></th>
                                        <th><?= number_format(round($total_win), 2) ?></th>
                                        <th><?= number_format(round($total_pl), 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Important Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Offer Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row widget-statistic">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" stroke="currentColor" data-icon="sign-out-alt" class="svg-inline--fa fa-sign-out-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Withdraw Request</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= number_format($withdraw_request->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg aria-hidden="true" focusable="false" stroke="currentColor" data-prefix="fas" data-icon="sign-in-alt" class="svg-inline--fa fa-sign-in-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M416 448h-84c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h84c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96zm-47-201L201 79c-15-15-41-4.5-41 17v96H24c-13.3 0-24 10.7-24 24v96c0 13.3 10.7 24 24 24h136v96c0 21.5 26 32 41 17l168-168c9.3-9.4 9.3-24.6 0-34z"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Balance Request</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= number_format($balance_request->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="row widget-statistic">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="widget widget-one_hybrid widget-followers">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Deposit Today</h5>
                                <p class="w-value"> <?= number_format($deposit_today->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-icon">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" stroke="currentColor" data-icon="sign-out-alt" class="svg-inline--fa fa-sign-out-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"></path>
                                    </svg>
                                </div>
                                <h5 class="">Total Withdrawal Today</h5>
                                <p class="w-value"> <span class="rupee_sign"> <i class="fas fa-rupee-sign"></i> </span> <?= number_format($withdrawal_today->total_amount) ?></p>

                            </div>
                            <div class="widget-content">
                                <div class="w-chart">
                                    <div id="hybrid_followers1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Important Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-three notification-box">

                    <div class="widget-heading">
                        <h5 class="">Send Offer Notification</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <form method="post" action="<?= base_url('dashboard/sendNotification') ?>">
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Title</label>
                                    <input id="t-text" type="text" name="title" placeholder="Enter Title" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="t-text" class="sr-only">Body</label>
                                    <textarea class="form-control" id="editor" name="msg_body"></textarea>
                                </div>
                                <input type="submit" name="txt" class="mt-4 btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>