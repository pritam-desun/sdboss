<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
        <form class="form-inline justify-content-center" method="post" >
            <label class="sr-only" for="inlineFormInputName2">Category</label>
            <select id="inputState" class="form-control mb-2 mr-sm-2" name="cat_id">
                    <option value="">Choose...</option>
                        <?php foreach($cats as $cat){ ?>
                            <option value="<?= $cat->id ?>"><?= $cat->label ?></option>
                         <?php } ?>   
                    </option>
                </select>
                <label class="sr-only" for="inlineFormInputGroupUsername2">Date</label>
                <input type="text" name="date" class="form-control mb-2 mr-sm-2" placeholder="Select Date" id="rangeCalendarFlatpickr">
                </select>    

            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
        </div>
    </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">

                <?php if($this->session->flashdata('msg')){ ?>

                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>

                </div>

                <?php } ?>

                <div class="table-responsive mb-4 mt-4">
                    <?php  
                    $total_bidding_money = 0;
                    $total_winning_money = 0;
                    foreach($main as $key => $cat){ ?>
                    <h3><?= $cat->label ?></h3>
                    <table id="" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>
                                <th><?= $cat->label ?></th>
                                <th>Single</th>
                                <th>Patti</th>
                                <th>Jodi</th>
                                <th>CP</th>
                            </tr>

                        </thead>

                        <tbody>

                           
                                <tr>
                                    <td>Baji</td>
                                    <td><?php 
                                        if($cat->single_bid_amount){
                                            echo $cat->single_bid_amount;
                                            $total_bidding_money = $total_bidding_money+$cat->single_bid_amount;
                                        }else{
                                            echo "0";
                                            $total_bidding_money = $total_bidding_money+0;
                                        } ?></td>
                                    <td><?php if($cat->patti_bid_amount){
                                            echo $cat->patti_bid_amount;
                                            $total_bidding_money = $total_bidding_money+$cat->patti_bid_amount;
                                        }else{
                                            echo "0";
                                            $total_bidding_money = $total_bidding_money+0;
                                        } ?></td>
                                    <td><?php if($cat->jodi_bid_amount){
                                            echo $cat->jodi_bid_amount;
                                            $total_bidding_money = $total_bidding_money+$cat->jodi_bid_amount;
                                        }else{
                                            echo "0";
                                            $total_bidding_money = $total_bidding_money+0;
                                        } ?></td>
                                    <td><?php if($cat->cp_bid_amount){
                                            echo $cat->cp_bid_amount;
                                            $total_bidding_money = $total_bidding_money+$cat->cp_bid_amount;
                                        }else{
                                            echo "0";
                                            $total_bidding_money = $total_bidding_money+0;
                                        } ?></td>
                                </tr>
                                <tr>
                                    <td>Win</td>
                                    <td>
                                        <?php  
                                        $single_win = 0;
                                        foreach($cat->win_price as $win){ 
                                            if($win->game_type == 'Single'){
                                                if($win->type == 'Multiply'){
                                                    $single_win = $cat->single_sum_of_win_amount * $win->value; 
                                                }else{
                                                    $single_win = $cat->single_sum_of_win_amount + round(($cat->single_sum_of_win_amount * $win->value)/100);
                                                }
                                            }
                                        }
                                        echo $single_win;
                                        $total_winning_money = $total_winning_money + $single_win;
                                        ?>   
                                    </td>
                                    <td>
                                        <?php  
                                        $patti_win = 0;
                                        foreach($cat->win_price as $win){ 
                                            if($win->game_type == 'Patti'){
                                                if($win->type == 'Multiply'){
                                                    $patti_win = $cat->patti_sum_of_win_amount * $win->value; 
                                                }else{
                                                    $patti_win = $cat->patti_sum_of_win_amount + round(($cat->patti_sum_of_win_amount * $win->value)/100);
                                                }
                                            }
                                        }
                                        echo $patti_win;
                                        $total_winning_money = $total_winning_money + $patti_win;
                                        ?>   
                                    </td>
                                    <td>
                                        <?php  
                                        $jodi_win = 0;
                                        foreach($cat->win_price as $win){ 
                                            if($win->game_type == 'Jodi'){
                                                if($win->type == 'Multiply'){
                                                    $jodi_win = $cat->jodi_sum_of_win_amount * $win->value; 
                                                }else{
                                                    $jodi_win = $cat->jodi_sum_of_win_amount + round(($cat->jodi_sum_of_win_amount * $win->value)/100);
                                                }
                                            }
                                        }
                                        echo $jodi_win;
                                        $total_winning_money = $total_winning_money + $jodi_win;
                                        ?>   
                                    </td>
                                    <td>
                                        <?php  
                                        $cp_win = 0;
                                        
                                        foreach($cat->win_price as $win){ 
                                          
                                            if($win->game_type == 'CP'){
                                                if($win->type == 'Multiply'){
                                                    $cp_win = $cat->cp_sum_of_win_amount * $win->value; 
                                                }else{
                                                    $cp_win = $cat->cp_sum_of_win_amount + round(($cat->cp_sum_of_win_amount * $win->value)/100);
                                                }
                                            }
                                        }
                                         echo $cp_win;
                                         $total_winning_money = $total_winning_money + $cp_win;
                                        ?>   
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?= ($cat->single_bid_amount - $single_win) ?></td>
                                    <td><?= ($cat->patti_bid_amount - $patti_win) ?></td>
                                    <td><?= ($cat->jodi_bid_amount - $jodi_win) ?></td>
                                    <td><?= ($cat->cp_bid_amount - $cp_win) ?></td>
                                </tr>
                               
                        </tbody>

                    </table>
                <?php } ?>


                <h4>Total Bidding Amount :  <?php echo $total_bidding_money; ?></h4>
                <h4>Total Wining Amount :  <?php echo $total_winning_money; ?></h4>
                <h4>Total Profit/Loss :  <?php echo ($total_bidding_money - $total_winning_money); ?></h4>

                </div>

            </div>

        </div>

    </div>



</div>