<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <h4> Withdraw List</h4>
                <?php if($this->session->flashdata('msg')){ ?>
                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
                </div>
                <?php } ?>
                <div class="table-responsive mb-4 mt-4">
                    <table id="dataTable" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Amount(₹)</th>
                                <th>Mobile</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($requests as $request){ ?>
                            <?php
							if($request->status == 'P'){
								$url = base_url('approve/moneyWihdraw/').$request->id.'/'.$request->cust_code;
								$className = 'warning';
								$btnTtext = "Approve Balance";
								$onclick='onclick="return confirm(`Are you sure you want to change the status?`)"';
                                $reject = true;
                            }elseif($request->status == 'S'){
								$url = 'javascript:void(0)';
								$className = 'primary';
								$btnTtext = "Approved";
								$onclick="";
                                $reject = false;
							}else{
								$url = 'javascript:void(0)';
								$className = 'danger';
								$btnTtext = "Failed";
								$onclick="";
                                $reject = false;
							}
							?>
                            <tr>
                                <td>
                                    <a href="<?= $url ?>" class="btn btn-<?= $className ?>" <?= $onclick; ?>>
                                        <?= $btnTtext ?> </a><br>
                                        <?php if($reject){ ?>
                                            <a href="<?= base_url('approve/rejectw/').$request->id.'/'.$request->cust_code; ?>" class="btn btn-danger" style="margin-top: 10px" onclick="return confirm(`Are you sure you want to cancel?`)">
                                       Cancel</a>
                                            <?php } ?>    
                                </td>
                                <td><?= $request->full_name ?></td>
                                <td><?= $request->amount ?></td>
                                <td><?= $request->mobile ?></td>
                                <td><?= change_date_format($request->request_time, "F j, Y h:i A") ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>