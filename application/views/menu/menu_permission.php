<style>
    .table>tbody>tr>td {
        vertical-align: text-top !important;
    }
</style>





<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <?php if ($this->session->flashdata('msg_permission')) { ?>

                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <p class="alert-heading"> <?= $this->session->flashdata('msg_permission') ?> </p>

                </div>

            <?php } ?>

            <div class="widget-content widget-content-area br-6">

                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">

                    <div class="form-group">

                        <label for="inputUsers">Users</label>

                        <?php
                        if (isset($admin)) {
                            if ($admin['user_type'] == 2) { ?>

                                <input type="hidden" class="form-control" name="user_ref" value="2" readonly>
                                <input type="text" class="form-control" name="username" value="Admin" readonly>

                            <?php } else if ($admin['user_type'] == 3) { ?>

                                <input type="hidden" class="form-control" name="user_ref" value="3" readonly>
                                <input type="text" class="form-control" name="username" value="<?= $admin['full_name']; ?>" readonly>

                            <?php } else if ($admin['user_type'] == 4) { ?>
                                <input type="hidden" class="form-control" name="user_ref" value="4" readonly>
                                <input type="text" class="form-control" name="username" value="<?= $admin['full_name']; ?>" readonly>
                            <?php  }
                        } else { ?>

                            <select id="inputUsers" class="form-control" name="user_ref" required>

                                <option value="">Choose...</option>

                                <?php foreach ($users as $user) { ?>

                                    <option value="<?= $user['id']; ?>"><?= $user['full_name']; ?></option>

                                <?php  } ?>

                            </select>

                        <?php } ?>

                        <?php echo form_error('user_ref', '<div class="error">', '</div>'); ?>

                    </div>

                    <table class="table">
                        <thead>
                            <th>Parent Menu</th>
                            <th>Child Menu</th>
                        </thead>

                        <?php $i = 1;
                        foreach ($parent_menu as $pm) :

                            $checked = '';

                            if (isset($apm)) {
                                (in_array($pm['id'], $apm)) ? $checked = 'checked' : $checked = '';
                            }
                        ?>
                            <tr>
                                <td valign="top">
                                    <input <?= $checked; ?> type="checkbox" class="parent_menu" id="pm<?= $i; ?>" value="<?= $pm['id']; ?>" name="parent_menu[]" onchange="parentMenu(<?= $i; ?>)">&nbsp; &nbsp;<?= $pm['menu_name']; ?>&nbsp; &nbsp;&nbsp; &nbsp;
                                </td>
                                <?php
                                $child_menu = $this->db->get_where('menu', ['is_parent' => 'N', 'parent_menu' => $pm['id']])->result_array();

                                // echo "<pre>"; print_r($child_menu);

                                $childs[$i] = count($child_menu);

                                // echo "<pre>"; print_r($childs[$i]);

                                $j = 1;
                                ?>
                                <td>
                                    <ul>
                                        <?php
                                        foreach ($child_menu as $cm) :

                                            $checked = '';

                                            if (isset($acm)) {
                                                (in_array($cm['id'], $acm)) ? $checked = 'checked' : $checked = '';
                                            }

                                            $name = "";

                                            if (empty($cm['menu_name']) && $cm['Type'] == 'category') {
                                                $cat_name = $this->db->get_where('category', ['id' => $cm['ref_id']])->row_array();

                                                $name = $cat_name['cat_name'];
                                            } else if (!empty($cm['menu_name'])) {
                                                $name = $cm['menu_name'];
                                            }

                                        ?>
                                            <li style="list-style: none;">
                                                <br>
                                                <input <?= $checked; ?> type="checkbox" class="child_menu" id="cm<?= $i; ?><?= $j; ?>" value="<?= $cm['id']; ?>" name="child_menu[]" onchange="childMenu(<?= $j; ?>)">&nbsp; &nbsp;<?= $name; ?>&nbsp; &nbsp;&nbsp; &nbsp;
                                                <br>
                                                <?php
                                                $actions = $this->db->get_where('menu_action', ['menu_id' => $cm['id']])->result_array();

                                                $action[$j] = count($actions);

                                                $k = 1;
                                                ?>
                                                <div style="list-style: none;padding-left: 200px;">
                                                    <?php
                                                    foreach ($actions as $ac) :

                                                        $checked = '';

                                                        if (isset($aac)) {
                                                            (in_array($ac['id'], $aac)) ? $checked = 'checked' : $checked = '';
                                                        }
                                                    ?>
                                                        <input <?= $checked; ?> type="checkbox" class="action" id="ac<?= $i; ?><?= $j; ?><?= $k; ?>" value="<?= $ac['id']; ?>" name="action[]" onchange="action(<?= $k; ?>)">&nbsp; &nbsp;<?= $ac['action_name']; ?>&nbsp; &nbsp;&nbsp; &nbsp;
                                                    <?php $k++;
                                                    endforeach; ?>
                                                </div>
                                            </li>
                                        <?php $j++;
                                        endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    </table>

                    <button type="submit" class="btn btn-primary mt-3">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    function parentMenu(i) {

        var child_length = [];

        // var action_length = [];

        $(`#pm${i}`).change(function() {
            $(this).prop('checked', !$(this).prop('checked'));
        });

        child_length = <?php echo json_encode($childs); ?>

        // console.log(child_length);

        if ($(`#pm${i}`).prop('checked', !$(this).prop('checked'))) {

            for (var j = 1; j <= child_length[i]; j++) {

                $(`#cm${i}${j}`).prop('checked', !$(this).prop('checked'));
            }
        }
    }

    // function childMenu(j) {

    //     // console.log('CHILD MENU');

    //     var action_length = [];

    //     action_length = <?php echo json_encode($action); ?>

    //     console.log(action_length);

    //     $(`#cm${j}`).change(function() {
    //         $(this).prop('checked', !$(this).prop('checked'));
    //     });


    // }
</script>