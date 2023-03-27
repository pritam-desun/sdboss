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
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addCatModal" class="btn btn-dark ml-3">Add</a>
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
                                <th>Label</th>
                                <th>Category Name</th>
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
                            <?php foreach ($categories as $category) { ?>
                                <?php
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        if ($category->status == 'Y') {
                                            $url = base_url($ma_url[$i] . '/N/') . $category->id;
                                            $className = 'success';
                                            $btnTtext = "Active";
                                        } else {
                                            $url = base_url($ma_url[$i] . '/Y/') . $category->id;
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
                                    <td><?= $category->label ?></td>
                                    <td><?= $category->cat_name ?></td>
                                    <td>
                                        <img height="150px" width="200px" src="<?= base_url('uploads/category/' . $category->image) ?>" alt="">
                                    </td>
                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Edit') {
                                    ?>
                                            <td>
                                                <a href="javascript:void(0)" id="catEdit" data-label="<?= $category->label ?>" data-catname="<?= $category->cat_name ?>" data-image="<?= $category->image ?>" data-id="<?= $category->id ?>" class="btn btn-info">Edit</a>

                                            <?php } else if ($action[$i] == 'Delete') { ?>

                                                <a href="<?= base_url($ma_url[$i] . '/' . $category->id); ?>" id="catDel" class="btn btn-danger">Delete</a>
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

<div class="modal fade login-modal" id="editCatModal" tabindex="-1" role="dialog" aria-labelledby="editCatModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <h4 class="modal-title">Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <input type="hidden" class="form-control mb-2" name="prev_image" id="prev_image_modal" placeholder="Email">
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tag" class="svg-inline--fa fa-tag fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="label" id="label_modal" placeholder="Label Name">
                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dice" class="svg-inline--fa fa-dice fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M592 192H473.26c12.69 29.59 7.12 65.2-17 89.32L320 417.58V464c0 26.51 21.49 48 48 48h224c26.51 0 48-21.49 48-48V240c0-26.51-21.49-48-48-48zM480 376c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm-46.37-186.7L258.7 14.37c-19.16-19.16-50.23-19.16-69.39 0L14.37 189.3c-19.16 19.16-19.16 50.23 0 69.39L189.3 433.63c19.16 19.16 50.23 19.16 69.39 0L433.63 258.7c19.16-19.17 19.16-50.24 0-69.4zM96 248c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm128 128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm0-128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm0-128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm128 128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="cat_name" id="cat_name_modal" placeholder="Category Name">
                    </div>
                    <img src="" height="50px" width="100px" id="prv_image" alt="Category Image">
                    <div class="custom-file mb-4">
                        <input type="file" name="attachment" class="custom-file-input" id="customFile">
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

<div class="modal fade login-modal" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="addCatModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <h4 class="modal-title">Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="<?= base_url('master/addCat') ?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tag" class="svg-inline--fa fa-tag fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="label" id="" placeholder="Label Name">
                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dice" class="svg-inline--fa fa-dice fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M592 192H473.26c12.69 29.59 7.12 65.2-17 89.32L320 417.58V464c0 26.51 21.49 48 48 48h224c26.51 0 48-21.49 48-48V240c0-26.51-21.49-48-48-48zM480 376c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm-46.37-186.7L258.7 14.37c-19.16-19.16-50.23-19.16-69.39 0L14.37 189.3c-19.16 19.16-19.16 50.23 0 69.39L189.3 433.63c19.16 19.16 50.23 19.16 69.39 0L433.63 258.7c19.16-19.17 19.16-50.24 0-69.4zM96 248c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm128 128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm0-128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm0-128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm128 128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="cat_name" id="" placeholder="Category Name">
                    </div>
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
<div class="modal fade login-modal" id="editCatModal" tabindex="-1" role="dialog" aria-labelledby="editCatModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <h4 class="modal-title">Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <input type="hidden" class="form-control mb-2" name="prev_image" id="prev_image_modal" placeholder="Email">
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tag" class="svg-inline--fa fa-tag fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="label" id="label_modal" placeholder="Label Name">
                    </div>
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dice" class="svg-inline--fa fa-dice fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path fill="currentColor" d="M592 192H473.26c12.69 29.59 7.12 65.2-17 89.32L320 417.58V464c0 26.51 21.49 48 48 48h224c26.51 0 48-21.49 48-48V240c0-26.51-21.49-48-48-48zM480 376c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm-46.37-186.7L258.7 14.37c-19.16-19.16-50.23-19.16-69.39 0L14.37 189.3c-19.16 19.16-19.16 50.23 0 69.39L189.3 433.63c19.16 19.16 50.23 19.16 69.39 0L433.63 258.7c19.16-19.17 19.16-50.24 0-69.4zM96 248c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm128 128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm0-128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm0-128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24zm128 128c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="cat_name" id="cat_name_modal" placeholder="Category Name">
                    </div>
                    <img src="" height="50px" width="100px" id="prv_image" alt="Category Image">
                    <div class="custom-file mb-4">
                        <input type="file" name="attachment" class="custom-file-input" id="customFile">
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