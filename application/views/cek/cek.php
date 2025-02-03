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
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.css">
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/logo.png" type="image/x-icon">
</head>

<body>
	<div id="app">
		<div class="d-flex align-items-center justify-content-center vh-100">
			<div class="login-panel">
				<?php echo form_open("dashboard/cek"); ?>
				<div class="mb-3 form-control-sm text-center">
					<img src="<?php echo base_url() ?>assets/images/logo.png" alt="" class="img-logo">
				</div>
				<div class="mb-4 form-control-sm block-panel">
					<div class="text-center">
						<p class="intro-text">Upaya Pencegahan dan Penanggulangan Praktik Manipulasi Dokumen di Lingkungan Lembaga atau Instansi Pendidikan</p>
					</div>
				</div>
				<?php echo $message; ?>
				<div class="mb-4 form-control-md">
					<input type="text" name="nomor_sertifikat" class="form-control-lg w-100" placeholder="Nomor Sertifikat">
				</div>
				<div class="mb-4 form-control-md">
					<div class="d-flex">
						<img src="<?php echo base_url('dashboard/img_captcha') ?>" alt="PHP Captcha">
						<input type="text" name="captcha_code" class="form-control" placeholder="Captcha">
					</div>
				</div>
				<div class="mb-3 form-control-md">
					<button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-square"></i> Verifikasi</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

</body>

</html>