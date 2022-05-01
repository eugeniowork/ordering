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
                                <button class="btn btn-primary btn-my-orders">My Orders</button>
                            </li>
                            <li>
                                <button class="btn btn-primary btn-logout">Logout</button>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="header-btn-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="span-cart-total-product d-none">0</span>
                    </a>
                    <div class="header-dropdown-cart">
                        <span class="bold-title">My Order</span>
                        <div class="loading-cart-product-container"></div>
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
                <a class="header-btn-notifications"><i class="fa fa-bell"></i>&nbsp;Notifications<span class="span-total-notif">9+</span></a>
                <div class="header-dropdown-notifications">
                    <span class="bold-title">Notification(s)</span>
                    <div class="notification-content" style="line-height: 23px">
                        <div class="notification-content-body">
                            <div class="row">
                                <div class="col-12 col-lg-2">
                                    <img src="https://hs.sbcounty.gov/cn/Photo%20Gallery/Sample%20Picture%20-%20Koala.jpg">
                                </div>
                                <div class="col-12 col-lg-10"><span class="description">This is sample notification only. This is sample notification only.This is sample notification only.This is sample notification only.This is sample notification only.</span></div>
                                <div class="col-12 col-lg-2"></div>
                                <div class="col-12 col-lg-10 date"><span>May 03, 2022</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
            	<a href="#">About Us</a>
            </li>
        </ul>
	</div>
</div>

<div class="modal fade" id="checkout_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <span>Date Pickup <span class="text-danger">*</span></span>
                    <input type="date" class="form-control date-pickup" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="warning text-danger"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-place-order">Place Order</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="global-loading">
    
</div>
<script type="text/javascript" src="<?= base_url();?>/assets/js/layouts/header.js"></script>