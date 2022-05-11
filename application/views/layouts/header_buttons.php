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
                <?php if ($this->session->userdata('user_type') == "user"): ?>
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
                <?php endif ?>
                <li>
                    <a class="header-btn-account">
                        <i class="fa fa-user-circle"></i>&nbsp;
                        <?= $this->session->userdata('user_firstname')." ".$this->session->userdata("user_lastname") ?>&nbsp;
                        <i class="fa fa-caret-down"></i>&nbsp;
                    </a>
                    <div class="header-dropdown-account">
                        <ul>
                            <li>
                                <button class="btn btn-primary btn-my-profile"><i class="fas fa-address-card"></i>&nbsp;My Profile</button>
                            </li>
                            <li>
                                <button class="btn btn-primary btn-logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</button>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="header-btn-notifications"><i class="fa fa-bell"></i>&nbsp;Notifications<span class="span-total-notif d-none">9+</span></a>
                    <div class="header-dropdown-notifications">
                        <span class="bold-title">Notification(s)</span>
                        <div class="notification-content" style="line-height: 23px">
                            <div class="notification-content-body">
                            </div>
                        </div>
                        <div class="loading-notifications-container"></div>
                    </div>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= base_url();?>login">Login</a>
                </li>
                <li>
                    <a href="<?= base_url();?>signup">Signup</a>
                </li>
                <li>
                    <a href="#">About Us</a>
                </li>
            <?php endif ?>
        </ul>
	</div>
</div>

<?php if ($this->session->userdata('user_id')): ?>

<div class="side-navbar-container">
    <div class="side-navbar-content">
        <div class="side-navbar-header">
            <img src="<?= base_url().LOGO ?>">
        </div>
        <div class="side-navbar-body">
            <!-- FOR PRODUCT MANAGEMENT -->
            <?php if ($this->session->userdata("user_type") == "admin"): ?>
                <a href="<?= base_url(); ?>product"><i class="fa-solid fa-box"></i>&nbsp;&nbsp;Product</a><br>
            <?php endif ?>

            <!-- FOR FACE PAY WALLET -->
            <button class="btn-menu" id="facepay_wallet" data-id="sub_menu_facepay_wallet"><i class="fa-solid fa-wallet"></i>&nbsp;&nbsp;FacePay Wallet<i class="fa-solid fa-caret-down caret"></i></button>
            <div class="facepay-wallet-dropdown sub-buttons" id="sub_menu_facepay_wallet">
                <?php if ($this->session->userdata("user_type") == "admin"): ?>
                    <a href="<?= base_url();?>cash-in"><i class="fa-solid fa-wallet"></i>&nbsp;&nbsp;Cash In</a><br>
                    <a href="<?= base_url();?>wallet-transaction"><i class="fa-solid fa-repeat"></i>&nbsp;&nbsp;Transaction</a>
                <?php else: ?>
                    <a href="<?= base_url()?>my-wallet"><i class="fa-solid fa-wallet"></i>&nbsp;&nbsp;My Wallet</a>
                <?php endif ?>
            </div><br>

            <!-- FOR ORDER MANAGEMENT -->
            <button class="btn-menu" id="order_management" data-id="sub_menu_order_management"><i class="fa-solid fa-bars-progress"></i>&nbsp;&nbsp;Order Management<i class="fa-solid fa-caret-down caret"></i></button>
            <div class="order-management-dropdown sub-buttons" id="sub_menu_order_management">
                <?php if ($this->session->userdata("user_type") == "admin"): ?>
                    <a href="<?= base_url(); ?>ongoing-orders"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;Ongoing Orders</a>
                <?php else: ?>
                    <a href="<?= base_url(); ?>dashboard"><i class="fa-solid fa-cart-plus"></i>&nbsp;&nbsp;Add Order</a><br>
                    <a href="<?= base_url(); ?>my-orders"><i class="fas fa-clipboard-check"></i>&nbsp;&nbsp;My Orders</a>                
                <?php endif ?>
            </div><br>

            <?php if ($this->session->userdata("user_type") == "admin"): ?>
                <!-- FOR USER MANAGEMENT -->
                <button class="btn-menu" id="user_management" data-id="sub_menu_user_management"><i class="fa-solid fa-users"></i>&nbsp;&nbsp;User Management<i class="fa-solid fa-caret-down caret"></i></button>
            <?php endif ?>
            <div class="user-management-dropdown sub-buttons" id="sub_menu_user_management">
                <a href="<?= base_url(); ?>customer"><i class="fa-solid fa-users-line"></i>&nbsp;&nbsp;Customer</a><br>
                <a href="<?= base_url(); ?>employee"><i class="fas fa-user-tie"></i>&nbsp;&nbsp;Employee</a>
            </div><br>
        </div>
    </div>
    <button class="btn-toggle-menu" style="right: 4px; z-index: 300;"><i class="fas fa-bars"></i></button>
</div>
<button class="btn-toggle-menu btn-show-menu" style="z-index: 200; left: 0px;position: fixed;"><i class="fas fa-bars"></i></button>

<?php endif; ?>

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

<div class="global-loading"></div>

<script type="text/javascript" src="<?= base_url();?>/assets/js/layouts/header.js"></script>
<script type="text/javascript" src="<?= base_url();?>/assets/js/layouts/header-side-bar-buttons.js"></script>