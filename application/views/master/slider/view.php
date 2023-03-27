<?php
$url = $this->uri->uri_string();

$action = [];

$ma_url = [];

$ac = $this->session->user['ac'];
// echo '<pre>'; print_r($this->session->all_userdata());exit;
// echo "<pre>";
// print_r($this->session->user['user_type']);
// die("ac");

// var_dump($acs);
// die('acs');

if ($this->session->user['ac'] != NULL) {

    $menu_actions = $this->db->query("SELECT m.id, m.url, ma.* FROM menu AS m JOIN menu_action as ma ON m.id = ma.menu_id WHERE m.url = '$url'")->result_array();

    // echo "<pre>";
    // print_r($menu_actions); #die('_ma');

    foreach ($menu_actions as $ma) {
        if (in_array($ma['id'], $ac)) {
            array_push($action, $ma['action_name']);

            array_push($ma_url, $ma['action_url']);
        }
    }
} else {
    $action[] = NULL;
}

// echo "<pre>";
// print_r($action); #die("action");

// echo "<pre>";
// print_r($ma_url);
// die("action");

?>
<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <?php
                for ($i = 0; $i < count($action); $i++) {
                    if ($action[$i] == 'ADD') {
                ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addSliderModal" class="btn btn-dark ml-3">Add</a>
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
                    <table id="account_trans" class="table table-hover non-hover" style="width:100%">
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
                                <th>Image</th>
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
                            <?php foreach ($sliders as $slider) { ?>
                                <?php
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        if ($slider->status == 'Y') {
                                            $url = base_url($ma_url[$i] . '/N/') . $slider->id;
                                            $className = 'success';
                                            $btnTtext = "Active";
                                        } else {
                                            $url = base_url($ma_url[$i] . '/Y/') . $slider->id;
                                            $className = 'danger';
                                            $btnTtext = "Inactive";
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Status') {
                                            if ($this->session->user['user_type'] == 1) { ?>
                                                <td>
                                                    <a href="<?= $url ?>" class="btn btn-<?= $className ?>"> <?= $btnTtext ?> </a>
                                                </td>
                                    <?php }
                                        }
                                    } ?>
                                    <td>
                                        <img height="150px" width="200px" src="<?= base_url('uploads/carousel/' . $slider->attachment) ?>" alt="">
                                    </td>
                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Edit') {
                                    ?>
                                            <td>
                                                <a href="javascript:void(0)" id="sliderEdit" data-image="<?= $slider->attachment ?>" data-id="<?= $slider->id ?>" class="btn btn-info">Edit</a>

                                            <?php } else if ($action[$i] == 'Delete') { ?>

                                                <a href="<?= base_url($ma_url[$i] . '/' . $slider->id) ?>" id="sliderDel" class="btn btn-danger">Delete</a>

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

<div class="modal fade login-modal" id="sliderEditModal" tabindex="-1" role="dialog" aria-labelledby="sliderEditModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <h4 class="modal-title">Slider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <input type="hidden" class="form-control mb-2" name="prev_image" id="prev_image" placeholder="Email">
                    <img height="150px" width="200px" src="" id="img" alt="Image">
                    <div class="custom-file mb-4">
                        <input type="file" name="attachment" required class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
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

<div class="modal fade login-modal" id="addSliderModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <h4 class="modal-title">Slider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="<?= base_url('master/addSlider') ?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <div class="custom-file mb-4">
                        <input type="file" name="attachment" required class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
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