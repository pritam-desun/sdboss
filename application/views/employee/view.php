<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
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
                                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
                                    echo '<th>Status</th>';
                                }
                                ?>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Create Date</th>
                                <?php
                                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
                                    echo '<th>Action</th>';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employee as $emp) {
                                if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) {
                                    if ($emp['is_active'] == 1) {
                                        $url = base_url('employee/empStatus/' . 0 . '/') . $emp['id'];
                                        $className = 'success';
                                        $btnTtext = "Active";
                                    } else {
                                        $url = base_url('employee/empStatus/' . 1 . '/') . $emp['id'];
                                        $className = 'danger';
                                        $btnTtext = "Inactive";
                                    }
                                }
                            ?>
                                <tr>
                                    <?php if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) { ?>
                                        <td>
                                            <a href="<?= $url ?>" class="btn btn-<?= $className ?>"> <?= $btnTtext ?> </a>
                                        </td>
                                    <?php } ?>
                                    <td><?= $emp['full_name']; ?></td>
                                    <td><?= $emp['email']; ?></td>
                                    <td><?= $emp['mobile']; ?></td>
                                    <td><?= $emp['created_on']; ?></td>
                                    <?php if ($this->session->user['user_type'] == 1 || $this->session->user['user_type'] == 2) { ?>
                                        <td>


                                            <?php if ($emp['username'] == 'admin') { ?>

                                                <a href="<?= base_url('Menu/menu_permission/') . $emp['id']; ?>" class="btn btn-warning btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="primary" class="bi bi-gear" viewBox="0 0 16 16">
                                                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                                                    </svg></a>

                                            <?php } else { ?>



                                                <a href="<?= base_url('Menu/menu_permission/') . $emp['id']; ?>" class="btn btn-warning btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="primary" class="bi bi-gear" viewBox="0 0 16 16">
                                                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                                                    </svg></a>

                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#empDel').on('click', function() {
            alert('Are you want to delete employee');
        });
    });
</script> -->