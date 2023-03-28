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
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="category_id">Select Category</label>
                            <select id="category_id" class="form-control" required name="category_id">
                                <option value="">Choose...</option>
                                <?php foreach ($categories as $key => $category) { ?>
                                    <option value="<?= $category->id ?>"><?= $category->label ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="number">Enter number</label>
                            <input type="number" class="form-control" name="number" id="number">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>