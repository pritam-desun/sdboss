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

                            <select id="resultCategory" class="form-control" name="cat_id">

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

                            <label for="inputAddress">Time Slot</label>

                            <select id="slots" class="form-control" name="slot_id">

                                <option selected>Choose...</option>

                                <?php foreach($slot as $single_data){

                                     if(isset($slot_id) && $slot_id==$single_data->id){

                                        $selected="selected";

                                    }else{

                                        $selected="";

                                    } ?>

                                <option value="<?= $single_data->id ?>" <?= $selected ?>>

                                    <?= $single_data->start_time." - ".$single_data->end_time ?></option>

                                <?php  } ?>

                            </select>

                            <?php echo form_error('name','<div class="error">','</div>'); ?>

                        </div>

                        <div class="form-group mb-4 col-md-3">

                            <label for="inputAddress">Type</label>

                            <select id="inputState" class="form-control" name="type">

                                <option value="">Choose...</option>

                                <?php foreach($type as $key => $value){ 

                                     if(isset($game_type) && $game_type==$key){

                                        $selected="selected";

                                    }else{

                                        $selected="";

                                    }

                                    ?>

                                <option value="<?= $key ?>" <?= $selected ?>>

                                    <?= $value ?></option>

                                <?php  } ?>

                            </select>

                        </div>
                        <div class="form-group mb-4 col-md-3">

                            <label for="inputAddress">Select Date</label>

                            <input class="form-control" type="text" id="basicFlatpickr" name="date"
                                value="<?=  isset($date) ? $date : date("Y-m-d") ?>" />

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
                <h4> Total Bet</h4>

                <div class="table-responsive mb-4 mt-4">

                    <table id="dataTable" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>

                                <th>Digits</th>

                                <th>Amount (₹)</th>

                                <th>Count Customer</th>
                                
                                <th>Profit/Loss (₹)</th>

                                

                            </tr>

                        </thead>

                        <?php if(isset($bid) && !empty($bid)){ ?>

                        <tbody>

                            <?php

                          

                                $amount=0;

                                $total_customer=0;
                                $total = 0;
                                 foreach($bid as $single_data){ 

                                  if($calculation_type->type === 'Multiply'){
                                    $total = $total_amount - ($single_data->bidding_amount * $calculation_type->value);  
                                  } else {
                                    $total =$total_amount - ($single_data->bidding_amount + round(($single_data->bidding_amount * $calculation_type->value) / 100));
                                  } 
                                  

                               ?>

                            <tr>

                                <td><?= $single_data->number ?></td>

                                <td><?= $single_data->bidding_amount ?></td>

                                <td><?= $single_data->total ?></td>
                                <?php $class = "btn btn-danger"; if($total > 0){ $class = "btn btn-success";}?>
                                <td><a href="javascript:void(0)" class="<?= $class ?>"> <b><?= $total ?> </b> </a></td>   

                            </tr>

                            <?php 

                            $amount=$amount+$single_data->bidding_amount;

                            $total_customer=$total_customer+$single_data->total;

                    }  ?>

                        </tbody>

                        <tfoot>

                            <tr>

                                <th></th>

                                <th>Total Amount : ₹ <?= $amount ?></th>

                                <th>Total Customer : <?= $total_customer ?></th>

                            </tr>

                        </tfoot>

                        <?php  }?>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>