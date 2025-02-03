<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sie-VA</title>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/iconly/bold.css">

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/logo.png" type="image/x-icon">
</head>

<body>
	<div id="app">
		<div id="sidebar" class="active">
			<div class="sidebar-wrapper active">
				<div class="sidebar-header pb-0">
					<div class="d-flex justify-content-between">
						<div class="">
							<h3 class="mb-0 mt-3">Sie-VA</h3>
							<h6 class="mb-0" style="font-size:13px;">Sistem Informasi Elektronik Validasi</h6>
						</div>
						<div class="toggler">
							<a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
						</div>
					</div>
				</div>
				<div class="sidebar-menu">
					<ul class="menu">
						<li class="sidebar-item <?php echo $active == 'ganti-password' ? 'active' : '' ?>">
							<a href="<?php echo base_url('change_password') ?>" class='sidebar-link'>
								<i class="bi bi-key"></i>
								<span>Ganti Password</span>
							</a>
						</li>

						<li class="sidebar-item <?php echo $active == 'download-template' ? 'active' : '' ?>">
							<a href="<?php echo base_url('sertifikat/export_template') ?>" class='sidebar-link'>
								<i class="bi bi-layout-text-window"></i>
								<span>Download Template</span>
							</a>
						</li>

						<li class="sidebar-item <?php echo $active == 'upload-template' ? 'active' : '' ?>">
							<a href="<?php echo base_url() ?>" class='sidebar-link'>
								<i class="bi bi-upload"></i>
								<span>Upload Template</span>
							</a>
						</li>

						<li class="sidebar-item <?php echo $active == 'printer' ? 'active' : '' ?>">
							<a href="<?php echo base_url('print_doc') ?>" class='sidebar-link'>
								<i class="bi bi-printer"></i>
								<span>Print</span>
							</a>
						</li>

						<li class="sidebar-item">
							<a href="<?php echo base_url('logout') ?>" class='sidebar-link'>
								<i class="bi bi-skip-end"></i>
								<span>Logout</span>
							</a>
						</li>

					</ul>
				</div>
				<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
			</div>
		</div>
		<div id="main">
			<header class="mb-3">
				<a href="#" class="burger-btn d-block d-xl-none">
					<i class="bi bi-justify fs-3"></i>
				</a>
			</header>
			<div class="d-flex justify-content-end mb-2">
				<div class="d-flex">
					<a href="<?php echo base_url('/') ?>" class="ms-4 fw-bold">Home</a>
					<a href="<?php echo base_url('about') ?>" class="ms-4 fw-bold">About</a>
					<a href="<?php echo base_url('contact') ?>" class="ms-4 fw-bold">Contact</a>
					<?php if ($is_login) { ?>
						<a href="<?php echo base_url('logout') ?>" class="ms-4 fw-bold">Logout</a>
					<?php } else { ?>
						<a href="<?php echo base_url('login') ?>" class="ms-4 fw-bold">Login</a>
					<?php } ?>
				</div>
			</div>