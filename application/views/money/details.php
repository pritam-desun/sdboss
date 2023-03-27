<div class="layout-px-spacing">

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <h4> <?= $type ?> List</h4>
                <div class="table-responsive mb-4 mt-4">
                    <table id="moneyTable" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $t){ ?>
                            <tr>
                                <td><?= change_date_format($t->created_on, "F j, Y h:i A") ?></td>
                                <td><?= $t->full_name ?></td>
                                <td><?= $t->mobile ?></td>
                                <td><?= $t->amount ?></td>

                            </tr>
                            <?php    } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<script>

</script>