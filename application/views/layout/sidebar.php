<?php
/* echo "<pre>";
print_r($this->session->user);
die('sess'); */

if ($this->session->has_userdata('user')) {

    $parent = $this->session->user['pm'];

    $child = $this->session->user['cm'];

    $parent_menu = $this->db->query("SELECT * FROM `menu` WHERE id IN($parent)")->result_array();


    // echo "<pre>";
    // print_r($parent_menu);
    // echo "<br>";
    // echo $parent;
    // die();
?>
    <div class="sidebar-wrapper sidebar-theme">
        <nav id="sidebar">
            <div class="shadow-bottom"></div>
            <ul class="list-unstyled menu-categories" id="accordionExample">
                <li class="menu">
                    <!--static menu add area  -->

                    <!-- -----end--------------->
                    <?php
                    foreach ($parent_menu as $pm) {
                        $cm = $this->db->get_where('menu', ['parent_menu' => $pm['id'], 'is_parent' => 'N'])->result_array();
                    ?>
                        <a href="<?= (empty($cm)) ? base_url($pm['url'])  : "#{$pm['slug']}"; ?>" data-toggle="<?= (!empty($cm)) ? "collapse" : ""; ?>" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <?= $pm['icon']; ?>
                                <span><?= $pm['menu_name']; ?></span>
                            </div>
                            <div>
                                <?= (!empty($cm)) ? "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-right'>
                                    <polyline points='9 18 15 12 9 6'></polyline>
                                </svg>" : ""; ?>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="<?= (!empty($cm)) ? "{$pm['slug']}" : ''; ?>" data-parent="#accordionExample">
                            <?php
                            // echo "<pre>"; print_r($cm);

                            foreach ($cm as $child_menu) {
                                if (in_array($child_menu['id'], $child)) {

                                    $name = "";
                                    if (empty($child_menu['menu_name']) && $child_menu['Type'] == 'category') {
                                        $cat_name = $this->db->get_where('category', ['id' => $child_menu['ref_id']])->row_array();
                                        $name = (isset($cat_name['cat_name']) ? $cat_name['cat_name'] : '');
                                    } else if (!empty($child_menu['menu_name'])) {
                                        $name = $child_menu['menu_name'];
                                    }
                            ?>
                                    <li>
                                        <a href="<?= base_url($child_menu['url']) ?>"> <?= $name; ?> </a>
                                    </li>
                            <?php }
                            } ?>
                        </ul>
                    <?php } ?>

                    <?php if ($this->session->user['user_type'] == (1)) { ?>
                        <!----------------------------------- Employee --------------------------------------------->

                        <a href="#employee" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-circle-down" class="svg-inline--fa fa-chevron-circle-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z">
                                    </path>
                                </svg>
                                <span>Employee</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>

                        <ul class="collapse submenu list-unstyled" id="employee" data-parent="#accordionExample">
                            <li>
                                <a href="<?= base_url('employee/add') ?>"> Add Employee </a>
                            </li>
                            <li>
                                <a href="<?= base_url('employee/view') ?>"> View Employee </a>
                            </li>
                        </ul>

                        <!--------------- Menu permission -------------------------->

                        <a href="#menu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-circle-down" class="svg-inline--fa fa-chevron-circle-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z">
                                    </path>
                                </svg>
                                <span>Menu</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>

                        <ul class="collapse submenu list-unstyled" id="menu" data-parent="#accordionExample">
                            <li>
                                <a href="<?= base_url('menu/menu') ?>"> Create Menu </a>
                            </li>
                            <li>
                                <a href="<?= base_url('menu/action') ?>"> Create Action </a>
                            </li>
                            <li>
                                <a href="<?= base_url('menu/menu_permission') ?>"> Menu Permission </a>
                            </li>
                        </ul>

                        <!-------------------- Distributor---------------------------------- -->
                        <a href="#distributor" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-circle-down" class="svg-inline--fa fa-chevron-circle-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z">
                                    </path>
                                </svg>
                                <span>Distributor</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>

                        <ul class="collapse submenu list-unstyled" id="distributor" data-parent="#accordionExample">
                            <li>
                                <a href="<?= base_url('distributor/add') ?>"> Add Distributor </a>
                            </li>
                            <li>
                                <a href="<?= base_url('distributor/view') ?>"> View Dsitributor </a>
                            </li>
                        </ul>
                        <!------------ Dealer----------------------------------------- -->
                        <a href="#Dealer" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-circle-down" class="svg-inline--fa fa-chevron-circle-down fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zM273 369.9l135.5-135.5c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L256 285.1 154.4 183.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L239 369.9c9.4 9.4 24.6 9.4 34 0z">
                                    </path>
                                </svg>
                                <span>Dealer</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>

                        <ul class="collapse submenu list-unstyled" id="Dealer" data-parent="#accordionExample">
                            <li>
                                <a href="<?= base_url('dealer/add') ?>"> Add Dealer </a>
                            </li>
                            <li>
                                <a href="<?= base_url('dealer/view') ?>"> View Dealer </a>
                            </li>
                        </ul>

                    <?php } ?>
                </li>
            </ul>
            <!-- <div class="shadow-bottom"></div> -->
        </nav>
    </div>
<?php
} else {
    die("Get Outtttttttttttttt !!!");
}
?>