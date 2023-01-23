<?php

// Footer for admin login page
if ($pageCode == "AL" || $pageCode == "RP") { // Admin login
?><div class="account-pages">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center">
                    <p>© <?php print(date("Y")); ?> audioPustakam.</p>
                </div>
            </div>
        </div>
    </div>
</div><?php
		} else {
			?><footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <?php print(date("Y")); ?> © audioPustakam.
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div><?php
		}

			?>
<!-- JAVASCRIPT -->

<script src="<?php print(base_url()); ?>assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/simplebar/simplebar.min.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/node-waves/waves.min.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/jquery.counterup/jquery.counterup.min.js"></script>

<script src="<?php print(base_url()); ?>assets/admin/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Required datatable js -->
<script src="<?php print(base_url()); ?>assets/admin/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="<?php print(base_url()); ?>assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js">
</script>
<script
    src="<?php print(base_url()); ?>assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
</script>

<script src="<?php print(base_url()); ?>assets/admin/libs/select2/js/select2.min.js"></script>

<script src="<?php print(base_url()); ?>assets/admin/js/pages/ecommerce-add-product.init.js"></script>
<script src="<?php print(base_url()); ?>assets/admin/libs/summernote/summernote-bs4.min.js"></script>



<script>
$(document).ready(function() {
    <?php if ($pageCode == "UG") { //UG - User Groups BG - banner groups
			if ($pageCode == "UG") {
				$site_url = site_url("admin/user_groups");
			} 
		?>
    $(".datatable").DataTable({
        'order': [
            ["1", "asc"]
        ],
        'scrollX': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '<?php print($site_url); ?>',
            'data': {
                setAction: "ListRecord",
                datefrom: "<?php print($fltrDateFrom); ?>",
                dateto: "<?php print($fltrDateTo); ?>",
            }
        },
        'columns': [{
                data: 'DT'
            },
            {
                data: 'NM'
            },
            {
                data: 'BN'
            },
        ],
        'columnDefs': [{
            'targets': [1], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
        }]
    });
    <?php } else if ($pageCode == "US") { // Users
		?>
    $(".datatable").DataTable({
        'order': [
            ["0", "asc"]
        ],
        'scrollX': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '<?php print(site_url("admin/users")); ?>',
            'data': {
                setAction: "ListRecord",
                status: "<?php print($userStatus); ?>",
                group: "<?php print($userGroupId); ?>",
                datefrom: "<?php print($fltrDateFrom); ?>",
                dateto: "<?php print($fltrDateTo); ?>"
            }
        },
        'columns': [{
                data: 'CD'
            },
            {
                data: 'NM'
            },
            {
                data: 'EM'
            },
            {
                data: 'PH'
            },

            {
                data: 'UN'
            },
            {
                data: 'GN'
            },
            {
                data: 'AC'
            },
            {
                data: 'BN'
            },
        ],
        'columnDefs': [{
            'targets': [2, 5], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
        }]
    });
    <?php } else if ($pageCode == "ADP") {

			$site_url = site_url("admin/admin_pages"); ?>

    $(".datatable").DataTable({
        'order': [
            ["0", "asc"]
        ],
        'scrollX': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '<?php print($site_url); ?>',
            'data': {
                setAction: "ListRecord"
            }
        },
        'columns': [{
                data: 'CO'
            },
            {
                data: 'TL'
            },
            {
                data: 'BN'
            },
        ],
        'columnDefs': [{
            'targets': [2], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
        }]
    });

    <?php } else if ($pageCode == "ASP") {
            $site_url = $site_url = site_url("admin/admin_pages/sub_items/" . $parent_id);
			 ?>

    $(".datatable").DataTable({
        'order': [
            ["1", "asc"]
        ],
        'scrollX': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '<?php print($site_url); ?>',
            'data': {
                setAction: "ListRecord"
            }
        },
        'columns': [{
                data: 'CO'
            },
            {
                data: 'FU'
            },
            {
                data: 'TL'
            },
            {
                data: 'AT'
            },
            {
                data: 'BN'
            },
        ],
        'columnDefs': [{
            'targets': [4], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
        }]
    });
    
    <?php } else if ($pageCode == "CS") {

            $site_url = site_url("admin/customer"); ?>

    $(".datatable").DataTable({
        'order': [
            ["0", "asc"]
        ],
        'scrollX': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '<?php print($site_url); ?>',
            'data': {
                setAction: "ListRecord"
            }
        },
        'columns': [{
                data: 'AD'
            },
            {
                data: 'NM'
            },
            {
                data: 'EM'
            },
            {
                data: 'PH'
            },
            {
                data: 'BN'
            }
        ],
        'columnDefs': [{
            'targets': [2], // column index (start from 0)
            'orderable': false, // set orderable false for selected columns
        }]
    });

    <?php }  else  { ?>
    $(".datatable").DataTable({
        'order': [
            [0, "asc"]
        ],
        //'scrollX': true
    });
    <?php } ?>
});

</script>

<script src="<?php print(base_url()); ?>assets/admin/js/app.js"></script>






</body>

<!-- Mirrored from themesbrand.com/minible/layouts/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Oct 2020 10:57:22 GMT -->

</html>