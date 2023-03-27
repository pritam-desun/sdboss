<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <?php if ($this->session->flashdata('msg')) { ?>
                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
                </div>
            <?php } ?>
            <nav class="breadcrumb-two" aria-label="breadcrumb">
                <ol class="breadcrumb" style="display: inline-block; margin-right: 20px">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Total Balance : </a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);"><strong><?= $total_amount->balance ? number_format($total_amount->balance) : 0 ?></strong></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);"><i class="fas fa-rupee-sign"></i></a></li>
                </ol>
                <ol class="breadcrumb" style="display: inline-block">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Total User : </a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);"><strong><?= $total_user->customers ?></strong></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);"><i class="fas fa-user"></i></a></li>
                </ol>
            </nav>

            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="account_list_tbl" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Counter ID</th>
                                <th>Distributor</th>
                                <th>Dealer</th>
                                <th>Counter</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Enter password" name="password" minlength="5">
                    <input type="hidden" id="user_id" name="user_id">
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <input type="submit" name="passwordChange" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function changePass(val) {
        const user = document.getElementById('user_id');
        user.value = val;
    }
</script>