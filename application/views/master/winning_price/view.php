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
                        <a href="<?= base_url('master/addprice') ?>" class="btn btn-dark ml-3">Add</a>
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

                    <table id="dataTable" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>

                                <th>Category</th>

                                <th>Type</th>

                                <th>Calculation Type</th>

                                <th>Value</th>

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

                            <?php foreach ($price as $single_data) {

                            ?>
                                <tr>

                                    <td><?= $single_data->cat_name ?></td>

                                    <td><?= $single_data->game_type ?></td>

                                    <td><?= $single_data->type ?></td>

                                    <td><?= $single_data->value ?></td>

                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Edit') {
                                    ?>
                                            <td>

                                                <a href="<?= base_url($ma_url[$i] . '/' . $single_data->id);?>" class="btn btn-info">Edit</a>

                                                <?php } else if ($action[$i] == 'Delete') { ?>

                                                    <a href="<?= base_url($ma_url[$i] . '/' . $single_data->id);?>" class="btn btn-danger">Delete</a>   
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