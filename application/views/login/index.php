<?php
defined('BASEPATH') or exit('No direct script access allowed');

$query = $this->db->query("select *  from settings where id=1");
$settings = $query->row();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>Login | <?= $settings->app_name ?> </title>
	<link rel="icon" type="image/x-icon" href="<?= base_url('backend/') ?>assets/img/favicon.ico" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
	<link href="<?= base_url('backend/') ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('backend/') ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('backend/') ?>assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>assets/css/forms/theme-checkbox-radio.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('backend/') ?>assets/css/forms/switches.css">
</head>

<body>


	<div class="container outer">
		<div class="form-form">
			<div class="form-form-wrap">
				<div class="form-container">
					<div class="form-content">

						<h1 class="">Sign In</h1>
						<p class="">Log in to your account to continue.</p>
						<?php if ($this->session->flashdata('msg')) { ?>
							<div class="alert alert-<?= $this->session->flashdata('msg_class') ?> alert-dismissible show">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<p class="alert-heading"> <?= $this->session->flashdata('msg') ?> </p>
							</div>
						<?php } ?>
						<form class="text-left" method="post">
							<div class="form">

								<div id="username-field" class="field-wrapper input">
									<label for="email">Email</label>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
										<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
										<circle cx="12" cy="7" r="4"></circle>
									</svg>
									<input id="email" name="email" value="<?php echo set_value('email'); ?>" type="email" class="form-control" placeholder="e.g John_Doe">
									<?php echo form_error('email'); ?>
								</div>

								<div id="password-field" class="field-wrapper input mb-2">
									<div class="d-flex justify-content-between">
										<label for="password">PASSWORD</label>
									</div>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
										<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
										<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
									</svg>
									<input id="password" name="password" type="password" value="<?php echo set_value('password'); ?>" class="form-control" placeholder="Password">
									<!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>--->
									<?php echo form_error('password'); ?>
								</div>
								<div class="d-sm-flex justify-content-between">
									<div class="field-wrapper mb-2">
										<button type="submit" class="btn btn-primary mb-3" value="">Log In</button>
									</div>
								</div>

							</div>
						</form>
						<a href="<?= base_url('users/index') ?>" class="mt-5 fs-1 fw-bold" style="font-size: 18px">Distributor/Dealer login</a>
					</div>
				</div>

			</div>
		</div>

	</div>


	<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
	<script src="<?= base_url('backend/') ?>assets/js/libs/jquery-3.1.1.min.js"></script>
	<script src="<?= base_url('backend/') ?>bootstrap/js/popper.min.js"></script>
	<script src="<?= base_url('backend/') ?>bootstrap/js/bootstrap.min.js"></script>

	<!-- END GLOBAL MANDATORY SCRIPTS -->
	<script src="<?= base_url('backend/') ?>assets/js/authentication/form-2.js"></script>

</body>

</html>