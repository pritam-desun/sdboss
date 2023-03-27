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

                        <label for="inputState">Category*</label>

                        <select id="inputState" class="form-control" name="cat_id">

                            <option value="">Choose...</option>

                            <?php foreach ($categories as $single_data) {
                            ?>

                                <option value="<?= $single_data->id ?>"><?= $single_data->cat_name ?></option>

                            <?php  } ?>

                        </select>

                        <?php echo form_error('cat_id', '<div class="error">', '</div>'); ?>

                    </div>

                    <div class="form-group mb-4">

                        <label for="inputAddress">Game Name</label>

                        <input type="text" class="form-control" id="inputAddress" placeholder="" name="name">

                        <?php echo form_error('name', '<div class="error">', '</div>'); ?>

                    </div>

                    <!-- <div class="form-group mb-4">

                        <label for="inputAddress2">Address 2</label>

                        <input type="text" class="form-control" id="inputAddress2"

                            placeholder="Apartment, studio, or floor">

                    </div> -->

                    <div class="form-group">

                        <label for="inputStateTime">Time slot*</label>

                        <select id="inputStateTime" class="form-control" name="slot_id">

                        </select>

                        <?php echo form_error('slot_id', '<div class="error">', '</div>'); ?>

                    </div>

                    <div class="form-group">

                        <label for="inputState">Play Game*</label>

                        <select id="inputState" class="form-control playgame" name="play_day[]" multiple="multiple">

                            <option value="">Choose...</option>

                            <?php $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

                            foreach ($days as $single_day) { ?>

                                <option value="<?= $single_day ?>"><?= $single_day ?></option>

                            <?php  } ?>

                        </select>

                        <?php echo form_error('play_day', '<div class="error">', '</div>'); ?>

                    </div>
                    <div class="form-group mb-4">

                        <label for="inputAddress">Minimum Bidding Amount</label>

                        <input type="text" class="form-control" id="inputAddress" placeholder="" name="minum_coin">

                        <?php echo form_error('minum_coin', '<div class="error">', '</div>'); ?>

                    </div>

                    <div class="form-group">

                        <label for="inputState">Image*</label>

                        <div class="custom-file mb-4">

                            <input type="file" name="image" class="custom-file-input" id="customFile">

                            <label class="custom-file-label" for="customFile">Choose file</label>

                        </div>

                        <?php echo form_error('image', '<div class="error">', '</div>'); ?>

                    </div>



                    <button type="submit" class="btn btn-primary mt-3">Add</button>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#inputState').on('change', function() {
            var cat = $(this).val();

            console.log(cat);

            $.get({
                url: "<?= base_url('Game/getSlot/'); ?>",
                data: {
                    cat: cat
                },
                success: (data) => {
                    $('#inputStateTime').html('');

                    $('#inputStateTime').append(`<option selected>Choose...</option> ${data}`);
                }
            });
        });
    });
</script>


