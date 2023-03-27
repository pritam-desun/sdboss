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
                    <div class="form-group">
                        <label for="inputState">Category*</label>
                        <select id="inputState" class="form-control" name="cat_id">
                            <option value="">Choose...</option>
                            <?php foreach($categories as $single_data){
                                 if($single_data->id==$price->cat_id){
                                    $selected="selected";
                                }else{
                                    $selected="";
                                }
                                 ?>
                            <option value="<?= $single_data->id ?>" <?= $selected ?>><?= $single_data->label ?></option>
                            <?php  } ?>
                        </select>
                        <?php echo form_error('cat_id','<div class="error">','</div>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Type</label>
                        <select id="inputState" class="form-control" name="game_type">
                            <option value="">Choose...</option>
                            <?php foreach($type as $key => $value){ 
                                     if(isset($price) && $price->game_type==$key){
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
                    <div class="form-group">
                        <label for="inputState">Calculation Type*</label>
                        <select id="inputState" class="form-control" name="type">
                            <option value="">Choose...</option>
                            <option value="Multiply" <?= $price->type=='Multiply' ? 'selected' : '' ?>>Multiply</option>
                            <option value="Percentage" <?= $price->type=='Percentage' ? 'selected' : '' ?>>Percentage
                            </option>
                        </select>
                        <?php echo form_error('type','<div class="error">','</div>'); ?>
                    </div>
                    <div class="form-group mb-4">
                        <label for="inputAddress">Value</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="" name="value"
                            value="<?= $price->value ?>">
                        <?php echo form_error('single','<div class="error">','</div>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>