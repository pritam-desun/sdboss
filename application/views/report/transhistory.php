<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
    
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
        <form class="form-inline justify-content-center" method="post" >
            <label class="sr-only" for="inlineFormInputName2">Category</label>
            <div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
						</div>
						<input type="text" class="form-control" pattern="\d*" minlength="10" maxlength="10" name="mobile" id="mobile_no" placeholder="Mobile No">
					</div>
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
                <h4>  Transaction History </h4>
                <div class="table-responsive mb-4 mt-4">
                    <table id="dataTable" class="table table-hover non-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL no.</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($transactions as $key => $value){ ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= date("d-m-Y h:i A", strtotime($value->created_on)); ?></td>
                                    <td><?= $value->purpose; ?></td>
                                    <td><?= $value->type; ?></td>
                                    <td><?= $value->amount; ?></td>
                                </tr>
                            <?php } ?>    
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



</div>