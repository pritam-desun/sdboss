<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <?php if($this->session->flashdata('msg')){ ?>
            <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
            </div>
            <?php } ?>
            <div class="widget-content widget-content-area br-6">
                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="inputState">App Name*</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="" name="app_name"
                                value="<?= $settings->app_name ?>">
                            <?php echo form_error('app_name','<div class="error">','</div>'); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Logo*</label>
                            <div class="custom-file mb-4">
                                <input type="file" name="image" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <img src="<?= base_url('uploads/logo/'.$settings->logo) ?>" height="50px" width="100px"
                                alt="Logo">
                            <?php echo form_error('image','<div class="error">','</div>'); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Commision (%)*</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="" name="commision"
                                value="<?= $settings->commision ?>">
                            <?php echo form_error('commision','<div class="error">','</div>'); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Email*</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="" name="email"
                                value="<?= $settings->email ?>">
                            <?php echo form_error('email','<div class="error">','</div>'); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Mobile Number*</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder=""
                                name="mobile_number" value="<?= $settings->mobile_number ?>">
                            <?php echo form_error('mobile_number','<div class="error">','</div>'); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">Whats App Number*</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder=""
                                name="whatsapp_number" value="<?= $settings->mobile_number ?>">
                            <?php echo form_error('whatsapp_number','<div class="error">','</div>'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputState">Minimum Deposit Amount*</label>
                            <input type="text" class="form-control" id="min_deposit_amount" name="min_deposit_amount" placeholder="0" value="<?= $settings->min_deposit_amount ?>">
                            <?php echo form_error('min_deposit_amount','<div class="error">','</div>'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputState">Minimum Withdraw Amount*</label>
                            <input type="text" class="form-control" id="min_withdraw_amount" name="min_withdraw_amount" placeholder="0" value="<?= $settings->min_withdraw_amount ?>">
                            <?php echo form_error('min_withdraw_amount','<div class="error">','</div>'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputState">Game Rules & Regulations URL*</label>
                            <input type="text" class="form-control" id="rules_page_url" name="rules_page_url" value="<?= $settings->rules_page_url ?>">
                            <?php echo form_error('rules_page_url','<div class="error">','</div>'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputState">App Sharing Message*</label>
                            <textarea class="form-control" id="share_msg" name="share_msg" rows="5"><?=$settings->share_msg?></textarea>
                            <?php echo form_error('share_msg','<div class="error">','</div>'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputState">Turn all game  on/off <br>
                                Current Status <?= $settings->game_off == 1 ? 'game Off' : 'game is on' ?> </label>  
                             
                        </div>

                        <div class="form-group col-md-12">
                            <label class="switch s-icons s-outline s-outline-primary mr-2">
                                <input name="game_off" id="game_status" onchange="game_status_change()" type="checkbox" <?= $settings->game_off == 1 ? 'checked' : '' ?> >
                                <span class="slider round"></span>
                            </label>   
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Game Off Reason</label>
                            <input type="text" id="game_off_reason" class="form-control" <?= $settings->game_off == 1 ? 'required' : '' ?> id="inputAddress" placeholder="" name="game_off_reason"
                                value="<?= $settings->game_off_reason ?>">
                            <?php echo form_error('game_off_reason','<div class="error">','</div>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Game Off Reason Image (800 x 800)</label>
                            <div class="custom-file mb-4">
                                <input type="file" name="game_off_image" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <img src="<?= base_url('uploads/logo/'.$settings->game_off_image) ?>" height="50px" width="100px"
                                alt="Logo">
                            <?php echo form_error('game_off_image','<div class="error">','</div>'); ?>
                        </div>


                        <!-- <div class="form-group col-md-12">
                            <label for="inputState">Game Rules*</label>
                            <textarea class="form-control" id="editor1" name="rules"><?= $settings->rules ?></textarea> 
                            <?php echo form_error('rules','<div class="error">','</div>'); ?>

                        </div> -->


                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function game_status_change(val){
       let game_status_field =  document.querySelector("#game_status");
       let game_off_reason_field = document.querySelector("#game_off_reason");
       if(game_status_field.checked){
            game_off_reason_field.setAttribute("required","required");
            game_status_field.value = '1';
       }else{
           game_off_reason_field.removeAttribute("required");
           game_status_field.value = '0';
       }
    }
</script>
