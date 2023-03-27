<!-- For Super A -->
<?php if ($this->session->user['user_type'] == 1) { ?>
	<div class="layout-px-spacing">
		<div class="row">
			<div id="flInlineForm" class="col-lg-12 layout-spacing layout-top-spacing">
				<div class="statbox widget box box-shadow" id="reload">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Send Money To Distributor or Dealer</h4>
								<?php if ($this->session->flashdata('msg')) { ?>
									<div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
									</div>
								<?php } ?>
							</div>

						</div>
					</div>
					<div class="widget-content widget-content-area">
						<form class="" method="post" autocomplete="off">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="user_type">Select User Type</label>
										<select id="user_type" class="form-control" required="" onchange="get_user(this.value)" name="user_type">
											<option value="">Choose...</option>
											<option value="3">Distributor</option>
											<option value="4">Dealer</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label class="" for="user_id">User</label>
										<select id="user_id" class="form-control" onchange="get_wallet_balance(this.value)" required="" name="user_id">
											<option value="">Select User Type First</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4 hide_div d-none">
									<div class="form-group">
										<label for="wallet_balance">Wallet</label>
										<input type="text" class="form-control" readonly id="wallet_balance" name="wallet_balance" placeholder="Wallet Balance">
									</div>
								</div>
								<div class="col-lg-4 hide_div d-none">
									<div class="form-group">
										<label for="amount">Amount</label>
										<input type="text" required class="form-control" oninput="this.value=value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')" name="amount" id="amount" placeholder="Amount">
									</div>
								</div>
								<div class="col-lg-12 text-center hide_div d-none">
									<button type="submit" class="btn btn-primary mb-2">Submit</button>
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!-- ///////// -->
<!-- For Distributor -->
<?php if ($this->session->user['user_type'] == 3) { ?>
	<div class="layout-px-spacing">
		<div class="row">
			<div id="flInlineForm" class="col-lg-12 layout-spacing layout-top-spacing">
				<div class="statbox widget box box-shadow" id="reload">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Send Money To Dealer</h4>
								<?php if ($this->session->flashdata('msg')) { ?>
									<div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
									</div>
								<?php } ?>
							</div>

						</div>
					</div>
					<div class="widget-content widget-content-area">
						<form class="" method="post" autocomplete="off">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="user_type">Dealer</label>
										<select id="user_type" class="form-control" required="" onchange="get_user(this.value)" name="user_type">
											<option value="" disabled>Choose...</option>
											<option value="3" disabled>Distributor</option>
											<option value="4" selected>Dealer</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label class="" for="user_id">Dealer Name</label>
										<select id="user_id" class="form-control" onchange="get_wallet_balance(this.value)" required="" name="user_id">
											<option value="">Select User Type First</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4 hide_div d-none">
									<div class="form-group">
										<label for="wallet_balance">Wallet</label>
										<input type="text" class="form-control" readonly id="wallet_balance" name="wallet_balance" placeholder="Wallet Balance">
									</div>
								</div>
								<div class="col-lg-4 hide_div d-none">
									<div class="form-group">
										<label for="amount">Amount</label>
										<input type="text" required class="form-control" oninput="this.value=value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')" name="amount" id="amount" placeholder="Amount">
									</div>
								</div>
								<div class="col-lg-12 text-center hide_div d-none">
									<button type="submit" class="btn btn-primary mb-2">Submit</button>
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!-- ///////// -->
<!-- For Dealer -->
<?php if ($this->session->user['user_type'] == 4) { ?>
	<div class="layout-px-spacing">
		<div class="row">
			<div id="flInlineForm" class="col-lg-12 layout-spacing layout-top-spacing">
				<div class="statbox widget box box-shadow" id="reload">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Send Money To Counter</h4>
								<?php if ($this->session->flashdata('msg')) { ?>
									<div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
									</div>
								<?php } ?>
							</div>

						</div>
					</div>
					<div class="widget-content widget-content-area">
						<form class="" method="post" autocomplete="off">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label class="" for="counter_id">Counter Name</label>
										<select id="counter_id" class="form-control" onchange="get_counter_wallet_balance(this.value)" required="" name="counter_id">
											<option value="">Choose...</option>
											<?php foreach ($counters as $key => $counter) { ?>
												<option value="<?= $counter->id ?>"><?= $counter->full_name ?> (<?= $counter->cust_code ?>)</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-lg-4 hide_div d-none">
									<div class="form-group">
										<label for="wallet_balance">Wallet</label>
										<input type="text" class="form-control" readonly id="wallet_balance" name="wallet_balance" placeholder="Wallet Balance">
									</div>
								</div>
								<div class="col-lg-4 hide_div d-none">
									<div class="form-group">
										<label for="amount">Amount</label>
										<input type="text" required class="form-control" oninput="this.value=value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')" name="amount" id="amount" placeholder="Amount">
									</div>
								</div>
								<div class="col-lg-12 text-center hide_div d-none">
									<button type="submit" class="btn btn-primary mb-2">Submit</button>
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<!-- ///////// -->