<style type="text/css">
	.footer{
		top: 0px;
	}
	.header{
		background: none;
	}
	.page-container{
		top: unset;
	}
	.page-container .container-body{
		background: #e6d6c7 !important;
		padding-left: unset  !important;
	    padding-right: unset !important;
		padding-top: unset !important;
		padding-bottom: 0px;
	}
</style>
<div class="page-container home-containerv2">
	<div class="container-body" style="padding-top: 10px;">
		<div class="section-one-container">
			<div class="image">
				<img class="d-block" src="<?= base_url();?>assets/uploads/home/img4.png" alt="First slide">
			</div>
			<div class="description">
				<span class="title">START YOUR DAY WITH A GOOD QUALITY</span><br>
				<span class="sub-title">food and coffee</span><br>
				<span class="schedule">We're open daily from 9 am to 4 pm</span><br>
				<a href="<?= base_url();?>login" class="btn btn-primary">ORDER NOW</a>
			</div>
		</div>

		<div class="section-two-container">
			<div class="left-container">
				<div class="left-container-image" data-aos="fade-up" data-aos-duration="1000">
					<img class="d-block" src="<?= base_url();?>assets/uploads/home/img3.jpg" alt="First slide">
				</div><br>
				<div class="left-container-description" data-aos="fade-up" data-aos-duration="1000">
					<span><?= APPNAME ?>  provides a cozy and comfortable ambience. It is a perfect place to relax and have a coffee,</span>
				</div>
			</div>
			<div class="right-container">
				<div class="right-container-description" data-aos="fade-up" data-aos-duration="1000">
					<span><?= APPNAME ?></span>
				</div>
				<div class="right-container-image" data-aos="fade-up" data-aos-duration="1000">
					<img class="d-block" src="<?= base_url();?>assets/uploads/home/img1.jpg" alt="First slide">
				</div>
				
			</div>
		</div>

		<div class="section-three-container">
			<img class="d-block" src="<?= base_url();?>assets/uploads/home/img3.jpg" alt="First slide"  data-aos="fade-up" data-aos-duration="1000">
			<div class="buttons-container">
				<div class="d-flex flex-column justify-content-center align-items-center buttons-container-flex">
					<a href="<?= base_url();?>company/about-us" class="btn btn-primary">LEARN MORE</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>assets/js/home/home.js"></script>