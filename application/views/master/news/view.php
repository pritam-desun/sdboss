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

// echo "<pre>"; print_r($ma_url); die("action");

?>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <?php
                for ($i = 0; $i < count($action); $i++) {
                    if ($action[$i] == 'ADD') {
                ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#addNewsModal" class="btn btn-dark ml-3">Add</a>
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
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        echo '<th>Status</th>';
                                    }
                                }
                                ?>
                                <th>News</th>
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
                            <?php foreach ($newses as $news) { ?>
                                <?php
                                for ($i = 0; $i < count($action); $i++) {
                                    if ($action[$i] == 'Status') {
                                        if ($news->status == 'Y') {
                                            $url = base_url($ma_url[$i] . '/N/') . $news->id;
                                            $className = 'success';
                                            $btnTtext = "Active";
                                        } else {
                                            $url = base_url($ma_url[$i] . '/Y/') . $news->id;
                                            $className = 'danger';
                                            $btnTtext = "Inactive";
                                        }
                                    }
                                }
                                ?>
                                <tr>
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
                                    <td><?= $news->news ?></td>
                                    <?php for ($i = 0; $i < count($action); $i++) {
                                        if ($action[$i] == 'Edit') {
                                    ?>
                                            <td>
                                                <a href="javascript:void(0)" id="newsEdit" data-news="<?= $news->news ?>" data-id="<?= $news->id ?>" class="btn btn-info">Edit</a>

                                            <?php } else if ($action[$i] == 'Delete') { ?>

                                                <a href="<?= base_url($ma_url[$i] . '/' . $news->id); ?>" id="newsDel" class="btn btn-danger">Delete</a>
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

<div class="modal fade login-modal" id="newsEditModal" tabindex="-1" role="dialog" aria-labelledby="newsEditModalModalLabel" aria-hidden="true">
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
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="newspaper" class="svg-inline--fa fa-newspaper fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M552 64H112c-20.858 0-38.643 13.377-45.248 32H24c-13.255 0-24 10.745-24 24v272c0 30.928 25.072 56 56 56h496c13.255 0 24-10.745 24-24V88c0-13.255-10.745-24-24-24zM48 392V144h16v248c0 4.411-3.589 8-8 8s-8-3.589-8-8zm480 8H111.422c.374-2.614.578-5.283.578-8V112h416v288zM172 280h136c6.627 0 12-5.373 12-12v-96c0-6.627-5.373-12-12-12H172c-6.627 0-12 5.373-12 12v96c0 6.627 5.373 12 12 12zm28-80h80v40h-80v-40zm-40 140v-24c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H172c-6.627 0-12-5.373-12-12zm192 0v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-144v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0 72v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="news" id="news_modal" placeholder="News">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade login-modal" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" id="loginModalLabel">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
            <div class="modal-body">
                <form class="mt-0" method="post" action="<?= base_url('master/addNews') ?>">
                    <input type="hidden" class="form-control mb-2" name="id" id="id_modal" placeholder="Email">
                    <div class="form-group">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="newspaper" class="svg-inline--fa fa-newspaper fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M552 64H112c-20.858 0-38.643 13.377-45.248 32H24c-13.255 0-24 10.745-24 24v272c0 30.928 25.072 56 56 56h496c13.255 0 24-10.745 24-24V88c0-13.255-10.745-24-24-24zM48 392V144h16v248c0 4.411-3.589 8-8 8s-8-3.589-8-8zm480 8H111.422c.374-2.614.578-5.283.578-8V112h416v288zM172 280h136c6.627 0 12-5.373 12-12v-96c0-6.627-5.373-12-12-12H172c-6.627 0-12 5.373-12 12v96c0 6.627 5.373 12 12 12zm28-80h80v40h-80v-40zm-40 140v-24c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H172c-6.627 0-12-5.373-12-12zm192 0v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-144v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0 72v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12z">
                            </path>
                        </svg>
                        <input type="text" class="form-control mb-4" required name="news" id="news_modal" placeholder="News">
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