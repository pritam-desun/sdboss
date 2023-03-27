<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <?= get_bradecrumb() ?>
                    </nav>

                </div>
            </li>
        </ul>
        <ul class="navbar-nav flex-row ml-auto ">
            <!-- <li class="nav-item more-dropdown" style="padding-right: 24px; color: #fff">
                <?php
                /* $query = $this->db
                    ->select(['sms_qty'])
                    ->where(['is_active' => 1])
                    ->get('tbl_sms_settings');

                $data = $query->row_array(); */
                ?>
                SMS Credits: <strong>< ?php echo $data['sms_qty']; ?></strong>
            </li> -->
            <?php if ($this->session->user['user_type'] == 3 or $this->session->user['user_type'] == 4) { ?>
                <li class="nav-item more-dropdown" style="padding-right: 24px; color: #fff">
                    <?php
                    $wallet_balance = $this->db->get_where('users', array('user_id' => $this->session->user['user_id']))->row()->wallet;
                    ?>
                    Wallet Balance: <strong><?= $wallet_balance ?></strong>
                </li>
            <?php } ?>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->