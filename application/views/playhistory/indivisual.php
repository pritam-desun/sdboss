<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <!-- <?php if($this->session->flashdata('msg')){ ?>

            <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                <button type="button" class="close" data-dismiss="alert">×</button>

                <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>

            </div>

            <?php } ?> -->

            <div class="widget-content widget-content-area br-6">

                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">

                    <div class="form-row mb-4">

                        <div class="form-group col-md-3">

                            <label for="inputState">Category*</label>

                            <select id="inputState" class="form-control" name="cat_id">

                                <option value="">Choose...</option>

                                <?php foreach($categories as $single_data){

                                    if(isset($cat_id) && $cat_id==$single_data->id){

                                        $selected="selected";

                                    }else{

                                        $selected="";

                                    }

                                     ?>

                                <option value="<?= $single_data->id ?>" <?= $selected  ?>><?= $single_data->label ?>

                                </option>

                                <?php  } ?>

                            </select>

                            <?php echo form_error('cat_id','<div class="error">','</div>'); ?>

                        </div>

                        <div class="form-group mb-4 col-md-3">

                            <label for="inputAddress">Mobile Number</label>

                            <input type="text" name="number" class="form-control"
                                value="<?=  isset($number) ? $number : '' ?>">

                            <?php echo form_error('name','<div class="error">','</div>'); ?>

                        </div>

                        <div class="form-group mb-4 col-md-3">

                            <label for="inputAddress">Select Date</label>

                            <input class="form-control" type="text" id="basicFlatpickr" name="date"
                                value="<?=  isset($date) ? $date : date('Y-m-d') ?>" />

                        </div>



                        <div class="form-group mb-4 col-md-1">

                            <button type="submit" class="btn btn-primary mb-2" id="">Search</button>

                        </div>

                    </div>



                </form>

            </div>



        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">
                <h4> Idivisual Bet History</h4>
                <div class="table-responsive mb-4 mt-4">
                    <table id="dataTable" class="table table-hover non-hover" style="width:100%">

                        <thead>
                            <tr>
                                <th>Name</th>

                                <th>Game Name</th>
                                <th>Type</th>

                                <th>Digit</th>

                                <th>Amount</th>

                                <th>Status</th>

                                <th>Date</th>

                            </tr>

                        </thead>

                        <?php if(isset($bid) && !empty($bid)){ ?>

                        <tbody>

                            <?php

                          

                                $total_customer=0;

                                $total_amount=0;

                                 foreach($bid as $single_data){ 

                                     if($single_data->status=='P'){

                                        $className = 'warning';

                                         $status="Pending";

                                     }elseif($single_data->status=='L'){

                                        $className = 'danger';

                                        $status="Loss";

                                     }elseif($single_data->status=='W'){

                                        $className = 'success';

                                        $status="Win";

                                     }

                               ?>

                            <tr>

                                <td><?= $single_data->full_name ?></td>

                                <td><?= $single_data->name ?></td>
                                <td><?= $single_data->type ?></td>

                                <td><?= $single_data->number ?></td>

                                <td><?= $single_data->amount ?></td>

                                <td><button class="btn btn-<?= $className ?>"><?= $status ?></button></td>

                                <td><?= change_date_format($single_data->bid_on, "F j, Y h:i A") ?></td>



                            </tr>

                            <?php 

                            $total_customer++;

                            $total_amount=$total_amount+$single_data->amount;

                           

                    }  ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total bet : <?= $total_customer ?></th>
                                <th></th>
                                <th></th>
                                <th>Total Amount : ₹ <?= $total_amount ?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <?php  }?>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>