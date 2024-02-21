<!doctype html>
<html lang="en" ng-app="KidyViewStudent">
<head>
    <title>Kidy</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content=" " />
    <meta name="keywords" content=" " />
    <meta name="author" content=" " />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>teacherasset/img/favicon.png" />
    <!-- Common CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/fonts/icomoon/icomoon.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/morris/morris.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/all.css" />
    <!-- Chartist css -->
    <link href="<?php echo base_url(); ?>teacherasset/css/chartist/chartist.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>teacherasset/css/chartist/chartist-custom.css" rel="stylesheet" />
    <!-- global css -->
    <link href="<?php echo base_url(); ?>teacherasset/css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/global.css" />
      <!-- database css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/datatables/dataTables.bs4-custom.css" />
    <script src="<?php echo base_url(); ?>teacherasset/js/jquery.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular.min.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-route.min.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-animate.min.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-loader.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-sanitize.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/dirPagination.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/customDirPagination.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/ng-file-upload-all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <link href="<?php echo base_url(); ?>asset/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <script src="<?php echo base_url(); ?>teacherasset/js/multiselect.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/appTeacher.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/controllersTeacher.js"></script>
    <script src="<?php echo base_url(); ?>adminasset/js/ngdatatable/angular-datatables.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/js/ngdatatable/css/angular-datatables.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/bootstrap-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/bootstrap-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/core-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/core-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/daygrid-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/daygrid-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/list-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/list-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/timegrid-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/timegrid-main.min.css">
    
   <script> 
   var BASE_URL 		= '<?php echo base_url(); ?>'; 
   var schoolID 		= '<?php echo $TEACHERDATA->schoolId;?>'; 
   var xapikey 		= 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
   </script>
   
</head>

<body>
    <!-- start app wrap -->
    <div class="app-wrap">
        <?php
    // print_r($demo);die('czXczxv');
        $this->load->view('header-menu');?>
        <!-- start app container -->
        <div class="app-container">
        <?php $this->load->view('sidebar-menu');?>
            <!-- BEGIN .app-main -->
            <div style="width:100%" ng-view ng-animate="{enter: 'view-enter'}"></div>
            <!-- END: .app-main -->
        </div>
        <!-- END: .app-container -->
        <!-- BEGIN .main-footer -->
<footer class="main-footer fixed-btm">
    Copyright kidyview.admin 2019.
</footer>
<!-- END: .main-footer -->
</div>
<!-- END: .app-wrap -->

<script src="<?php echo base_url(); ?>teacherasset/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/unifyMenu.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/onoffcanvas.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/moment.js"></script>
<!-- Morris Graphs -->
<script src="<?php echo base_url(); ?>teacherasset/js/morris/raphael-min.js"></script>
<!-- Data Tables -->
<script src="<?php echo base_url(); ?>teacherasset/js/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/datatables/custom-datatables.js"></script>
<!-- Flot Charts -->
<script src="<?php echo base_url(); ?>teacherasset/js/flot/jquery.flot.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/flot/jquery.flot.stack.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/flot/line.js"></script>
<!-- Newsticker JS -->
<script src="<?php echo base_url(); ?>teacherasset/js/newsticker/newsTicker.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/newsticker/custom-newsTicker.js"></script>
<!-- Form Wizard -->
<script src="<?php echo base_url(); ?>teacherasset/js/formwizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/form-validation.js"></script>
<!-- Multiple Select -->

<!-- Data Tables -->
<script src="<?php echo base_url(); ?>teacherasset/js/slimscroll/slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/slimscroll/custom-scrollbar.js"></script>
<!-- Common JS -->
<script src="<?php echo base_url(); ?>asset/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>studentasset/js/common.js"></script>
<script src="<?php echo base_url(); ?>asset/js/ui-calendar/calendar.js"></script>
<script src="<?php echo base_url(); ?>asset/js/ui-calendar/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/angularjs-dropdown-multiselect.min.js"></script>
</body>
</html>