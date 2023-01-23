<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php print(htmlentities($pageTitle)); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><?php print(htmlentities($parentPage)); ?></li>
                            <li class="breadcrumb-item active"><?php print(htmlentities($pageTitle)); ?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"></span></h4>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"></span></h4>
                            <p class="text-muted mb-0">Total Orders</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"></span></h4>
                            <p class="text-muted mb-0">Total Revenue</p>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
        </div> <!-- end row-->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="float-right">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="font-weight-semibold">Filter By:</span> <span class="text-muted">This Year<i class="mdi mdi-chevron-down ml-1"></i></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="#">This Week</a>
                                    <a class="dropdown-item" href="#">This Month</a>
                                    <a class="dropdown-item" href="#">This Year</a>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title mb-4">Top Selling Products</h4>

                        <div data-simplebar style="max-height: 336px;">

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary mr-2"></i> Desktops </p>
                                </div>

                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                            style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                                            aria-valuemax="52">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info mr-2"></i> iPhones </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-info" role="progressbar"
                                            style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                            aria-valuemax="45">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success mr-2"></i> Android </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-success" role="progressbar"
                                            style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                                            aria-valuemax="48">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning mr-2"></i> Tablets </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                            style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                            aria-valuemax="78">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple mr-2"></i> Cables </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                            style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                            aria-valuemax="63">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary mr-2"></i> Desktops </p>
                                </div>

                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                            style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                                            aria-valuemax="52">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info mr-2"></i> iPhones </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-info" role="progressbar"
                                            style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                            aria-valuemax="45">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success mr-2"></i> Android </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-success" role="progressbar"
                                            style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                                            aria-valuemax="48">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning mr-2"></i> Tablets </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                            style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                            aria-valuemax="78">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center no-gutters mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple mr-2"></i> Cables </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                            style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                            aria-valuemax="63">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="float-right">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton2"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="font-weight-semibold">Filter By:</span>
                                    <span class="text-muted">This Year<i class="mdi mdi-chevron-down ml-1"></i></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item" href="#">This Week</a>
                                    <a class="dropdown-item" href="#">This Month</a>
                                    <a class="dropdown-item" href="#">This Year</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="card-title mb-4">Top Users</h4>

                        <div data-simplebar style="max-height: 336px;">
                            <div class="table-responsive">
                                <table class="table table-borderless table-centered table-nowrap">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20px;"><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Glenn Holden</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> 20 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$250.00</td>
                                        </tr>
                                        <tr>
                                            <td><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-5.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Lolita Hamill</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>10 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$110.00</td>
                                        </tr>
                                        <tr>
                                            <td><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-6.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Robert Mercer</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>25 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$420.00</td>
                                        </tr>
                                        <tr>
                                            <td><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-7.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Marie Kim</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>25 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                        </tr>
                                        <tr>
                                            <td><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-8.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Sonya Henshaw</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>25 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                        </tr>
                                        <tr>
                                            <td><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-2.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Marie Kim</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>25 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                        </tr>
                                        <tr>
                                            <td><img src="<?php print(base_url()); ?>assets/admin/images/users/avatar-1.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 font-weight-normal">Sonya Henshaw</h6>
                                                <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i>25 Jan 2021</p>
                                            </td>
                                            <td class="text-muted font-weight-semibold text-right"><i class="icon-xs icon mr-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!-- enbd table-responsive-->
                        </div> <!-- data-sidebar-->
                    </div><!-- end card-body-->
                </div> <!-- end card-->
            </div><!-- end col -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Orders</h4>
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Product</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>View Details</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container-fluid -->
</div>