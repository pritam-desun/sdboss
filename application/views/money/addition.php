<div class="container">
	<div class="container">
		<div class="row">
		<div id="flInlineForm" class="col-lg-12 layout-spacing layout-top-spacing">
		<div class="statbox widget box box-shadow" id="reload">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Addition</h4>
						<?php if($this->session->flashdata('msg')){ ?>
							<div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
							</div>
						<?php } ?>
					</div>

				</div>
			</div>
			<div class="widget-content widget-content-area">
				<form class="form-inline justify-content-center" method="post" autocomplete="off">
					<label class="sr-only" for="mobile_no">Mobile</label>
					<div class="input-group mb-2 mr-sm-2">
						<div class="input-group-prepend">
							<div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
						</div>
						<input type="text" class="form-control" name="mobile" id="mobile_no" onkeyup="getCustomerDetails(this.value)" placeholder="Mobile No">
					</div>
					<label class="sr-only" for="customer_name" id="customer_name_label">Customer Name</label>
					<div class="input-group mb-2 mr-sm-2" id="customer_name_div">
						<div class="input-group-prepend">
							<div class="input-group-text"><i class="far fa-user"></i></div>
						</div>
						<input type="text" class="form-control" readonly id="customer_name" placeholder="Customer Name">
						<input type="hidden" name="customer_id" id="customer_id" value="">
						<input type="hidden" name="current_amount" id="current_amount" value="">
						<input type="hidden" name="type" id="type" value="CR">
					</div>
					<label class="sr-only" for="amount" id="amount_label">Amount</label>
					<div class="input-group mb-2 mr-sm-2" id="amount_div">
						<div class="input-group-prepend">
							<div class="input-group-text"><i class="fas fa-rupee-sign"></i></div>
						</div>
						<input type="text" required class="form-control" name="amount" id="amount" placeholder="Amount">
					</div>
					<button type="submit" class="btn btn-primary mb-2" id="addition_submit">Submit</button>
				</form>
				<div class="alert alert-danger mb-4" role="alert" id="danger_Alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
					<strong>oops!</strong> Wrong Mobile Number.</button>
				</div>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
