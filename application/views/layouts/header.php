<!DOCTYPE html>
<html>
<head>
	<title><?= $page_title ?></title>

	<!-- FOR JQUERY -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

	<!-- FOR BOOTSTRAP -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	
	<!-- FOR CUSTOM CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/styles.css">

	<!-- FOR FONT AWESOME -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<div class="preloader">
		<img src="<?= base_url();?>assets/uploads/preloader/preloader_logo.gif"></img>
	</div>
	<div class="header">
		<div class="left">
            <a href="<?= base_url(); ?>">AdU FacePay</a>
        </div>
		<div class="right">
			<ul>
	            <li>
	                <a href="#">Login</a>
	            </li>
	            <li>
	                <a href="<?= base_url();?>signup">Signup</a>
	            </li>
	            <li>
	            	<a href="#">About Us</a>
	            </li>
	        </ul>
		</div>
	</div>