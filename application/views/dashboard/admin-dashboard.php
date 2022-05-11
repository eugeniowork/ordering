<div class="page-container summary-container">
    <div class="container-header">
        <span class="header-title">Dashboard</span><br>
    </div>
    <div class="container-body">
        <br>
        <div class="summary-numbers-container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="col-lg-4">
                           <h1><span class="fas text-primary fa-box py-3 px-4 rounded-circle border border-primary"></span></h1>
                        </div>
                        <div class="col-lg-8">
                            <span class="value"><?= $total_stocks ?></span><br>
                            <span class="title">Products in Stock</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <h1><span class="fa text-primary fa-chart-bar py-3 px-4 rounded-circle border border-primary"></span></h1>
                        </div>
                        <div class="col-12 col-lg-8">
                            <span class="value"><span>&#8369;</span><?= number_format($revenue, 2) ?></span><br>
                            <span class="title">Revenue this month</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <h1><span class="fa text-primary fa-clipboard-check py-3 px-4 rounded-circle border border-primary"></span></h1>
                        </div>
                        <div class="col-12 col-lg-8">
                            <span class="value"><?= (int)$orders_this_week; ?></span><br>
                            <span class="title">Orders this month</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <h1><span class="text-primary fa-solid fa-users-line py-3 px-3 rounded-circle border border-primary"></span></h1>
                        </div>
                        <div class="col-12 col-lg-8">
                            <span class="value"><?= $customers ?></span><br>
                            <span class="title">Customers</span>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="graph-container">
                <div class="row grap-content">
                    <div class="col-12 col-lg-6">
                        <center>
                            <span>Orders Graph</span>
                            <select class="filter-order-graph" style="float:right">
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </center>
                        <div class="order-graph-container d-none">
                            <canvas id="order_graph_canvas" ></canvas>
                        </div>
                        <div class="order-graph-process-loading-container"></div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <center>
                            <span>Orders Graph</span>
                            <select class="filter-revenue-graph" style="float:right">
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </center>
                        <div class="revenue-graph-container d-none">
                            <canvas id="revenue_graph_canvas" ></canvas>
                        </div>
                        <div class="revenue-graph-process-loading-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url();?>/assets/js/dashboard/admin-dashboard.js"></script>