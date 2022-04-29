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
                    <a class="header-btn-cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="span-cart-total-product d-none">0</span>
                    </a>
                    <div class="header-dropdown-cart">
                        <span class="bold-title">My Order</span>
                        <!-- <div class="cart-content">
                            <div class="cart-product">
                                <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Eq_it-na_pizza-margherita_sep2005_sml.jpg">
                                    </div>
                                    <div class="col-12 col-lg-5">
                                        <span>#product_name</span>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        #qty x #price
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <button class="btn-minus-product-qty" data-id="0"><i class="fa fa-minus"></i></button>
                                        <span>5</span>
                                        <button class="btn-add-product-qty" data-id="0"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="loading-cart-product-container"></div>
                        
                        <!-- <div class="row">
                            <div class="col-12 col-lg-8">
                                <span>Total Amount</span>
                            </div>
                            <div class="col-12 col-lg-4">
                                <span class="bold-title">1250</span>
                            </div>
                            <div class="col-12 col-lg-12">
                                <button class="btn btn-success" style="width: 100%">CHECKOUT</button>
                            </div>
                        </div> -->
                    </div>
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
                    <span>Date Pickup <span>*</span></span>
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