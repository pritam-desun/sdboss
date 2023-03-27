<?php
$url = $this->uri->uri_string();

$action = [];
$ma_url = [];

$ac = $this->session->user['ac'];

// echo "<pre>";
// print_r($ac);
// die("ac");

// var_dump($acs);
// die('acs');

if ($this->session->user['ac'] != NULL) {

    $menu_actions = $this->db->query("SELECT m.id, m.url, ma.* FROM menu AS m JOIN menu_action as ma ON m.id = ma.menu_id WHERE m.url = '$url'")->result_array();

    foreach ($menu_actions as $ma) {
        if (in_array($ma['id'], $ac)) {
            array_push($action, $ma['action_name']);

            array_push($ma_url, $ma['action_url']);
        }
    }
} else {
    $action[] = NULL;
}

// echo "<pre>"; print_r($action); die("action");

?>
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <?php
                for ($i = 0; $i < count($action); $i++) {
                    if ($action[$i] == 'ADD') {
                ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addSlotModal" class="btn btn-dark ml-3">Add</a>
                <?php }
                }
                ?>
                <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
                    </div>
                <?php } ?>
                <div class="table-responsive mb-4 mt-4">
                    <table id="account_trans1" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <?php
                                if ($this->session->user['user_type'] == 1) {
                                    for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Status') {
                                            echo '<th>Status</th>';
                                        }
                                    }
                                }
                                ?>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Cat Name</th>
                                <?php
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Edit') {
                                        echo '<th>Action</th>';
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($slots as $key => $slot) { 
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        if ($slot->status == 'Y') {
                                            $url = base_url($ma_url[$i] . '/N/') . $slot->id;
                                            $className = 'success';
                                            $btnTtext = "Active";
                                        } else {
                                            $url = base_url($ma_url[$i] . '/Y/') . $slot->id;
                                            $className = 'danger';
                                            $btnTtext = "Inactive";
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <?php if ($this->session->user['user_type'] == 1) { ?>
                                        <td>
                                            <a href="<?= $url ?>" class="btn btn-<?= $className ?>"> <?= $btnTtext ?> </a>
                                        </td>
                                    <?php } ?>
                                    <td><?= $slot->start_time ?></td>
                                    <td><?= $slot->end_time ?></td>
                                    <td><?= $slots_with_cat_name[$key]['cat_name'] ?></td>
                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Edit') {
                                    ?>
                                            <td>
                                                <a href="javascript:void(0)" id="slotEdit" data-starttime="<?= $slot->start_time ?>" data-endtime="<?= $slot->end_time ?>" data-cat='<?= $slot->cat_id ?>' data-id="<?= $slot->id ?>" class="btn btn-info">Edit</a>
                                            <?php } else if ($action[$i] == 'Delete') { ?>
                                                <a href="<?= base_url($ma_url[$i] . '/' . $slot->id) ?>" id="slotDel" class="btn btn-danger">Delete</a>
                                            </td>
                                    <?php }
                                    } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade login-modal slotModal" id="slotEditModal" tabindex="-1" role="dialog" aria-labelledby="newsEditModalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <div class="form-group">

                        <label for="inputState">Category*</label>

                        <select id="inputCatEdit" class="form-control" name="cat_id">

                            <option value="">Choose...</option>

                            <?php foreach ($categories as $single_data) {

                                if (isset($cat_id) && $cat_id == $single_data->id) {

                                    $selected = "selected";
                                } else {

                                    $selected = "";
                                }

                            ?>

                                <option value="<?= $single_data->id ?>" <?= $selected  ?>><?= $single_data->label ?>

                                </option>

                            <?php  } ?>

                        </select>

                        <?php echo form_error('cat_id', '<div class="error">', '</div>'); ?>

                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" class="svg-inline--fa fa-clock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4 starttime" id="starttime" required name="start_time" placeholder="Start Time">
                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" class="svg-inline--fa fa-clock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4 endtime" id="endtime" required name="end_time" placeholder="End Time">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade login-modal slotModal" id="addSlotModal" tabindex="-1" role="dialog" aria-labelledby="addSlotModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="<?= base_url('master/addSlot') ?>">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <div class="form-group">

                        <label for="inputState">Category*</label>

                        <select id="inputState" required class="form-control" name="cat_id">

                            <option value="">Choose...</option>

                            <?php foreach ($categories as $single_data) {

                                if (isset($cat_id) && $cat_id == $single_data->id) {

                                    $selected = "selected";
                                } else {

                                    $selected = "";
                                }

                            ?>

                                <option value="<?= $single_data->id ?>"><?= $single_data->label ?>

                                </option>

                            <?php  } ?>

                        </select>

                        <?php echo form_error('cat_id', '<div class="error">', '</div>'); ?>

                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" class="svg-inline--fa fa-clock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4 starttime" required name="start_time" placeholder="Start Time">
                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" class="svg-inline--fa fa-clock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4 endtime" required name="end_time" placeholder="End Time">
                    </div>
                    <!--					<div class="form-group mb-4">-->
                    <!--						<label for="exampleFormControlSelect1">Example select</label>-->
                    <!--						<select class="form-control" name="status" id="exampleFormControlSelect1">-->
                    <!--							<option>Select Status</option>-->
                    <!--							--><?php //foreach($status as $key => $value){ 
                                                        ?>
                    <!--								<option value="-->
                    <? //= $key 
                    ?>
                    <!--">-->
                    <? //= $value 
                    ?>
                    <!--</option>-->
                    <!--							--><?php //} 
                                                        ?>
                    <!--						</select>-->
                    <!--					</div>-->
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>