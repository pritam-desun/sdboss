<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
        <form class="form-inline justify-content-center" method="post" >
            <label class="sr-only" for="inlineFormInputName2">Category</label>
            <select id="inputState" class="form-control mb-2 mr-sm-2" name="cat_id">
                    <option value="">Choose...</option>
                        <?php foreach($cats as $cat){ ?>
                            <option value="<?= $cat->id ?>"><?= $cat->label ?></option>
                         <?php } ?>   
                    </option>
                </select>
                <label class="sr-only" for="inlineFormInputGroupUsername2">Date</label>
                <input type="text" name="date" class="form-control mb-2 mr-sm-2" placeholder="Select Date" id="rangeCalendarFlatpickr">
                </select>    

            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>
        </div>
    </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <div class="widget-content widget-content-area br-6">

                <?php if($this->session->flashdata('msg')){ ?>

                <div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>

                </div>

                <?php } ?>

                <div class="table-responsive mb-4 mt-4">
                    <h3><?= $cats[0]->label ?></h3>
                    <table id="dataTables" class="table table-hover non-hover" style="width:100%">

                        <thead>

                            <tr>
                                <!-- <th><?= $cats[0]->label ?></th> -->
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Total Bid Amount</th>
                                <th>Commision</th>
                            </tr>

                        </thead>

                        <tbody>

                           <?php foreach($main as $cust_data) {
                               ?>
                                <tr>
                                    <!-- <td>Baji</td> -->
                                    <td><?= $cust_data['full_name'] ?></td>
                                    <td><?= $cust_data['mobile'] ?></td>
                                    <td><?= $cust_data['total_bid'] ? $cust_data['total_bid'] : 0 ?></td>
                                    <td><?= $cust_data['commision'] ?></td>
                                </tr>
                          <?php } ?>              
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </div>



</div>