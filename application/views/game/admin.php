<?php
$url = $this->uri->uri_string();

$action = [];

$ma_url = [];

$ac = $this->session->user['ac'];

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
                <h4> Game List</h4>

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
                                <th>ID</th>

                                <?php
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        echo '<th>Status</th>';
                                    }
                                }
                                ?>

                                <th>Name</th>

                                <th>Category Name</th>

                                <th>Image</th>

                                <th>Slot</th>

                                <th>Play Game</th>
                                <th>MInimum Coin</th>

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

                            <?php $i = 1;
                            foreach ($game as $single_data) { ?>

                                <?php
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        if ($single_data->status == 'Y') {

                                            $url = base_url($ma_url[$i] . '/N/') . $single_data->id;

                                            $className = 'success';

                                            $btnTtext = "Active";
                                        } else {

                                            $url = base_url($ma_url[$i] . '/Y/') . $single_data->id;

                                            $className = 'danger';

                                            $btnTtext = "Inactive";
                                        }
                                    }
                                }

                                ?>

                                <tr>
                                    <td><?= $i ?></td>
                                    <?php
                                    for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Status') {
                                    ?>
                                            <td>

                                                <a href="<?= $url ?>" class="btn btn-<?= $className ?>"> <?= $btnTtext ?> </a>

                                            </td>
                                    <?php }
                                    }
                                    ?>

                                    <td><?= $single_data->name ?></td>

                                    <td><?= $single_data->cat_name ?></td>

                                    <td>

                                        <img height="150px" width="200px" src="<?= base_url('uploads/game/' . $single_data->image) ?>" alt="">

                                    </td>

                                    <td><?= $single_data->start_time . " - " . $single_data->end_time ?></td>

                                    <td><?php

                                        $day_array = json_decode($single_data->play_day);



                                        $day = implode(", ", $day_array);

                                        echo $day;

                                        ?></td>
                                    <td><?= $single_data->minum_coin ?></td>

                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Edit') {
                                    ?>
                                            <td>

                                                <a href="<?= base_url($ma_url[$i]) . '' . $single_data->id ?>" class="btn btn-info my-1">Edit</a><br>

                                                <?php } else if ($action[$i] == 'Delete') { ?>

                                                    <a href="<?= base_url($ma_url[$i]) . '/' . $single_data->id ?>" class="btn btn-danger my-1">Delete</a>
 
                                            </td>
                                    <?php }
                                    } ?>

                                </tr>

                            <?php $i++;
                            } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



</div>