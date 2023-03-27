<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <?php if ($this->session->flashdata('msg')) { ?>
                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
                </div>
            <?php } ?>
            <div class="widget-content widget-content-area br-6">
                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <label for="counter_id">Select Counter</label>
                        <select id="counter_id" class="form-control" required name="counter_id">
                            <option value="">Choose...</option>
                            <?php foreach ($counters as $key => $counter) { ?>
                                <option value="<?= $counter->id ?>"><?= $counter->full_name ?> (<?= $counter->cust_code ?>)</option>
                            <?php  } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ww">Category *</label>
                        <?php foreach ($categories as $key => $category) { ?>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" value="<?= $category->id ?>" id="category_id<?= $category->id ?>" name="category_id[]">
                                <label class="form-check-label" for="category_id<?= $category->id ?>"><?= $category->label ?></label>
                            </div>
                        <?php } ?>

                        <?php echo form_error('category_id', '<div class="error">', '</div>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>