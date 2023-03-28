<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4">
                    <table id="dealer_tbl" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Game Name</th>
                                <th>Guessing Number</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($guessing as $key => $guessingrow) { ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $guessingrow->cat_name ?></td>
                                    <td><?= $guessingrow->number ?></td>
                                    <td><?= $guessingrow->guessing_date ?></td>
                                    <td>
                                        <a href="http://localhost:8080/counter/view/16" id="" class="btn btn-primary btn-sm" target="_blank">Edit</a> <a href="http://localhost:8080/counter/view/16" id="" class="btn btn-danger btn-sm" target="_blank">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>