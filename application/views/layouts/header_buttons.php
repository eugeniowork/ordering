<div class="preloader">
	<img src="<?= base_url();?>assets/uploads/preloader/preloader_logo.gif"></img>
</div>
<div class="header">
	<div class="left">
        <a href="<?= base_url(); ?>"><?= APPNAME ?></a>
    </div>
	<div class="right">
		<ul>
            <?php if ($this->session->userdata('user_id')): ?>
                <li>
                    <a class="btn-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="span-cart-total-item d-none">0</span>
                    </a>
                </li>
                <li>
                    <a class="header-btn-account">
                        <i class="fa fa-user-circle"></i>&nbsp;
                        <?= $this->session->userdata('user_firstname')." ".$this->session->userdata("user_lastname") ?>&nbsp;
                        <i class="fa fa-caret-down"></i>&nbsp;
                    </a>
                    <div class="header-dropdown-account">
                        <ul>
                            <li>
                                <button class="btn btn-primary btn-my-profile">My Profile</button>
                            </li>
                            <li>
                                <button class="btn btn-primary btn-logout">Logout</button>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= base_url();?>login">Login</a>
                </li>
                <li>
                    <a href="<?= base_url();?>signup">Signup</a>
                </li>
            <?php endif ?>
            
            <li>
            	<a href="#">About Us</a>
            </li>
        </ul>
	</div>
</div>

<script type="text/javascript" src="<?= base_url();?>/assets/js/layouts/header.js"></script>